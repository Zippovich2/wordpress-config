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

namespace Zippovich2\Wordpress;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Zippovich2\Wordpress\Exception\LoaderException;
use Zippovich2\Wordpress\Exception\PathException;
use Zippovich2\Wordpress\Handler\Filters;
use Zippovich2\Wordpress\Loader\YamlActionsLoader;
use Zippovich2\Wordpress\Loader\YamlFiltersLoader;

final class Config
{
    public const CONFIG_FILES = [
        'filters.yaml',
        'actions.yaml',
    ];

    /**
     * @var DelegatingLoader
     */
    private $loader;

    /**
     * @var string
     */
    private $configDirectory;

    /**
     * @param string $configDirectory path to the config directory
     *
     * @throws PathException   when directory does not exists
     * @throws LoaderException when can't load config file
     */
    public function load(string $configDirectory): void
    {
        if (!\is_dir($configDirectory)) {
            throw new PathException($configDirectory);
        }

        $this->configDirectory = $configDirectory;

        $fileLocator = new FileLocator($configDirectory);

        $loaderResolver = new LoaderResolver([
            new YamlFiltersLoader($fileLocator),
            new YamlActionsLoader($fileLocator),
        ]);
        $this->loader = new DelegatingLoader($loaderResolver);

        foreach (self::CONFIG_FILES as $file) {
            Filters::handle($this->processFile($file));
        }
    }

    /**
     * Loading file by name and looking for file in env directory and merge both files in one.
     *
     * @return array|null
     */
    public function processFile(string $filename)
    {
        $values = null;

        $filePath = $this->configDirectory . \sprintf('/%s', $filename);
        $envFilePath = $this->configDirectory . \sprintf('/%s/%s', APP_ENV, $filename);

        try {
            if (\file_exists($filePath)) {
                $values = $this->loader->load($filePath);
            }

            if (\file_exists($envFilePath)) {
                $envValues = $this->loader->load($envFilePath);
                $values = \array_merge($values, $envValues);
            }
        } catch (\Exception $e) {
            throw new LoaderException($filename, $e->getCode(), $e);
        }

        return $values;
    }
}
