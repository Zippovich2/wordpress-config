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

namespace Zippovich2\Wordpress\Tests\Handler;

use PHPUnit\Framework\TestCase;
use Zippovich2\Wordpress\Exception\CallbackException;
use Zippovich2\Wordpress\Handler\Actions;

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
        static::assertEquals($expectedCalls, Actions::handle($data));
    }

    /**
     * @dataProvider undefinedCallbacksProvider
     */
    public function testHandleWithUndefinedCallbacks($data): void
    {
        static::expectException(CallbackException::class);
        Actions::handle($data);
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
                    'class_prefix' => 'Zippovich2\Wordpress\Tests\Fixtures\Callback\\',
                ],
                3,
            ],
            [
                [
                    'actions' => [
                        'action_name' => [
                            ['callback' => 'callback_1', 'priority' => 10, 'args' => 1],
                            ['callback' => 'callback_2', 'priority' => 10, 'args' => 1],
                            ['callback' => 'Zippovich2\Wordpress\Tests\Fixtures\Callback\CallbackClass::method', 'priority' => 10, 'args' => 1],
                        ],
                    ],
                    'class_prefix' => 'App\Action\\',
                ],
                3,
            ],
        ];
    }
}
