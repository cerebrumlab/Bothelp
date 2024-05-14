<?php

declare(strict_types=1);

namespace App\Utils;

use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;

final class AmpqConnect
{
    public static string $host ='rabbitmq';
    public static int $port = 5672;
    private static string $user = 'root';
    private static string $password = 'passwd';
    private static string $vhost = '/';

    public static function getConnection(): AbstractConnection
    {
        return new AMQPStreamConnection(self::$host, self::$port, self::$user, self::$password, self::$vhost);
    }
}
