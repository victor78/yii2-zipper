# Security Policy

## Supported Versions

| Version | Supported              |
|---------|------------------------|
| 1.x     | ✅ Active support      |
| 0.x     | ⚠️ Critical fixes only |

## Reporting a Vulnerability

Please **do not** open a public GitHub issue for security vulnerabilities.

Report vulnerabilities by opening a [GitHub Security Advisory](https://github.com/victor78/yii2-zipper/security/advisories/new)
or by contacting the maintainer directly via the profile on GitHub.

**Please include:**
- Description of the vulnerability
- Steps to reproduce
- Affected versions
- Potential impact

You will receive a response within 72 hours. If the vulnerability is confirmed,
a patch will be released as soon as possible.

## Notes

This package is a thin Yii2 component over [ZippyExt](https://github.com/victor78/ZippyExt).
Most archiving and process-execution concerns (including `symfony/process` CVEs) are
handled in ZippyExt — see its [SECURITY.md](https://github.com/victor78/ZippyExt/blob/master/SECURITY.md).
The `1.x` line of Yii2-Zipper requires `victor78/zippy-ext: ^1.0`, which ships the
patched dependency stack.
