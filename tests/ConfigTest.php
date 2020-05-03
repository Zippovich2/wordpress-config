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

namespace WordpressWrapper\Config\Tests;

use PHPUnit\Framework\TestCase;
use WordpressWrapper\Config\Config;
use WordpressWrapper\Config\Exception\CallbackException;
use WordpressWrapper\Config\Exception\LoaderException;
use WordpressWrapper\Config\Exception\PathException;

require_once __DIR__ . '/Fixtures/Callback/functions.php';

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class ConfigTest extends TestCase
{
    public const FIXTURES_DIR = __DIR__ . '/Fixtures/Config';
    public const FIXTURES_LOAD_DIR = __DIR__ . '/Fixtures/ConfigLoad';

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
    public function testProcessFileLoaderExceptions($filename, $exception, bool $skipNotFoundFiles = true): void
    {
        $this->expectException($exception);

        $this->config->processFile($filename, true, $skipNotFoundFiles);
    }

    public function testPathException(): void
    {
        $this->expectException(PathException::class);

        (new Config('some/dir'));
    }

    /**
     * @dataProvider successfulLoadProvider
     */
    public function testSuccessLoad($dir): void
    {
        $config = new Config(\sprintf('%s/%s', self::FIXTURES_LOAD_DIR, $dir));
        $config->load();

        static::assertTrue(true);
    }

    /**
     * @dataProvider successfulLoadProvider
     */
    public function testSuccessfulLoad($dir): void
    {
        $config = new Config(\sprintf('%s/%s', self::FIXTURES_LOAD_DIR, $dir));
        $config->load();

        static::assertTrue(true);
    }

    /**
     * @dataProvider unsuccessfulLoadProvider
     */
    public function testUnsuccessfulLoad($dir, $exception): void
    {
        $this->expectException($exception);

        $config = new Config(\sprintf('%s/%s', self::FIXTURES_LOAD_DIR, $dir));
        $config->load();

        static::assertTrue(true);
    }

    public function successfulLoadProvider()
    {
        return [
            ['1'], // with settings.yaml
            ['2'], // without settings.yaml
            ['empty'], // check empty directory
        ];
    }

    public function unsuccessfulLoadProvider()
    {
        return [
            ['3', PathException::class],
            ['4', CallbackException::class],
            ['5', LoaderException::class],
        ];
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
                    'callback_prefix' => 'App\Filter\\',
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
                    'callback_prefix' => 'App\Action\\',
                ],
            ],
            [
                'settings.yaml',
                [
                    'settings' => [
                        'actions' => [
                            'set-1-actions.yaml',
                            'set-2-actions.yaml',
                        ],
                        'filters' => [
                            'set-1-filters.yaml',
                            'set-2-filters.yaml',
                        ],
                    ],
                ],
            ],
        ];
    }

    public function processFileExceptionProvider()
    {
        return [
            ['invalid.yaml', LoaderException::class],
            ['invalid_with_env.yaml', LoaderException::class],
            ['invalid-path-to-file.yaml', PathException::class, false],
        ];
    }
}
