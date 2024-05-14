<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\EvendProducer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event/new/', name: 'new_event', methods: ['POST'])]
    public function createEvent(
        Request $request
    ): Response
    {
        try {
            $event = json_decode($request->getContent(), true);
            $producer = new EvendProducer();
            $producer->sendMessage($event);
        } catch (\Throwable $e) {
            $e->getMessage();
        }
        return new Response(json_encode('ok'));
    }

    #[Route('/test/', name: 'test', methods: ['GET'])]
    public function test():Response
    {
        $test = new EvendProducer();
        $test->init();
        return new Response(json_encode('ok'));
    }
}
