# Moodle Plugins Directory review follow-up — v0.0.7

Version: `2026101200`, release `0.0.7`, tag `v0.0.7` (12 October 2026).

## Findings addressed

| Issue | Implementation | Verification |
| --- | --- | --- |
| [#1](https://github.com/sshaitan/moodle-block_biblioclub_ru/issues/1) | `get_content()` returns cached content immediately; text is initialised even without capabilities. | Same content object on a second call; no additional database queries; guest rendering. |
| [#2](https://github.com/sshaitan/moodle-block_biblioclub_ru/issues/2) | Database and external-location metadata; context/user discovery; export; single-user, bulk-user and context deletion. | Privacy isolation tests for system/course/user contexts and empty approvals; Moodle core provider checks. |

The visit table stores Moodle user ID, originating context ID and timestamp.
External authentication sends Moodle user ID, username (possibly an email address),
first/last/optional middle name, organisation domain and request timestamp.
Deleting local visits does not delete data or accounts at Biblioclub. Contact the
external service for those requests. English and Russian privacy strings are provided.

## Verification environment

- Moodle 5.2.2, PHP 8.4.25, PostgreSQL 16.
- Both plugin upgrades and PHP syntax checks passed.
- Combined plugin suite: 18 tests (rendering, privacy and offline HTTP/authentication).
- The module also has two offline JavaScript modal compatibility cases; its actual
  picker was used to search, select and save a book in the local Moodle course.
- Moodle core privacy provider checks passed for both components.
- A clean Playwright browser traversed the local Moodle block redirect to the
  production redesigned `biblioclub.ru`, authenticated the existing test user,
  removed signed query parameters and retained authentication after reload.
- No production SQL writes, new production test accounts or stored signed URLs/cookies.

Minimum required Moodle is 3.5.3 (`2018051703`) for the Privacy user-list API.
The minimum is an API requirement, not a claim that every older Moodle release
was tested. There is no database-schema migration in this release.

## Repeating automated checks

Configure a separate PHPUnit data directory and database prefix in a **development**
Moodle installation; never initialise PHPUnit against a production database prefix.
Install both plugins, initialise Moodle PHPUnit and run from the Moodle root:

```bash
php public/admin/tool/phpunit/cli/init.php --disable-composer
vendor/bin/phpunit --testsuite block_biblioclub_ru_testsuite,mod_biblioclubrubook_testsuite
vendor/bin/phpunit --filter biblioclub public/privacy/tests/privacy/provider_test.php
vendor/bin/phpunit --filter biblioclub public/privacy/tests/privacy/provider_advanced_test.php
```

These paths are for Moodle 5.2's public-directory layout; on older Moodle versions
the PHPUnit scripts and component directories are directly under the Moodle root.
The HTTP unit tests are offline and require no Biblioclub organisation secret.

## Suggested resubmission message

> Please review block_biblioclub_ru v0.0.7 together with mod_biblioclubrubook v1.10.
> The two findings for the block have been addressed: cached block content and a
> complete Privacy API implementation for visit history and external authentication.
> Regression tests and the verification results are documented in this repository.
> The book module depends on this block for organisation settings, so approval of
> the block is still a prerequisite for approving the module.

Submission and approval are separate from GitHub releases. Tag pushes no longer
submit to Moodle.org automatically; the repository owner submits the ZIPs manually.
