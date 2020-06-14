# 2.0.0

## Changed

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

# 1.5.0

## Changes

- Remove oppressive language @core23 (#48)

# 1.4.0

## Changes

## 🚀 Features

- Block all cookies if not consent @core23 (#45)

## 📦 Dependencies

- Bump symfony versions @core23 (#47)

# 1.3.1

## 🐛 Bug Fixes

- Fix consuming JavaScript event @core23 (#42)

# 1.3.0

## Changes

- Add missing strict file header @core23 (#33)

## 📦 Dependencies

- Add support for symfony 5 @core23 (#24)
- Drop support for symfony 3 @core23 (#35)
- Drop Sonata CoreBundle dependency @core23 (#34)
