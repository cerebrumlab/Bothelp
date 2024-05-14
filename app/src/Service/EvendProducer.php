<?php

declare(strict_types=1);

namespace App\Service;

use App\Utils\AmpqConnect;
use PhpAmqpLib\Message\AMQPMessage;

final class EvendProducer
{
    private static string $exchangerName = 'bot';

    public function init():void
    {

        $connection = AmpqConnect::getConnection();
        $channel = $connection->channel();
        $channel->exchange_declare(self::$exchangerName, 'direct', false, true, false);
        for ($i = 0; $i <= 100; $i++) {
            $queueName = 'bot' . $i;
            $channel->queue_declare($queueName, false, true, false, false);
            $channel->queue_bind($queueName, self::$exchangerName, $i);
        }

        $channel->close();
        $connection->close();
    }

    public function sendMessage($event): void
    {
        $connection = AmpqConnect::getConnection();
        $channel = $connection->channel();
        $message = new AMQPMessage(
            json_encode($event),
            [
            'content_type' => 'application/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]
        );
        $routKey = intdiv($event['account_id'],10);

        $channel->basic_publish($message, self::$exchangerName, $routKey);
        $channel->close();
        $connection->close();
    }
}
