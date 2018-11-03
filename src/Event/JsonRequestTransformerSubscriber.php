<?php declare(strict_types=1);

namespace BalticRobo\Api\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class JsonRequestTransformerSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        if ('json' !== $request->getContentType()) {
            return;
        }
        $content = $request->getContent();
        if (empty($content)) {
            return;
        }
        if (!$this->transformJsonBody($request)) {
            $event->setResponse(new JsonResponse([
                'error' => [
                    'message' => 'Unable to parse request.',
                ],
            ], Response::HTTP_BAD_REQUEST));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 100],
        ];
    }

    private function transformJsonBody(Request $request): bool
    {
        $data = json_decode($request->getContent(), true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            return false;
        }
        if (null === $data) {
            return true;
        }
        $request->request->replace($data);

        return true;
    }
}
