# Changelog

## 2026-10-12 - v0.0.7

- Addressed Moodle review #1: return cached block content before rendering again.
- Initialise empty text for users without block capabilities; preserve Moodle link attributes.
- Addressed Moodle review #2: declare visit-table and external authentication metadata;
  implement context/user discovery, scoped export and all privacy deletion methods.
- Added privacy isolation and rendering regression tests.
- Minimum Moodle version is now 3.5.3 for the Privacy user-list API.
- Disabled automatic Moodle Plugins Directory submission on tag push.

## 2026-09-16 - v0.0.6

- Added full seamless-login support for the redesigned `biblioclub.ru`
  storefront.
- Switched browser authentication from the legacy compatibility host to the
  primary EBS site.
- Switched the organization-login signature from MD5 to SHA-512.
- Verified first-time authentication in a clean browser context and session
  persistence after a full page reload.

## 2026-09-14 - v0.0.5

- Restored seamless authentication after the Biblioclub storefront redesign.
- Routed the browser authentication handshake through the official legacy
  compatibility host.
- Verified installation and authentication on Moodle 5.2.2 with PHP 8.4.
