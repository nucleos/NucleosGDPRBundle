<?php

/*
 * This file is part of the NucleosGDPRBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\GDPRBundle\Tests\EventListener;

use Nucleos\GDPRBundle\Block\Service\GDPRInformationBlockService;
use Nucleos\GDPRBundle\EventListener\KernelEventSubscriber;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class KernelEventSubscriberTest extends TestCase
{
    private const SOME_COOKIE_NAME    = 'SOME_COOKIE';
    private const KEEP_COOKIE_NAME    = 'KEEP_COOKIE';
    private const KEEP_REGEX          = 'ADMIN_.*';
    private const KEEP_REGED_EXAMPLE  = 'ADMIN_TEST';

    public function testCleanCookiesWithDisabledOption(): void
    {
        $response = new Response();
        $response->headers->setCookie(Cookie::create(self::SOME_COOKIE_NAME));
        $response->headers->setCookie(Cookie::create(self::KEEP_COOKIE_NAME));
        $response->headers->setCookie(Cookie::create(self::KEEP_REGED_EXAMPLE));
        $response->headers->setCookie(Cookie::create(GDPRInformationBlockService::COOKIE_NAME));

        $event = new ResponseEvent(
            $this->createStub(HttpKernelInterface::class),
            $this->createStub(Request::class),
            0,
            $response
        );

        $subscriber = new KernelEventSubscriber(null);
        $subscriber->cleanCookies($event);

        self::assertCount(4, $response->headers->getCookies());
        $this->assertHasCookie(self::SOME_COOKIE_NAME, $response);
        $this->assertHasCookie(self::KEEP_COOKIE_NAME, $response);
        $this->assertHasCookie(self::KEEP_REGED_EXAMPLE, $response);
        $this->assertHasCookie(GDPRInformationBlockService::COOKIE_NAME, $response);
    }

    public function testCleanCookiesWithConsent(): void
    {
        $response = new Response();
        $response->headers->setCookie(Cookie::create(self::SOME_COOKIE_NAME));
        $response->headers->setCookie(Cookie::create(self::KEEP_COOKIE_NAME));
        $response->headers->setCookie(Cookie::create(self::KEEP_REGED_EXAMPLE));
        $response->headers->setCookie(Cookie::create(GDPRInformationBlockService::COOKIE_NAME));

        $event = new ResponseEvent(
            $this->createStub(HttpKernelInterface::class),
            $this->createStub(Request::class),
            0,
            $response
        );

        $subscriber = new KernelEventSubscriber([
            self::KEEP_COOKIE_NAME,
            self::KEEP_REGEX,
        ]);
        $subscriber->cleanCookies($event);

        self::assertCount(4, $response->headers->getCookies());
        $this->assertHasCookie(self::SOME_COOKIE_NAME, $response);
        $this->assertHasCookie(self::KEEP_COOKIE_NAME, $response);
        $this->assertHasCookie(self::KEEP_REGED_EXAMPLE, $response);
        $this->assertHasCookie(GDPRInformationBlockService::COOKIE_NAME, $response);
    }

    public function testCleanCookiesWithNoConsent(): void
    {
        $response = new Response();
        $response->headers->setCookie(Cookie::create(self::SOME_COOKIE_NAME));
        $response->headers->setCookie(Cookie::create(self::KEEP_COOKIE_NAME));
        $response->headers->setCookie(Cookie::create(self::KEEP_REGED_EXAMPLE));

        $event = new ResponseEvent(
            $this->createStub(HttpKernelInterface::class),
            $this->createStub(Request::class),
            0,
            $response
        );

        $subscriber = new KernelEventSubscriber([
            self::KEEP_COOKIE_NAME,
            self::KEEP_REGEX,
        ]);
        $subscriber->cleanCookies($event);

        self::assertCount(2, $response->headers->getCookies());
        $this->assertHasCookie(self::KEEP_COOKIE_NAME, $response);
        $this->assertHasCookie(self::KEEP_REGED_EXAMPLE, $response);
    }

    public function testAddFLoCPolicy(): void
    {
        $response = new Response();

        $event = new ResponseEvent(
            $this->createStub(HttpKernelInterface::class),
            $this->createStub(Request::class),
            0,
            $response
        );

        $subscriber = new KernelEventSubscriber(null, false);
        $subscriber->addFLoCPolicy($event);

        self::assertTrue($response->headers->has('Permissions-Policy'));
        self::assertSame('interest-cohort=()', $response->headers->get('Permissions-Policy'));
    }

    public function testAddFLoCPolicyWithDisabledOption(): void
    {
        $response = new Response();

        $event = new ResponseEvent(
            $this->createStub(HttpKernelInterface::class),
            $this->createStub(Request::class),
            0,
            $response
        );

        $subscriber = new KernelEventSubscriber(null, true);
        $subscriber->addFLoCPolicy($event);

        self::assertFalse($response->headers->has('Permissions-Policy'));
    }

    private function assertHasCookie(string $cookieName, Response $response): void
    {
        self::assertCount(1, array_filter($response->headers->getCookies(), static function (Cookie $cookie) use ($cookieName): bool {
            return $cookie->getName() === $cookieName;
        }));
    }
}
