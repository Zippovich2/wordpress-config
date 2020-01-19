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

use Zippovich2\Wordpress\Config\FiltersConfig;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class YamlFiltersLoader extends AbstractYamlLoader
{
    public function load($resource, string $type = null)
    {
        $configValues = $this->parse($resource);

        return $this->process(new FiltersConfig(), $configValues);
    }

    public function supports($resource, string $type = null)
    {
        return \is_string($resource) && 'filters.yaml' === \pathinfo($resource, PATHINFO_BASENAME);
    }
}
