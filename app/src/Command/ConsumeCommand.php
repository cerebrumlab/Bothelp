<?php

namespace App\Command;

use App\Service\EventConsumer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:consume-events')]
class ConsumeCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('queueName', InputArgument::REQUIRED, 'Queue name');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        EventConsumer::work($input->getArgument('queueName'));
        return Command::SUCCESS;
    }
}
