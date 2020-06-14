<?php

/*
 * This file is part of the NucleosGDPRBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\GDPRBundle\EventListener;

use Nucleos\GDPRBundle\Block\Service\GDPRInformationBlockService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class KernelEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var string[]
     */
    private $whitelist;

    /**
     * @param string[] $whitelist
     */
    public function __construct(array $whitelist = [])
    {
        $this->whitelist = $whitelist;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'cleanCookies',
        ];
    }

    public function cleanCookies(ResponseEvent $event): void
    {
        $headers = $event->getResponse()->headers;
        $cookies = $headers->getCookies();

        if ($this->hasCookieConsent($cookies)) {
            return;
        }

        foreach ($cookies as $cookie) {
            if ($this->isWhitelisted($cookie)) {
                continue;
            }

            $headers->removeCookie($cookie->getName());
        }
    }

    /**
     * @param Cookie[] $cookies
     */
    private function hasCookieConsent(array $cookies): bool
    {
        foreach ($cookies as $cookie) {
            if (GDPRInformationBlockService::COOKIE_NAME === $cookie->getName()) {
                return true;
            }
        }

        return false;
    }

    private function isWhitelisted(Cookie $cookie): bool
    {
        foreach ($this->whitelist as $name) {
            if ($cookie->getName() === $name || 1 === preg_match('#'.$name.'#', $cookie->getName())) {
                return true;
            }
        }

        return false;
    }
}
