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
interface HandlerInterface
{
    /**
     * Processing data.
     *
     * @param mixed|null $data
     */
    public static function handle($data = null);
}
