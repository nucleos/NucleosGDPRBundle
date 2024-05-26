NucleosGDPRBundle
=================
[![Latest Stable Version](https://poser.pugx.org/nucleos/gdpr-bundle/v/stable)](https://packagist.org/packages/nucleos/gdpr-bundle)
[![Latest Unstable Version](https://poser.pugx.org/nucleos/gdpr-bundle/v/unstable)](https://packagist.org/packages/nucleos/gdpr-bundle)
[![License](https://poser.pugx.org/nucleos/gdpr-bundle/license)](https://packagist.org/packages/nucleos/gdpr-bundle)

[![Total Downloads](https://poser.pugx.org/nucleos/gdpr-bundle/downloads)](https://packagist.org/packages/nucleos/gdpr-bundle)
[![Monthly Downloads](https://poser.pugx.org/nucleos/gdpr-bundle/d/monthly)](https://packagist.org/packages/nucleos/gdpr-bundle)
[![Daily Downloads](https://poser.pugx.org/nucleos/gdpr-bundle/d/daily)](https://packagist.org/packages/nucleos/gdpr-bundle)

[![Continuous Integration](https://github.com/nucleos/NucleosGDPRBundle/actions/workflows/continuous-integration.yml/badge.svg?event=push)](https://github.com/nucleos/NucleosGDPRBundle/actions?query=workflow%3A"Continuous+Integration"+event%3Apush)
[![Code Coverage](https://codecov.io/gh/nucleos/NucleosGDPRBundle/graph/badge.svg)](https://codecov.io/gh/nucleos/NucleosGDPRBundle)
[![Type Coverage](https://shepherd.dev/github/nucleos/NucleosGDPRBundle/coverage.svg)](https://shepherd.dev/github/nucleos/NucleosGDPRBundle)

This bundle provides a GDPR conform cookie information for symfony applications.

## Installation

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

```
composer require nucleos/gdpr-bundle
```

### Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles in `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Nucleos\NucleosGDPRBundle\NucleosGDPRBundle::class => ['all' => true],
];
```

### Block cookies

By default all cookies are kept, also the cookie consent was not set.
To block all domain cookies, you can set the following config.

```yaml
# config/packages/nucleos_gdpr.yaml

nucleos_gdpr:
    block_cookies: null
```

You can define a list of cookies that are kept:

```yaml
# config/packages/nucleos_gdpr.yaml

nucleos_gdpr:
    block_cookies:
        keep:
          - PHPSESSID
          - ADMIN_.*
```


### Google FLoC (Federated Learning of Cohorts)

By default a `Permissions-Policy` header is added to every response to respect user privacy. You can enable Google FLoC tracking via the following configuration:

```yaml
# config/packages/nucleos_gdpr.yaml

nucleos_gdpr:
    privacy:
        google_floc: true
```


### Assets

It is recommended to use [webpack](https://webpack.js.org/) / [webpack-encore](https://github.com/symfony/webpack-encore)
to include the `GdprPopup.js` and `GdprPopup.css` file in your page. These files are located in the `assets` folder.

## Usage

```twig
{# template.twig #}

{{ sonata_block_render({ 'type': 'nucleos_gdpr.block.information' }, {
    'url': 'https://example.com/gdpr',
    'text': 'Example text' // optional
}) }}
```

## License

This bundle is under the [MIT license](LICENSE.md).
