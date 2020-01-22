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

namespace WordpressWrapper\Config\Exception;

/**
 * Thrown when a callback does not exist.
 *
 * @author Roman Skoropadskyi <zipo.ckorop@gmail.com>
 */
class LoaderException extends \RuntimeException
{
    public function __construct(string $path, int $code = 0, \Throwable $previous = null)
    {
        $message = \sprintf('Some error occurred loading config "%s".', $path);

        if (null !== $previous) {
            $message .= PHP_EOL . $previous->getMessage();
        }

        parent::__construct($message, $code, $previous);
    }
}
