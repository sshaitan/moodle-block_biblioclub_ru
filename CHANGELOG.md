# Changelog

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
