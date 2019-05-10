<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\GDPRBundle\Tests;

use Core23\GDPRBundle\Core23GDPRBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

final class Core23GDPRBundleTest extends TestCase
{
    public function testItIsInstantiable(): void
    {
        $bundle = new Core23GDPRBundle();

        static::assertInstanceOf(BundleInterface::class, $bundle);
    }
}
