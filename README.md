## Wordpress Wrapper Config

Allows you to configure filters and actions via yaml config files.

[![Build Status](https://travis-ci.org/Zippovich2/wordpress-config.svg?branch=master)](https://travis-ci.org/Zippovich2/wordpress-config)
[![Packagist](https://img.shields.io/packagist/v/zippovich2/wordpress-config.svg)](https://packagist.org/packages/zippovich2/wordpress-config)

### Installation

*Requirements:*

* php ^7.2.5

```sh
$ composer require zippovich2/wordpress-config
```

Then load configs in your `functions.php` or right after the `wp-settings.php` file was included:

```php
use WordpressWrapper\Config\Config;

//...

$config = new Config('path/to/config-dir');
$config->load();
```

### Usage

#### Filters

```yaml
# config/filters.yaml

filters:
  filter_name:
    - { callback: filter_callback_function, priority: 100, args: 1 }
  the_content:
    - { callback: Class::method }
    - { callback: Class::someFilter, priority: 1 }
```

#### Actions

```yaml
# config/actions.yaml

actions:
  action_name:
    - { callback: action_callback_function, priority: 100, args: 1 }
  after_setup_theme:
    - { callback: App\Action\ThemeSettings::defaultOptions }
```

#### Callback prefix

You can set callback prefix to avoid long callbacks:

```yaml
# config/actions.yaml

actions:
  action_name:
    - { callback: action_callback_function, priority: 100, args: 2 }
  after_setup_theme:
    - { callback: ThemeSettings::defaultOptions } # App\ActionPath\ThemeSettings:defaultOptions

callback_prefix: App\ActionPath\ # it's work only with classes
```

### Default values

#### Actions

```yaml
# config/actions.yaml

actions:
  action_name:
    - { callback: ~, priority: 10, args: 1 }

callback_prefix: App\Action\ 
```

#### Filters

```yaml
# config/filters.yaml

filters:
  filter_name:
    - { callback: ~, priority: 10, args: 1 }

callback_prefix: App\Filter\ 
```