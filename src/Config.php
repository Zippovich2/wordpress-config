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

namespace WordpressWrapper\Config;

use Symfony\Component\Config\Exception\FileLocatorFileNotFoundException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use WordpressWrapper\Config\Exception\LoaderException;
use WordpressWrapper\Config\Exception\PathException;
use WordpressWrapper\Config\Handler\Filters;
use WordpressWrapper\Config\Loader\YamlActionsLoader;
use WordpressWrapper\Config\Loader\YamlFiltersLoader;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
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
     * @var FileLocator
     */
    private $fileLocator;

    /**
     * @throws PathException when directory does not exists
     */
    public function __construct(string $configDirectory)
    {
        if (!\is_dir($configDirectory)) {
            throw new PathException($configDirectory);
        }

        $this->fileLocator = new FileLocator($configDirectory);

        $loaderResolver = new LoaderResolver([
            new YamlFiltersLoader($this->fileLocator),
            new YamlActionsLoader($this->fileLocator),
        ]);

        $this->loader = new DelegatingLoader($loaderResolver);
    }

    /**
     * Load and process configs using resolver.
     *
     * @throws LoaderException when can't load config file
     */
    public function load(): void
    {
        foreach (self::CONFIG_FILES as $file) {
            Filters::handle($this->processFile($file));
        }
    }

    /**
     * Loading file by name and looking for file in env directory and merge both files in one.
     *
     * @return array
     */
    public function processFile(string $filename, bool $loadEnvConfig = true)
    {
        try {
            $filePath = $this->fileLocator->locate($filename);
            $values = $this->loader->load($filePath);
        } catch (FileLocatorFileNotFoundException $e) {
            $values = [];
        } catch (\Exception $e) {
            throw new LoaderException($filename, $e->getCode(), $e);
        }

        if ($loadEnvConfig) {
            $envValues = $this->processFile(\sprintf('%s/%s', $_ENV['APP_ENV'], $filename), false);
            $values = \array_merge($values, $envValues);
        }

        return $values;
    }
}
