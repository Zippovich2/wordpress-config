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

namespace Zippovich2\Wordpress\Exception;

/**
 * Thrown when a callback does not exist.
 *
 * @author Roman Skoropadskyi <zipo.ckorop@gmail.com>
 */
final class CallbackException extends \RuntimeException
{
    public function __construct(string $path, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct(\sprintf('Callback "%s" does not exists.', $path), $code, $previous);
    }
}
