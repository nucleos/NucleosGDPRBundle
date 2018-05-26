GDPRBundle
=============
[![Latest Stable Version](https://poser.pugx.org/core23/gdpr-bundle/v/stable)](https://packagist.org/packages/core23/gdpr-bundle)
[![Latest Unstable Version](https://poser.pugx.org/core23/gdpr-bundle/v/unstable)](https://packagist.org/packages/core23/gdpr-bundle)
[![License](https://poser.pugx.org/core23/gdpr-bundle/license)](https://packagist.org/packages/core23/gdpr-bundle)

[![Total Downloads](https://poser.pugx.org/core23/gdpr-bundle/downloads)](https://packagist.org/packages/core23/gdpr-bundle)
[![Monthly Downloads](https://poser.pugx.org/core23/gdpr-bundle/d/monthly)](https://packagist.org/packages/core23/gdpr-bundle)
[![Daily Downloads](https://poser.pugx.org/core23/gdpr-bundle/d/daily)](https://packagist.org/packages/core23/gdpr-bundle)

[![Build Status](https://travis-ci.org/core23/gdpr-bundle.svg)](https://travis-ci.org/core23/gdpr-bundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/core23/gdpr-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/core23/gdpr-bundle)
[![Code Climate](https://codeclimate.com/github/core23/gdpr-bundle/badges/gpa.svg)](https://codeclimate.com/github/core23/gdpr-bundle)
[![Coverage Status](https://coveralls.io/repos/core23/gdpr-bundle/badge.svg)](https://coveralls.io/r/core23/gdpr-bundle)

[![Donate to this project using Flattr](https://img.shields.io/badge/flattr-donate-yellow.svg)](https://flattr.com/profile/core23)
[![Donate to this project using PayPal](https://img.shields.io/badge/paypal-donate-yellow.svg)](https://paypal.me/gripp)

This bundle provides a GDPR conform cookie information inside the sonata-project.

## Installation

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

```
composer require core23/gdpr-bundle
```

### Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles in `bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Core23\GDPRBundle\Core23GDPRBundle::class => ['all' => true],
];
```

### Configure the Bundle

Add the block to the `sonata_block` configuration if necessary:

```yaml
# config/packages/sonata_block.yaml

sonata_block:
    blocks:
        core23_gdpr.block.information: ~
```

## Usage

```twig
{# template.twig #}

{{ sonata_block_render({ 'type': 'core23_gdpr.block.information' }, {
    'url': 'https://example.com/gdpr',
    'text': 'Example text' // optional
}) }}
```

## License

This bundle is under the [MIT license](LICENSE.md).
