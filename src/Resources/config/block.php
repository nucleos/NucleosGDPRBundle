<?php

/*
 * This file is part of the NucleosGDPRBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Nucleos\GDPRBundle\Block\Service\GDPRInformationBlockService;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()

        ->set('nucleos_gdpr.block.information', GDPRInformationBlockService::class)
            ->tag('sonata.block')
            ->args([
                new Reference('twig'),
                new Reference('request_stack'),
            ])

    ;
};
