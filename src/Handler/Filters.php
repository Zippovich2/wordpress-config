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

namespace Zippovich2\Wordpress\Handler;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class Filters extends CallbackParser implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public static function handle($data = null): int
    {
        $counter = 0;
        $classPrefix = isset($data['callback_prefix']) ? $data['callback_prefix'] : null;

        if (null !== $data && isset($data['filters'])) {
            foreach ($data['filters'] as $filter => $callbacks) {
                foreach ($callbacks as $callback) {
                    self::createFilter(
                        $filter,
                        self::parseCallback($callback['callback'], $classPrefix),
                        $callback['priority'],
                        $callback['args']
                    );
                    ++$counter;
                }
            }
        }

        return $counter;
    }

    protected static function createFilter(string $filter, $callback, int $priority, int $args): void
    {
        if (\function_exists('add_filter')) {
            add_filter($filter, $callback, $priority, $args);
        }
    }
}
