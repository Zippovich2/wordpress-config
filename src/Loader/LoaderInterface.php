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
use Zippovich2\Wordpress\Exception\ConfigException;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
interface LoaderInterface
{
    /**
     * Parsing file and return array.
     *
     * @param string $path file path
     */
    public function parse(string $path): array;

    /**
     * Processing config and return array.
     *
     * @throws ConfigException when config is invalid or can't be processed by any reason
     */
    public function process(ConfigurationInterface $config, array $values): array;
}
