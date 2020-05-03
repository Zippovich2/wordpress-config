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
use WordpressWrapper\Config\Handler\ActionsHandler;
use WordpressWrapper\Config\Handler\SettingsHandler;
use WordpressWrapper\Config\Handler\FiltersHandler;
use WordpressWrapper\Config\Loader\YamlActionsLoader;
use WordpressWrapper\Config\Loader\YamlSettingsLoader;
use WordpressWrapper\Config\Loader\YamlFiltersLoader;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class Config
{
    public const FILTERS_CONFIG = 'filters.yaml';
    public const ACTIONS_CONFIG = 'actions.yaml';
    public const SETTINGS_CONFIG = 'settings.yaml';

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
            new YamlSettingsLoader($this->fileLocator),
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
        $config = SettingsHandler::handle($this->processFile(self::SETTINGS_CONFIG));

        $this->loadActions($config['actions'] ?? null);
        $this->loadFilters($config['filters'] ?? null);
    }

    /**
     * Loading actions from included files or from actions.yaml if exists.
     */
    private function loadActions(?array $actions = null): void
    {
        if (null === $actions) {
            ActionsHandler::handle($this->processFile(self::ACTIONS_CONFIG));
        } else {
            foreach ($actions as $configFile) {
                ActionsHandler::handle($this->processFile($configFile, true, false));
            }
        }
    }

    /**
     * Loading filters from included files or from actions.yaml if exists.
     */
    private function loadFilters(?array $filters = null): void
    {
        if (null === $filters) {
            FiltersHandler::handle($this->processFile(self::FILTERS_CONFIG));
        } else {
            foreach ($filters as $configFile) {
                FiltersHandler::handle($this->processFile($configFile, true, false));
            }
        }
    }

    /**
     * Loading file by name and looking for file in env directory and merge both files in one.
     *
     * @return array
     *
     * @throws PathException   if file included in config.yaml not found.
     * @throws LoaderException if config file is invalid or if something went wrong
     */
    public function processFile(string $filename, bool $loadEnvConfig = true, bool $skipNotFoundFiles = true)
    {
        try {
            $filePath = $this->fileLocator->locate($filename);
            $values = $this->loader->load($filePath);
        } catch (FileLocatorFileNotFoundException $e) {
            if (false === $skipNotFoundFiles) {
                throw new PathException(\sprintf('File "%s" not found.', $filename), 0, $e);
            }

            $values = [];
        } catch (\Throwable $e) {
            throw new LoaderException($filename, 0, $e);
        }

        if ($loadEnvConfig) {
            $envValues = $this->processFile(\sprintf('%s/%s', $_ENV['APP_ENV'], $filename), false);
            $values = \array_merge($values, $envValues);
        }

        return $values;
    }
}
