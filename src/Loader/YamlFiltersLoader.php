<?php

declare(strict_types=1);

/*
 * This file is part of the "Wordpress Wrapper" package.
 *
 * (c) Skoropadskyi Roman <zipo.ckorop@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zippovich2\Wordpress\Loader;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;
use Zippovich2\Wordpress\Config\FiltersConfig;
use Zippovich2\Wordpress\Exception\ConfigException;

class YamlFiltersLoader extends FileLoader
{
    public function load($resource, string $type = null)
    {
        $configValues[] = Yaml::parseFile($resource);

        $processor = new Processor();
        $config = new FiltersConfig();

        if (null === $configValues) {
            return null;
        }

        try {
            $processedValues = $processor->processConfiguration($config, $configValues);
        } catch (InvalidConfigurationException $e) {
            throw new ConfigException($e->getMessage());
        }

        return $processedValues;
    }

    public function supports($resource, string $type = null)
    {
        return \is_string($resource) && 'filters.yaml' === \pathinfo($resource, PATHINFO_BASENAME);
    }
}
