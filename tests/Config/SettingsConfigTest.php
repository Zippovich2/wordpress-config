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

namespace WordpressWrapper\Config\Tests\Config;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use WordpressWrapper\Config\Config\SettingsConfig;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class SettingsConfigTest extends TestCase
{
    use ConfigsProvider;

    /**
     * @dataProvider correctSettingsConfigs
     */
    public function testConfigTreeBuilderWithCorrectConfigs($in, $out): void
    {
        $processor = new Processor();
        $config = new SettingsConfig();

        $processedValues = $processor->processConfiguration($config, [$in]);

        static::assertEquals($out, $processedValues);
    }

    /**
     * @dataProvider incorrectSettingsConfigs
     */
    public function testConfigTreeBuilderWithIncorrectConfigs($incorrectConfig): void
    {
        static::expectException(InvalidConfigurationException::class);

        $processor = new Processor();
        $config = new SettingsConfig();

        $processor->processConfiguration($config, [$incorrectConfig]);
    }
}
