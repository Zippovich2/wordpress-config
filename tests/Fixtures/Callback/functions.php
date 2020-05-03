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

if (!\function_exists('callback_1')) {
    function callback_1(): void
    {
    }
}

if (!\function_exists('callback_2')) {
    function callback_2(): void
    {
    }
}

if (!\function_exists('add_action')) {
    function add_action($action, $callback, $priority, $args)
    {
        return [$action, $callback, $priority, $args];
    }
}

if (!\function_exists('add_filter')) {
    function add_filter($action, $callback, $priority, $args)
    {
        return [$action, $callback, $priority, $args];
    }
}
