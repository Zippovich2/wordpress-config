## Wordpress Config Package
This package allow config your filters and actions via yaml config files.

[![Build Status](https://travis-ci.org/Zippovich2/wordpress-config.svg?branch=master)](https://travis-ci.org/Zippovich2/wordpress-config)
[![Packagist](https://img.shields.io/packagist/v/zippovich2/wordpress-config.svg)](https://github.com/Zippovich2/wordpress-config)

### Installation

*Requirements:*

* php ^7.2.5

```sh
$ composer require zippovich2/wordpress-config
```

Then load configs in your `functions.php` or right after `wp-settings.php` file is required:

```php
$config = new Config('path/to/config-dir');
$config->load();
```
