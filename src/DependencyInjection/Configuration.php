<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\GDPRBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('core23_gdpr');

        $rootNode = $treeBuilder->getRootNode();

        \assert($rootNode instanceof ArrayNodeDefinition);

        $this->addBlockCookiesSection($rootNode);

        return $treeBuilder;
    }

    private function addBlockCookiesSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('block_cookies')
                    ->children()
                        ->arrayNode('whitelist')
                             ->setDeprecated('Use keep node instead')
                             ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('keep')
                             ->defaultValue(['PHPSESSID'])
                             ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
