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

namespace Zippovich2\Wordpress\Tests;

use PHPUnit\Framework\TestCase;
use Zippovich2\Wordpress\Config;
use Zippovich2\Wordpress\Exception\LoaderException;
use Zippovich2\Wordpress\Exception\PathException;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class ConfigTest extends TestCase
{
    public const FIXTURES_DIR = __DIR__ . '/Fixtures/Config';

    private $config;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->config = new Config(self::FIXTURES_DIR);
    }

    /**
     * @dataProvider processFileProvider
     */
    public function testProcessFileReturnValue($filename, $expected): void
    {
        $actual = $this->config->processFile($filename);

        static::assertEquals($expected, $actual);
    }

    /**
     * @dataProvider processFileExceptionProvider
     */
    public function testProcessFileLoaderExceptions($filename, $exception): void
    {
        $this->expectException($exception);

        $this->config->processFile($filename);
    }

    public function testPathException(): void
    {
        $this->expectException(PathException::class);

        $config = new Config('some/dir');
    }

    public function processFileProvider()
    {
        return [
            [
                'filters.yaml',
                [
                    'filters' => [
                        'yaml' => [
                            ['callback' => 'testEnv', 'priority' => 10, 'args' => 1],
                        ],
                    ],
                    'class_prefix' => 'App\Filter\\',
                ],
            ],
            [
                'actions.yaml',
                [
                    'actions' => [
                        'yaml' => [
                            ['callback' => 'test', 'priority' => 10, 'args' => 1],
                        ],
                    ],
                    'class_prefix' => 'App\Action\\',
                ],
            ],
        ];
    }

    public function processFileExceptionProvider()
    {
        return [
            ['invalid.yaml', LoaderException::class],
            ['invalid_with_env.yaml', LoaderException::class],
        ];
    }
}
