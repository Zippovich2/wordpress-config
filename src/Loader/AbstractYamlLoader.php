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

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Zippovich2\Wordpress\Exception\ConfigException;
use Zippovich2\Wordpress\Exception\LoaderException;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
abstract class AbstractYamlLoader extends FileLoader implements LoaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse(string $path): array
    {
        try {
            $configValues[] = Yaml::parseFile($path);
        } catch (ParseException $e) {
            throw new LoaderException(\sprintf('File "%s" cannot be parsed.', $path), $e->getCode(), $e);
        }

        return $configValues;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ConfigurationInterface $config, array $values): array
    {
        $processor = new Processor();

        try {
            $processedValues = $processor->processConfiguration($config, $values);
        } catch (InvalidConfigurationException $e) {
            throw new ConfigException($e->getMessage());
        }

        return $processedValues;
    }
}
