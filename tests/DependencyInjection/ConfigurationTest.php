<?php

/*
 * This file is part of the NucleosGDPRBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\GDPRBundle\Tests\DependencyInjection;

use Nucleos\GDPRBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

final class ConfigurationTest extends TestCase
{
    public function testDefaultOptions(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), []);

        $expected = [
        ];

        self::assertSame($expected, $config);
    }

    public function testBlockedCookieEnabled(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), [[
            'block_cookies' => null,
        ]]);

        $expected = [
            'block_cookies' => [
                'keep'      => ['PHPSESSID'],
            ],
        ];

        self::assertSame($expected, $config);
    }

    public function testBlockedCookieOptions(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), [[
            'block_cookies' => [
                'keep' => ['SOMEKEY', 'OTHERKEY'],
            ],
        ]]);

        $expected = [
            'block_cookies' => [
                'keep'      => ['SOMEKEY', 'OTHERKEY'],
            ],
        ];

        self::assertSame($expected, $config);
    }
}
