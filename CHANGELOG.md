# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.6.0 - TBD

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

## 2.5.0 - 2023-04-29


-----

### Release Notes for [2.5.0](https://github.com/nucleos/NucleosGDPRBundle/milestone/8)

Feature release (minor)

### 2.5.0

- Total issues resolved: **0**
- Total pull requests resolved: **8**
- Total contributors: **3**

#### dependency

 - [820: Drop symfony 6.1 support](https://github.com/nucleos/NucleosGDPRBundle/pull/820) thanks to @core23
 - [818: Update dependency webpack to v5.76.0 &#91;SECURITY&#93;](https://github.com/nucleos/NucleosGDPRBundle/pull/818) thanks to @renovate[bot]
 - [813: Update frontend dependencies](https://github.com/nucleos/NucleosGDPRBundle/pull/813) thanks to @core23
 - [812: Drop support for PHP 8.0](https://github.com/nucleos/NucleosGDPRBundle/pull/812) thanks to @core23
 - [811: Update dependency phpunit/phpunit to v10](https://github.com/nucleos/NucleosGDPRBundle/pull/811) thanks to @renovate[bot]
 - [805: Bump loader-utils from 2.0.3 to 2.0.4](https://github.com/nucleos/NucleosGDPRBundle/pull/805) thanks to @dependabot[bot]
 - [804: Bump loader-utils from 2.0.0 to 2.0.3](https://github.com/nucleos/NucleosGDPRBundle/pull/804) thanks to @dependabot[bot]

#### Enhancement

 - [632: Use shared pipelines](https://github.com/nucleos/NucleosGDPRBundle/pull/632) thanks to @core23

## 2.4.0 - 2021-12-08


-----

### Release Notes for [2.4.0](https://github.com/nucleos/NucleosGDPRBundle/milestone/6)

Feature release (minor)

### 2.4.0

- Total issues resolved: **0**
- Total pull requests resolved: **6**
- Total contributors: **2**

#### dependency

 - [606: Add symfony 6 support](https://github.com/nucleos/NucleosGDPRBundle/pull/606) thanks to @core23
 - [605: Drop symfony 4 support](https://github.com/nucleos/NucleosGDPRBundle/pull/605) thanks to @core23
 - [592: Drop PHP 7 support](https://github.com/nucleos/NucleosGDPRBundle/pull/592) thanks to @core23

#### Enhancement

 - [604: Drop node-sass](https://github.com/nucleos/NucleosGDPRBundle/pull/604) thanks to @core23
 - [601: Update tools and use make to run them](https://github.com/nucleos/NucleosGDPRBundle/pull/601) thanks to @core23
 - [533: Add Occitan translation](https://github.com/nucleos/NucleosGDPRBundle/pull/533) thanks to @ensag-dev

## 2.3.0 - 2021-04-19


-----

### Release Notes for [2.3.0](https://github.com/nucleos/NucleosGDPRBundle/milestone/3)

Feature release (minor)

### 2.3.0

- Total issues resolved: **0**
- Total pull requests resolved: **3**
- Total contributors: **1**

#### Enhancement

 - [394: Add Permissions-Policy header to respect user privacy](https://github.com/nucleos/NucleosGDPRBundle/pull/394) thanks to @core23

#### dependency

 - [363: Bump block-bundle](https://github.com/nucleos/NucleosGDPRBundle/pull/363) thanks to @core23

#### Bug

 - [362: Throw LogicException when rendering block without template](https://github.com/nucleos/NucleosGDPRBundle/pull/362) thanks to @core23

## 2.2.0 - 2021-02-08



-----

### Release Notes for [2.2.0](https://github.com/nucleos/NucleosGDPRBundle/milestone/1)



### 2.2.0

- Total issues resolved: **0**
- Total pull requests resolved: **3**
- Total contributors: **1**

#### dependency

 - [212: Add support for PHP 8](https://github.com/nucleos/NucleosGDPRBundle/pull/212) thanks to @core23
 - [66: Add support for sonata/block-bundle 3](https://github.com/nucleos/NucleosGDPRBundle/pull/66) thanks to @core23

#### Enhancement

 - [75: Move configuration to PHP](https://github.com/nucleos/NucleosGDPRBundle/pull/75) thanks to @core23

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
