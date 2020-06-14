<?php

declare(strict_types=1);

/*
 * This file is part of the NucleosGDPRBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\GDPRBundle\Tests;

use Nucleos\GDPRBundle\DependencyInjection\NucleosGDPRExtension;
use Nucleos\GDPRBundle\NucleosGDPRBundle;
use PHPUnit\Framework\TestCase;

final class NucleosGDPRBundleTest extends TestCase
{
    public function testGetContainerExtension(): void
    {
        $bundle = new NucleosGDPRBundle();

        static::assertInstanceOf(NucleosGDPRExtension::class, $bundle->getContainerExtension());
    }
}
