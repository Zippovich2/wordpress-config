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

namespace Zippovich2\Wordpress\Tests\Config;

trait ConfigsProvider
{
    public function correctFiltersConfigs()
    {
        return [
            [
                'in' => [
                    'filters' => [
                        'the_content' => [
                            ['callback' => 'test1', 'priority' => 11],
                            ['callback' => 'test2'],
                            ['callback' => 'test3', 'args' => 2],
                            ['callback' => 'test3', 'priority' => -20, 'args' => 2],
                        ],
                    ],
                ],
                'out' => [
                    'filters' => [
                        'the_content' => [
                            ['callback' => 'test1', 'priority' => 11, 'args' => 1],
                            ['callback' => 'test2', 'priority' => 10, 'args' => 1],
                            ['callback' => 'test3', 'priority' => 10, 'args' => 2],
                            ['callback' => 'test3', 'priority' => -20, 'args' => 2],
                        ],
                    ],
                ],
            ],
            [
                'in' => [
                    'filters' => [
                        'the_content' => [
                            ['callback' => 'test1', 'priority' => 11],
                            ['callback' => 'test2'],
                        ],
                        'the_title' => [
                            ['callback' => 'test3', 'args' => 2],
                            ['callback' => 'test3', 'priority' => -20, 'args' => 2],
                        ],
                    ],
                ],
                'out' => [
                    'filters' => [
                        'the_content' => [
                            ['callback' => 'test1', 'priority' => 11, 'args' => 1],
                            ['callback' => 'test2', 'priority' => 10, 'args' => 1],
                        ],
                        'the_title' => [
                            ['callback' => 'test3', 'priority' => 10, 'args' => 2],
                            ['callback' => 'test3', 'priority' => -20, 'args' => 2],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function incorrectFiltersConfigs()
    {
        return [
            [
                [
                    'filters' => [
                        'the_content' => [
                            ['priority' => 11],
                            ['undefined_key' => 'some value'],
                            ['callback' => 'test', 'priority' => 'is string'],
                            ['callback' => 'test', 'args' => 'is string'],
                            ['callback' => 'test', 'args' => ['array']],
                            ['callback' => ['array']],
                        ],
                    ],
                ],
            ],
            [
                'filters' => [
                    [
                        'the_content' => [
                            ['callback' => 'test1', 'priority' => 11],
                            ['callback' => 'test2'],
                        ],
                    ],
                    'the_title' => [
                        [['callback' => 'test3', 'args' => 2]],
                    ],
                ],
            ],
        ];
    }

    public function correctActionsConfigs()
    {
        return [
            [
                'in' => [
                    'actions' => [
                        'the_content' => [
                            ['callback' => 'test1', 'priority' => 11],
                            ['callback' => 'test2'],
                            ['callback' => 'test3', 'args' => 2],
                            ['callback' => 'test3', 'priority' => -20, 'args' => 2],
                        ],
                    ],
                ],
                'out' => [
                    'actions' => [
                        'the_content' => [
                            ['callback' => 'test1', 'priority' => 11, 'args' => 1],
                            ['callback' => 'test2', 'priority' => 10, 'args' => 1],
                            ['callback' => 'test3', 'priority' => 10, 'args' => 2],
                            ['callback' => 'test3', 'priority' => -20, 'args' => 2],
                        ],
                    ],
                ],
            ],
            [
                'in' => [
                    'actions' => [
                        'the_content' => [
                            ['callback' => 'test1', 'priority' => 11],
                            ['callback' => 'test2'],
                        ],
                        'the_title' => [
                            ['callback' => 'test3', 'args' => 2],
                            ['callback' => 'test3', 'priority' => -20, 'args' => 2],
                        ],
                    ],
                ],
                'out' => [
                    'actions' => [
                        'the_content' => [
                            ['callback' => 'test1', 'priority' => 11, 'args' => 1],
                            ['callback' => 'test2', 'priority' => 10, 'args' => 1],
                        ],
                        'the_title' => [
                            ['callback' => 'test3', 'priority' => 10, 'args' => 2],
                            ['callback' => 'test3', 'priority' => -20, 'args' => 2],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function incorrectActionsConfigs()
    {
        return [
            [
                [
                    'actions' => [
                        'the_content' => [
                            ['priority' => 11],
                            ['undefined_key' => 'some value'],
                            ['callback' => 'test', 'priority' => 'is string'],
                            ['callback' => 'test', 'args' => 'is string'],
                            ['callback' => 'test', 'args' => ['array']],
                            ['callback' => ['array']],
                        ],
                    ],
                ],
            ],
            [
                'actions' => [
                    [
                        'the_content' => [
                            ['callback' => 'test1', 'priority' => 11],
                            ['callback' => 'test2'],
                        ],
                    ],
                    'the_title' => [
                        [['callback' => 'test3', 'args' => 2]],
                    ],
                ],
            ],
        ];
    }
}
