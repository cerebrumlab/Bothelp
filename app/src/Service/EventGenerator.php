<?php

declare(strict_types=1);

namespace App\Service;

final class EventGenerator
{
    public static function generateEvent(
        int $clients = 1000,
        int $events = 10000
    ):\Generator
    {
        $eventsPerClient = (int)ceil($events / $clients);
        for ($client =1;$client<=$clients;$client++){
            for($event =0;$event < $eventsPerClient;$event++){
                yield [
                    'account_id' => $client,
                    'event_id' => random_int(1, 10)
                ];
            }
        }
    }

}
