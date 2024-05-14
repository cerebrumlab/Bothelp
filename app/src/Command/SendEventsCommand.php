<?php

namespace App\Command;

use App\Service\EventGenerator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsCommand(name: 'app:send-events')]
class SendEventsCommand extends Command
{
    /**
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = HttpClient::create();

        foreach (EventGenerator::generateEvent(1000, 10000) as $event) {
            try {
                $client->request(
                    'POST',
                    'http://host.docker.internal:8080/event/new/',
                    ['json' => $event]
                );

            } catch (TransportExceptionInterface $e) {
                echo $e->getMessage();
            }

        }

        return Command::SUCCESS;
    }
}
