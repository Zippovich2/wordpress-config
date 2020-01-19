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
    protected static function parseCallback(string $callback)
    {
        $parts = \explode(':', $callback);

        if (2 === \count($parts) && \is_callable($parts)) {
            return $parts;
        }

        if (\function_exists($callback)) {
            return $callback;
        }

        throw new CallbackException(\sprintf('Callback "%s" is not exists or is not callable.', $callback));
    }
}
