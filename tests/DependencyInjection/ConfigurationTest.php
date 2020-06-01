<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\GDPRBundle\Tests\DependencyInjection;

use Core23\GDPRBundle\DependencyInjection\Configuration;
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

        static::assertSame($expected, $config);
    }

    public function testBlockedCookieEnabled(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), [[
            'block_cookies' => null,
        ]]);

        $expected = [
            'block_cookies' => [
                'whitelist' => ['PHPSESSID'],
            ],
        ];

        static::assertSame($expected, $config);
    }

    public function testBlockedCookieOptions(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), [[
            'block_cookies' => [
                'whitelist' => ['SOMEKEY', 'OTHERKEY'],
            ],
        ]]);

        $expected = [
            'block_cookies' => [
                'whitelist' => ['SOMEKEY', 'OTHERKEY'],
            ],
        ];

        static::assertSame($expected, $config);
    }
}
