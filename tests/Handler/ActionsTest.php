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
use WordpressWrapper\Config\Handler\ActionsHandler;

require_once __DIR__ . '/../Fixtures/Callback/functions.php';

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class ActionsTest extends TestCase
{
    /**
     * @dataProvider actionsProvider
     */
    public function testHandleWithCorrectData($data, $expectedCalls): void
    {
        static::assertEquals($expectedCalls, ActionsHandler::handle($data));
    }

    /**
     * @dataProvider undefinedCallbacksProvider
     */
    public function testHandleWithUndefinedCallbacks($data): void
    {
        static::expectException(CallbackException::class);
        ActionsHandler::handle($data);
    }

    public function undefinedCallbacksProvider()
    {
        return [
            [
                [
                    'actions' => [
                        'action_name' => [
                            ['callback' => 'undefined_function_callback', 'priority' => 10, 'args' => 1],
                        ],
                    ],
                ],
            ],
            [
                [
                    'actions' => [
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
                    'actions' => [],
                ],
                0,
            ],
            [
                [
                    'actions' => [
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
                    'actions' => [
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
                    'actions' => [
                        'action_name' => [
                            ['callback' => 'callback_1', 'priority' => 10, 'args' => 1],
                            ['callback' => 'callback_2', 'priority' => 10, 'args' => 1],
                            ['callback' => 'WordpressWrapper\Config\Tests\Fixtures\Callback\CallbackClass::method', 'priority' => 10, 'args' => 1],
                        ],
                    ],
                    'callback_prefix' => 'App\Action\\',
                ],
                3,
            ],
        ];
    }
}
