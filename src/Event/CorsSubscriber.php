<?php declare(strict_types=1);

namespace BalticRobo\Api\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

final class CorsSubscriber implements EventSubscriberInterface
{
    private $headers = [
        'Access-Control-Allow-Credentials' => 'true',
        'Access-Control-Allow-Headers' => 'Origin, Content-Type, Accept, Authorization',
        'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
    ];

    public function __construct(string $origin)
    {
        $this->headers['Access-Control-Allow-Origin'] = $origin;
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }
        $request = $event->getRequest();
        if ('OPTIONS' === $request->getMethod()) {
            $response = new Response();
            foreach ($this->headers as $key => $value) {
                $response->headers->set($key, $value);
            }
            $response->headers->set('Access-Control-Max-Age', 3600);
            $event->setResponse($response);
        }
    }

    public function onKernelResponse(FilterResponseEvent $event): void
    {
        $response = $event->getResponse();
        foreach ($this->headers as $key => $value) {
            $response->headers->set($key, $value);
        }
        $response->headers->set('Vary', 'Origin');
        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 300],
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }
}
