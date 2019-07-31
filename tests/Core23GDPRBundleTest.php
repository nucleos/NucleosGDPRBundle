<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\GDPRBundle\Tests;

use Core23\GDPRBundle\Core23GDPRBundle;
use Core23\GDPRBundle\DependencyInjection\Core23GDPRExtension;
use PHPUnit\Framework\TestCase;

final class Core23GDPRBundleTest extends TestCase
{
    public function testGetContainerExtension(): void
    {
        $bundle = new Core23GDPRBundle();

        static::assertInstanceOf(Core23GDPRExtension::class, $bundle->getContainerExtension());
    }
}
