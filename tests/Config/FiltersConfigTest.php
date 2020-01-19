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

namespace Zippovich2\Wordpress\Tests\Config;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Zippovich2\Wordpress\Config\FiltersConfig;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class FiltersConfigTest extends TestCase
{
    use ConfigsProvider;

    /**
     * @dataProvider correctFiltersConfigs
     */
    public function testConfigTreeBuilderWithCorrectConfigs($in, $out): void
    {
        $processor = new Processor();
        $config = new FiltersConfig();

        $processedValues = $processor->processConfiguration($config, [$in]);

        static::assertEquals($out, $processedValues);
    }

    /**
     * @dataProvider incorrectFiltersConfigs
     */
    public function testConfigTreeBuilderWithIncorrectConfigs($incorrectConfig): void
    {
        static::expectException(InvalidConfigurationException::class);

        $processor = new Processor();
        $config = new FiltersConfig();

        $processor->processConfiguration($config, [$incorrectConfig]);
    }
}
