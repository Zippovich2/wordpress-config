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

use Zippovich2\Wordpress\Exception\CallbackException;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
abstract class CallbackParser
{
    /**
     * Parse callback and return it if it callable.
     *
     * @param string $callback
     * @param string|null $prefix
     *
     * @return array|string
     */
    protected static function parseCallback(string $callback, ?string $prefix = null)
    {
        // Check first if callback is function.
        if (\function_exists($callback)) {
            return $callback;
        }

        switch (true) {
            case \strpos($callback, '::'):
                $parts = \explode('::', $callback);

                break;

            case \strpos($callback, ':'):
                $parts = \explode(':', $callback);
                @\trigger_error('Using non static methods as callback is deprecated and will throw error in further versions.', E_USER_DEPRECATED);

                break;

            default:
                throw new CallbackException($callback);
        }

        if (2 === \count($parts) && \is_callable($parts)) {
            $class = null === $prefix ? $parts[0] : $prefix . $parts[0];
            $method = $parts[1];

            return [$class, $method];
        }

        throw new CallbackException($callback);
    }
}
