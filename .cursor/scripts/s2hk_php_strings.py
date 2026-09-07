#!/usr/bin/env python3
"""Convert Simplified Chinese string literals in PHP/HTM to HK Traditional (s2hk).
Also applies ACFUN→BR rebranding replacements on text content.
Does not touch non-string PHP code identifiers.
"""
from __future__ import annotations
import argparse
import re
import subprocess
import sys
from pathlib import Path

REBRAND = [
    # spaced title form first (order matters: longer/more specific first)
    ("ACFUN 大 逃 杀", "BR大逃殺"),
    ("ACFUN 大 逃 殺", "BR大逃殺"),
    ("ＡＣＦＵＮ 大 逃 杀", "BR大逃殺"),
    ("ＡＣＦＵＮ大逃杀", "BR大逃殺"),
    ("ACFUN大逃杀攻略", "BR大逃殺攻略"),
    ("ACFUN大逃殺攻略", "BR大逃殺攻略"),
    ("ACFUN大逃杀", "BR大逃殺"),
    ("ACFUN大逃殺", "BR大逃殺"),
    ("AC大逃杀", "BR大逃殺"),
    ("AC大逃殺", "BR大逃殺"),
    ("ACFUN动漫祭", "生存遊戲"),
    ("ACFUN動漫祭", "生存遊戲"),
    ("【ACFUN的荣耀】", "【BR的榮耀】"),
    ("【ACFUN的榮耀】", "【BR的榮耀】"),
    ("ACFUN的账号", "BR的賬號"),
    ("ACFUN的帳號", "BR的賬號"),
    ("ACFUN的账号", "BR的賬號"),
    ("ACFUN贴吧", "BR討論區"),
    ("ACFUN貼吧", "BR討論區"),
]

SKIP_DIR_NAMES = {
    ".git", "vendor", "node_modules", "img", "map", "pastlogs",
    "bothost", "bot", "nginx", "install", "doc",
}
SKIP_FILE_NAMES = {
    "LICENSE", "README.md", "AGENTS.md", "Dockerfile",
    "docker-compose.yml", "rector.php", "config.inc.php",
    "config.inc.php.bak", "config.inc.php.sample",
}
SKIP_SUFFIXES = {
    ".jpg", ".jpeg", ".png", ".gif", ".ico", ".webp", ".mp3",
    ".ogg", ".wav", ".zip", ".gz", ".tar", ".bin", ".swf",
    ".ttf", ".woff", ".woff2", ".eot", ".pdf", ".bak",
}

HAS_CJK = re.compile(r"[\u4e00-\u9fff]")
SEP = "\n<<<PHPDts_S2HK_SEP>>>\n"

_cc_cache = {}

def opencc_s2hk(text: str) -> str:
    if not HAS_CJK.search(text):
        return text
    if text in _cc_cache:
        return _cc_cache[text]
    p = subprocess.run(
        ["opencc", "-c", "s2hk"],
        input=text.encode("utf-8"),
        stdout=subprocess.PIPE,
        stderr=subprocess.PIPE,
        check=True,
    )
    out = p.stdout.decode("utf-8")
    _cc_cache[text] = out
    return out

def opencc_s2hk_many(texts: list[str]) -> list[str]:
    """Batch convert; preserve non-CJK as-is."""
    if not texts:
        return []
    need = []
    idxs = []
    for i, t in enumerate(texts):
        if HAS_CJK.search(t):
            if t in _cc_cache:
                continue
            idxs.append(i)
            need.append(t)
        # else leave as-is
    if need:
        blob = SEP.join(need)
        p = subprocess.run(
            ["opencc", "-c", "s2hk"],
            input=blob.encode("utf-8"),
            stdout=subprocess.PIPE,
            stderr=subprocess.PIPE,
            check=True,
        )
        converted = p.stdout.decode("utf-8").split(SEP)
        if len(converted) != len(need):
            # fallback one-by-one
            converted = [opencc_s2hk(x) for x in need]
        for src, dst in zip(need, converted):
            _cc_cache[src] = dst
    out = []
    for t in texts:
        if HAS_CJK.search(t):
            out.append(_cc_cache.get(t, t) if t in _cc_cache else opencc_s2hk(t))
        else:
            out.append(t)
    return out

def apply_rebrand(text: str) -> str:
    for a, b in REBRAND:
        text = text.replace(a, b)
    return text

