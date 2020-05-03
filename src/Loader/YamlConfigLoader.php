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

namespace WordpressWrapper\Config\Loader;

use WordpressWrapper\Config\Config\Config;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class YamlConfigLoader extends AbstractYamlLoader
{
    public function load($resource, string $type = null)
    {
        $configValues = $this->parse($resource);

        return $this->process(new Config(), $configValues);
    }

    public function supports($resource, string $type = null)
    {
        return \is_string($resource) && 'config.yaml' === \pathinfo($resource, PATHINFO_BASENAME);
    }
}
