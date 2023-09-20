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

namespace Nucleos\GDPRBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Nucleos\GDPRBundle\DependencyInjection\NucleosGDPRExtension;
use Nucleos\GDPRBundle\EventListener\KernelEventSubscriber;

final class NucleosGDPRExtensionTest extends AbstractExtensionTestCase
{
    public function testLoadDefault(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService('nucleos_gdpr.block.information');
        $this->assertContainerBuilderHasService(KernelEventSubscriber::class);

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(KernelEventSubscriber::class, 0, null);
        $this->assertContainerBuilderHasServiceDefinitionWithArgument(KernelEventSubscriber::class, 1, false);
    }

    public function testLoadWithCookieBlock(): void
    {
        $this->load([
            'block_cookies' => null,
        ]);

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(KernelEventSubscriber::class, 0, [
            'PHPSESSID',
        ]);
    }

    protected function getContainerExtensions(): array
    {
        return [
            new NucleosGDPRExtension(),
        ];
    }
}
