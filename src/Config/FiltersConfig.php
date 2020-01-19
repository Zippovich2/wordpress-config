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

namespace Zippovich2\Wordpress\Config;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class FiltersConfig implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('wordpress');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('filters')
                    ->prototype('array')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('callback')->end()
                                ->integerNode('priority')
                                    ->defaultValue(10)
                                ->end()
                                ->integerNode('args')
                                    ->defaultValue(1)
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
