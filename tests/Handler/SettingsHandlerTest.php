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

namespace WordpressWrapper\Config\Tests\Handler;

use PHPUnit\Framework\TestCase;
use WordpressWrapper\Config\Handler\SettingsHandler;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class SettingsHandlerTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testReturnedData($inputData, $expectedData): void
    {
        static::assertEquals($expectedData, SettingsHandler::handle($inputData));
    }


    public function dataProvider()
    {
        return [
            [
                'input' => [
                    'settings' => [
                        'actions' => [
                            'set-1-actions.yaml',
                            'set-2-actions.yaml',
                            'set-3-actions.yaml',
                        ],
                    ],
                ],
                'expected' => [
                    'actions' => [
                        'set-1-actions.yaml',
                        'set-2-actions.yaml',
                        'set-3-actions.yaml',
                    ],
                ],
            ],
            [
                'input' => [
                    'settings' => [
                        'filters' => [
                            'set-1-filters.yaml',
                            'set-2-filters.yaml',
                            'set-3-filters.yaml',
                        ],
                    ],
                ],
                'expected' => [
                    'filters' => [
                        'set-1-filters.yaml',
                        'set-2-filters.yaml',
                        'set-3-filters.yaml',
                    ],
                ],
            ],
            [
                'input' => [
                    'settings' => [
                        'actions' => [
                            'set-1-actions.yaml',
                            'set-2-actions.yaml',
                            'set-3-actions.yaml',
                        ],
                        'filters' => [
                            'set-1-filters.yaml',
                            'set-2-filters.yaml',
                            'set-3-filters.yaml',
                        ],
                    ],
                ],
                'expected' => [
                    'actions' => [
                        'set-1-actions.yaml',
                        'set-2-actions.yaml',
                        'set-3-actions.yaml',
                    ],
                    'filters' => [
                        'set-1-filters.yaml',
                        'set-2-filters.yaml',
                        'set-3-filters.yaml',
                    ],
                ],
            ],
            [
                'input' => [],
                'expected' => null
            ],
        ];
    }
}
