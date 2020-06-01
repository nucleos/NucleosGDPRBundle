<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\GDPRBundle\Tests\DependencyInjection;

use Core23\GDPRBundle\DependencyInjection\Core23GDPRExtension;
use Core23\GDPRBundle\EventListener\KernelEventSubscriber;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

final class Core23GDPRExtensionTest extends AbstractExtensionTestCase
{
    public function testLoadDefault(): void
    {
        $this->load();

        $this->assertContainerBuilderHasService('core23_gdpr.block.information');
        $this->assertContainerBuilderNotHasService(KernelEventSubscriber::class);
    }

    public function testLoadWithCookieBlock(): void
    {
        $this->load([
            'block_cookies' => null,
        ]);

        $this->assertContainerBuilderHasService(KernelEventSubscriber::class);

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(KernelEventSubscriber::class, 0, [
            'PHPSESSID',
        ]);
    }

    protected function getContainerExtensions(): array
    {
        return [
            new Core23GDPRExtension(),
        ];
    }
}
