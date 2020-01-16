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
use Zippovich2\Wordpress\Handler\Filters;

require_once 'callbacks.php';

class FiltersTest extends TestCase
{
    /**
     * @dataProvider actionsProvider
     */
    public function testHandleWithCorrectData($data, $expectedCalls): void
    {
        static::assertEquals($expectedCalls, Filters::handle($data));
    }

    /**
     * @dataProvider undefinedCallbacksProvider
     */
    public function testHandleWithUndefinedCallbacks($data): void
    {
        static::expectException(CallbackException::class);
        Filters::handle($data);
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
                            ['callback' => 'CallbackClass:callbackMethod', 'priority' => 10, 'args' => 1],
                        ],
                    ],
                ],
                3,
            ],
        ];
    }
}
