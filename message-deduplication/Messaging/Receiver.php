<?php

namespace Ulabox\Messaging;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Receiver
{
    /** @var AMQPChannel */
    private $channel;
    /** @var AMQPStreamConnection */
    private $connection;
    /** @var CorrelationId[] */
    private $blacklist;

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

    private function isDuplicated(AMQPMessage $message)
    {
        return $message->delivery_info['redelivered'] &&
            !in_array($message->delivery_info['delivery_tag'], $this->blacklist);
    }

    public function handle(AMQPMessage $message)
    {
        echo " [x] Received ", $message->body, "\n";
        $this->blacklist[] = CorrelationId::createFromMessage($message)->value();
        if ($this->isDuplicated($message) ) {
            echo " [x] Got dupe for this message\n";
            return $this->channel->basic_ack($message->delivery_info['delivery_tag']);
        }

        echo " [x] Is not dupe'd yet, reschedule\n";
        return $this->channel->basic_nack($message->delivery_info['delivery_tag'], false, true);
    }

    public function listen()
    {
        while (true) {
            echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
            $this->channel->basic_consume('hello', '', false, false, false, false, [&$this, 'handle']);

            while (count($this->channel->callbacks)) {
                $this->channel->wait();
            }
        }
    }
}