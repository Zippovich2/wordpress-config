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

namespace Zippovich2\Wordpress\Tests\Loader;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Exception\FileLocatorFileNotFoundException;
use Symfony\Component\Config\FileLocator;
use Zippovich2\Wordpress\Exception\LoaderException;
use Zippovich2\Wordpress\Loader\YamlActionsLoader;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class YamlActionsLoaderTest extends TestCase
{
    public const FIXTURES_DIR = __DIR__ . '/../Fixtures/';

    private $loader;

    private $fileLocator;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->fileLocator = new FileLocator(self::FIXTURES_DIR);
        $this->loader = new YamlActionsLoader($this->fileLocator);
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
            ['invalid.yaml', LoaderException::class],
            ['wrong/path.yaml', FileLocatorFileNotFoundException::class],
        ];
    }

    public function validFilePathsProvider()
    {
        return [
            [
                'valid_actions.yaml',
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

    public function supportProvider()
    {
        return [
            ['actions.yaml', true],
            ['actions', false],
            [[], false],
            ['filters.yaml', false],
        ];
    }
}
