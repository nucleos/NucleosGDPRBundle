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

namespace Nucleos\GDPRBundle\DependencyInjection;

use Nucleos\GDPRBundle\EventListener\KernelEventSubscriber;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class NucleosGDPRExtension extends Extension
{
    /**
     * @param array<mixed> $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('block.php');
        $loader->load('listener.php');

        $container->getDefinition(KernelEventSubscriber::class)
            ->replaceArgument(0, isset($config['block_cookies']) ? $config['block_cookies']['keep'] : null)
            ->replaceArgument(1, $config['privacy']['google_floc'])
        ;
    }
}
