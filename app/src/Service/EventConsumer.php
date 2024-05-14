<?php

namespace App\Service;

use App\Utils\AmpqConnect;

class EventConsumer
{
    public readonly string $queue;

    public static function work(string $queue)
    {
        $consumerTag = 'consumer';
        $connection = AmpqConnect::getConnection();
        $channel = $connection->channel();
        $channel->basic_consume(
            $queue,
            $consumerTag,
            false,
            false,
            false,
            false,
            function ($message) {
                sleep(1);
                $message->ack();
                // Send a message with the string "exit" to cancel the consumer.
                if ($message->body === 'exit') {
                    $message->getChannel()->basic_cancel($message->getConsumerTag());
                }
            }
        );
        register_shutdown_function(
            function ($channel, $connection) {
                $channel->close();
                $connection->close();
            },
            $channel,
            $connection
        );

        $channel->consume();
    }
}
