# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.2.0 - TBD

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.


## 2.1.0

### Changes

### 🚀 Features

- Add combined assets [@core23] ([#59])

### 📦 Dependencies

- Add support for sonata/block-bundle 3 [@core23] ([#66])
- Bump [@symfony]/webpack-encore from 0.27.0 to 0.30.2 [@dependabot] ([#63])
- Bump eslint-loader from 2.2.1 to 4.0.2 [@dependabot] ([#64])
- Bump [@babel]/preset-env from 7.10.2 to 7.10.3 [@dependabot] ([#62])
- Bump [@babel]/core from 7.10.2 to 7.10.3 [@dependabot] ([#65])

## 2.0.0

### Changed

* Renamed namespace `Core23\GDPRBundle` to `Nucleos\GDPRBundle` after move to [@nucleos]

  Run

  ```
  $ composer remove core23/gdpr-bundle
  ```

  and

  ```
  $ composer require nucleos/gdpr-bundle
  ```

  to update.

  Run

  ```
  $ find . -type f -exec sed -i '.bak' 's/Core23\\GDPRBundle/Nucleos\\GDPRBundle/g' {} \;
  ```

  to replace occurrences of `Core23\GDPRBundle` with `Nucleos\GDPRBundle`.

  Run

  ```
  $ find -type f -name '*.bak' -delete
  ```

  to delete backup files created in the previous step.

## 1.5.0

### Changes

- Remove oppressive language [@core23] ([#48])

## 1.4.0

### Changes

### 🚀 Features

- Block all cookies if not consent [@core23] ([#45])

### 📦 Dependencies

- Bump symfony versions [@core23] ([#47])

## 1.3.1

### 🐛 Bug Fixes

- Fix consuming JavaScript event [@core23] ([#42])

## 1.3.0

### Changes

- Add missing strict file header [@core23] ([#33])

### 📦 Dependencies

- Add support for symfony 5 [@core23] ([#24])
- Drop support for symfony 3 [@core23] ([#35])
- Drop Sonata CoreBundle dependency [@core23] ([#34])

[#66]: https://github.com/nucleos/NucleosGDPRBundle/pull/66
[#65]: https://github.com/nucleos/NucleosGDPRBundle/pull/65
[#64]: https://github.com/nucleos/NucleosGDPRBundle/pull/64
[#63]: https://github.com/nucleos/NucleosGDPRBundle/pull/63
[#62]: https://github.com/nucleos/NucleosGDPRBundle/pull/62
[#59]: https://github.com/nucleos/NucleosGDPRBundle/pull/59
[#48]: https://github.com/nucleos/NucleosGDPRBundle/pull/48
[#47]: https://github.com/nucleos/NucleosGDPRBundle/pull/47
[#45]: https://github.com/nucleos/NucleosGDPRBundle/pull/45
[#42]: https://github.com/nucleos/NucleosGDPRBundle/pull/42
[#35]: https://github.com/nucleos/NucleosGDPRBundle/pull/35
[#34]: https://github.com/nucleos/NucleosGDPRBundle/pull/34
[#33]: https://github.com/nucleos/NucleosGDPRBundle/pull/33
[#24]: https://github.com/nucleos/NucleosGDPRBundle/pull/24
[@symfony]: https://github.com/symfony
[@nucleos]: https://github.com/nucleos
[@dependabot]: https://github.com/dependabot
[@core23]: https://github.com/core23
[@babel]: https://github.com/babel
