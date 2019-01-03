# PHPStan GraphQL extension

[![Build Status](https://travis-ci.org/simpod/phpstan-graphql.svg)](https://travis-ci.org/simpod/phpstan-graphql)
[![Latest Stable Version](https://poser.pugx.org/simpod/phpstan-graphql/v/stable)](https://packagist.org/packages/simpod/phpstan-graphql)
[![License](https://poser.pugx.org/simpod/phpstan-graphql/license)](https://packagist.org/packages/simpod/phpstan-graphql)

* [PHPStan](https://github.com/phpstan/phpstan)
* [GraphQL PHP](https://github.com/webonyx/graphql-php)

This extension provides the following features:

* `ResolveInfo::getFieldSelection($depth)` return type is interpreted based on passed `$depth` value.

## Usage

To use this extension, require it in [Composer](https://getcomposer.org/):

```bash
composer require --dev simpod/phpstan-graphql
```

And include extension.neon in your project's PHPStan config:

```
includes:
	- vendor/simpod/phpstan-graphql/extension.neon
```
