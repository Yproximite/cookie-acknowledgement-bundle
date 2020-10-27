<?php

declare(strict_types=1);

namespace Yproximite\Bundle\CookieAcknowledgement\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Yproximite\Bundle\CookieAcknowledgement\Service\CookieAcknowledgementService;

class CookieAcknowledgementBarListener implements EventSubscriberInterface
{
    private $cookieService;

    /** @var int */
    private static $listenerKernelPriority = -128;

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', static::$listenerKernelPriority],
        ];
    }

    public function __construct(CookieAcknowledgementService $cookieService)
    {
        $this->cookieService = $cookieService;
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $this->injectCookieBar($event->getResponse());
    }

    protected function injectCookieBar(Response $response): void
    {
        if (false === $content = $response->getContent()) {
            return;
        }

        $pos = mb_strripos($content, '</body>');

        if (false !== $pos) {
            $toolbar = sprintf("\n%s\n", $this->cookieService->render());
            $content = mb_substr($content, 0, $pos).$toolbar.mb_substr($content, $pos);
            $response->setContent($content);
        }
    }
}
