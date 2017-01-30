<?php

namespace Ulabox\Messaging;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Sender
{
    /** @var AMQPChannel */
    private $channel;
    /** @var AMQPStreamConnection */
    private $connection;

    public function __construct()
    {
        $this->setup();
    }

    private function setup($user='root', $password='admin', $host='rabbit-master', $port=5672)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('hello', false, false, false, false);
    }

    public function send()
    {
        echo " [x] Sent 'Hello World!'\n";

        $msg = new Message('Hello World!', CorrelationId::createWithRandomUUID());
        $this->channel->basic_publish($msg->encode(), '', 'hello');
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
