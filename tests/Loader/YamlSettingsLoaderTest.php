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

namespace WordpressWrapper\Config\Tests\Loader;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Exception\FileLocatorFileNotFoundException;
use Symfony\Component\Config\FileLocator;
use WordpressWrapper\Config\Exception\ConfigException;
use WordpressWrapper\Config\Exception\LoaderException;
use WordpressWrapper\Config\Loader\YamlSettingsLoader;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class YamlSettingsLoaderTest extends TestCase
{
    public const FIXTURES_DIR = __DIR__ . '/../Fixtures/SettingsLoader';

    private $loader;

    private $fileLocator;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->fileLocator = new FileLocator(self::FIXTURES_DIR);
        $this->loader = new YamlSettingsLoader($this->fileLocator);
    }

    /**
     * @dataProvider invalidFilePathsProvider
     */
    public function testParseInvalidFiles($file, $expected): void
    {
        $this->expectException($expected);

        $this->loader->load($this->fileLocator->locate($file));
    }

    /**
     * @dataProvider validFilePathsProvider
     */
    public function testParseValidFiles($file, $expected): void
    {
        $actual = $this->loader->load($this->fileLocator->locate($file));

        static::assertEquals($expected, $actual);
    }

    /**
     * @dataProvider supportProvider
     */
    public function testSupport($filename, $expected): void
    {
        $support = $this->loader->supports($filename);

        static::assertIsBool($support);
        static::assertEquals($expected, $support);
    }

    public function invalidFilePathsProvider()
    {
        return [
            ['../invalid.yaml', LoaderException::class],
            ['invalid-settings.yaml', ConfigException::class],
            ['wrong/path.yaml', FileLocatorFileNotFoundException::class],
        ];
    }

    public function validFilePathsProvider()
    {
        return [
            [
                'valid-settings.yaml',
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

    public function supportProvider()
    {
        return [
            ['settings.yaml', true],
            ['settings', false],
            [[], false],
            ['filters.yaml', false],
            ['any-config-file.yaml', false],
            [null, false],
        ];
    }
}
