<?php declare(strict_types=1);

namespace BalticRobo\Api\Controller\Cms;

use BalticRobo\Api\RequestValidator\Cms\Event\CreateEventRequestHandler;
use BalticRobo\Api\RequestValidator\RequestHandler;
use BalticRobo\Api\ResponseModel\Cms\EventResponse;
use BalticRobo\Api\Service\Cms\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/event")
 */
final class EventController extends Controller
{
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * @Route("/create", methods={"POST"})
     */
    public function createAction(Request $request, RequestHandler $handler)
    {
        $event = $handler->handle($request, new CreateEventRequestHandler());

        $this->eventService->create($event);

        return $this->json((new EventResponse($event))->respond(), Response::HTTP_CREATED);
    }
}
