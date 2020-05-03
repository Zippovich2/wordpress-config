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

namespace WordpressWrapper\Config\Handler;

/**
 * @author Skoropadskyi Roman <zipo.ckorop@gmail.com>
 */
final class Config implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public static function handle($data = null)
    {
        return $data['config'] ?? null;
    }
}
