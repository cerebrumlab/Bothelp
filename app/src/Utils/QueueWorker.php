<?php

declare(strict_types=1);

namespace App\Utils;

use Symfony\Component\Process\Process;
class QueueWorker
{
    /** @var Process[] array subworkers */
    private array $workers =[];
    private bool $restart = false;
    private bool $stop = false;
    public function init(): int
    {
        while ($this->stop === false) {
            $this->checkWorkers();
            sleep(10);
        }
        $this->stopWorkers();
        return 0;
    }
    public function checkWorkers():void
    {
        for ($i = 0; $i <= 100; $i++) {
            $queueName = 'bot' . $i;
            $command = ['php', 'bin/console', 'app:consume-events', $queueName];
            $worker = null;
            if(isset($this->workers[$queueName])){
                $worker = $this->workers[$queueName];
            }
            if(!$worker instanceof Process || !$worker->isRunning()){
                $worker = $this->startWorker($command);
                $this->workers[$queueName] = $worker;
            }

        }
    }
    public function startWorker(array $command): Process
    {
        $worker = new Process($command);
        $worker->setTimeout(null);
        $worker->start();
        return $worker;
    }
    public function stopWorkers(): void
    {
        foreach ($this->workers as $worker) {
            if ($worker->isRunning()) {
                $worker->stop(15, SIGINT);
            }
        }
    }
}
