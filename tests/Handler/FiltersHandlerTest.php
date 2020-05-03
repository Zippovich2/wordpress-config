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
use WordpressWrapper\Config\Exception\CallbackException;
use WordpressWrapper\Config\Handler\FiltersHandler;

require_once __DIR__ . '/../Fixtures/Callback/functions.php';

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class FiltersHandlerTest extends TestCase
{
    /**
     * @dataProvider actionsProvider
     */
    public function testHandleWithCorrectData($data, $expectedCalls): void
    {
        static::assertEquals($expectedCalls, FiltersHandler::handle($data));
    }

    /**
     * @dataProvider undefinedCallbacksProvider
     */
    public function testHandleWithUndefinedCallbacks($data): void
    {
        static::expectException(CallbackException::class);
        FiltersHandler::handle($data);
    }

    public function undefinedCallbacksProvider()
    {
        return [
            [
                [
                    'filters' => [
                        'action_name' => [
                            ['callback' => 'undefined_function_callback', 'priority' => 10, 'args' => 1],
                        ],
                    ],
                ],
            ],
            [
                [
                    'filters' => [
                        'action_name' => [
                            ['callback' => 'UndefinedClass:callback', 'priority' => 10, 'args' => 1],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function actionsProvider()
    {
        return [
            [
                null,
                0,
            ],
            [
                [
                    'filters' => [],
                ],
                0,
            ],
            [
                [
                    'filters' => [
                        'action_name' => [
                            ['callback' => 'callback_1', 'priority' => 10, 'args' => 1],
                            ['callback' => 'callback_2', 'priority' => 10, 'args' => 1],
                        ],
                    ],
                ],
                2,
            ],
            [
                [
                    'filters' => [
                        'action_name' => [
                            ['callback' => 'callback_1', 'priority' => 10, 'args' => 1],
                            ['callback' => 'callback_2', 'priority' => 10, 'args' => 1],
                            ['callback' => 'CallbackClass::method', 'priority' => 10, 'args' => 1],
                        ],
                    ],
                    'callback_prefix' => 'WordpressWrapper\Config\Tests\Fixtures\Callback\\',
                ],
                3,
            ],
            [
                [
                    'filters' => [
                        'action_name' => [
                            ['callback' => 'callback_1', 'priority' => 10, 'args' => 1],
                            ['callback' => 'callback_2', 'priority' => 10, 'args' => 1],
                            ['callback' => 'WordpressWrapper\Config\Tests\Fixtures\Callback\CallbackClass::method', 'priority' => 10, 'args' => 1],
                        ],
                    ],
                    'callback_prefix' => 'App\Filter\\',
                ],
                3,
            ],
        ];
    }
}