def _iter_php_string_spans(src: str):
    """Yield (kind, start, end, content_start, content_end) for convertible spans.
    kind in {"sq","dq","heredoc"}.
    """
    i = 0
    n = len(src)
    while i < n:
        ch = src[i]
        if ch == "/" and i + 1 < n:
            nxt = src[i + 1]
            if nxt == "/":
                j = src.find("\n", i)
                i = n if j < 0 else j
                continue
            if nxt == "*":
                j = src.find("*/", i + 2)
                i = n if j < 0 else j + 2
                continue
        if ch == "#":
            j = src.find("\n", i)
            i = n if j < 0 else j
            continue
        if ch == "<" and src.startswith("<<<", i):
            m = re.match(r"<<<(['\"]?)([A-Za-z_][A-Za-z0-9_]*)\1\r?\n", src[i:])
            if m:
                end_pat = "\n" + m.group(2)
                start_content = i + m.end()
                j = src.find(end_pat, start_content)
                if j < 0:
                    return
                k = j + len(end_pat)
                while k < n and src[k] in " \t":
                    k += 1
                if k < n and src[k] == ";":
                    k += 1
                yield ("heredoc", i, k, start_content, j)
                i = k
                continue
        if ch in ("'", '"'):
            quote = ch
            j = i + 1
            while j < n:
                c = src[j]
                if c == "\\" and j + 1 < n:
                    j += 2; continue
                if c == quote:
                    yield ("sq" if quote == "'" else "dq", i, j + 1, i + 1, j)
                    i = j + 1
                    break
                j += 1
            else:
                return
            continue
        i += 1

def convert_php_string_literals(src: str) -> tuple[str, int]:
    spans = list(_iter_php_string_spans(src))
    if not spans:
        return src, 0
    contents = [src[cs:ce] for (_, _, _, cs, ce) in spans]
    converted = opencc_s2hk_many(contents)
    converted = [apply_rebrand(x) for x in converted]
    changed = sum(1 for a, b in zip(contents, converted) if a != b)
    if changed == 0:
        return src, 0
    parts = []
    last = 0
    for (kind, s, e, cs, ce), newc in zip(spans, converted):
        parts.append(src[last:cs])
        parts.append(newc)
        last = ce
    parts.append(src[last:])
    return "".join(parts), changed

def convert_htm(src: str) -> tuple[str, int]:
    """Convert HTML/template text; protect script/style blocks from breakage by converting whole file carefully.
    HTML templates here are mostly Chinese UI; convert whole content with opencc then rebrand.
    """
    # Protect PHP-like template tags? They use <!--{ }--> and {$var} — ASCII mostly.
    new = apply_rebrand(opencc_s2hk(src))
    return new, (0 if new == src else 1)

def should_skip(path: Path, root: Path) -> bool:
    rel = path.relative_to(root)
    parts = set(rel.parts)
    if parts & SKIP_DIR_NAMES:
        return True
    if path.name in SKIP_FILE_NAMES:
        return True
    if path.suffix.lower() in SKIP_SUFFIXES:
        return True
    # skip compiled template cache binaries? they're .tpl.php — we delete them instead
    if "gamedata/templates" in str(rel).replace("\\", "/"):
        return True
    return False

def process_file(path: Path) -> str:
    try:
        raw = path.read_text(encoding="utf-8")
    except UnicodeDecodeError:
        return "skip-bin"
    if not HAS_CJK.search(raw):
        return "no-cjk"
    suf = path.suffix.lower()
    if suf == ".php":
        new, n = convert_php_string_literals(raw)
    elif suf in {".htm", ".html", ".txt", ".md", ".css", ".js"}:
        # for md only if not skipped; convert as text
        new, n = convert_htm(raw)
    else:
        return "skip-ext"
    if new != raw:
        path.write_text(new, encoding="utf-8")
        return f"changed:{n}"
    return "unchanged"

def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("paths", nargs="+")
    ap.add_argument("--root", default="/workspace/phpdts")
    args = ap.parse_args()
    root = Path(args.root)
    stats = {}
    for spec in args.paths:
        p = Path(spec).resolve()
        paths = sorted(p.rglob("*")) if p.is_dir() else [p]
        for path in paths:
            if not path.is_file():
                continue
            if should_skip(path, root):
                stats["skipped"] = stats.get("skipped", 0) + 1
                continue
            r = process_file(path)
            stats[r.split(":")[0]] = stats.get(r.split(":")[0], 0) + 1
            if r.startswith("changed"):
                print(f"OK {path.relative_to(root)} ({r})")
    print("STATS", stats)

if __name__ == "__main__":
    main()
