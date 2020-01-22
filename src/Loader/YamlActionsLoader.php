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

use WordpressWrapper\Config\Config\ActionsConfig;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class YamlActionsLoader extends AbstractYamlLoader
{
    /**
     * {@inheritdoc}
     */
    public function load($resource, string $type = null)
    {
        $configValues = $this->parse($resource);

        return $this->process(new ActionsConfig(), $configValues);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, string $type = null)
    {
        return \is_string($resource) && 'actions.yaml' === \pathinfo($resource, PATHINFO_BASENAME);
    }
}
