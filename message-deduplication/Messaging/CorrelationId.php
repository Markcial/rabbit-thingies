<?php

namespace Ulabox\Messaging;

use PhpAmqpLib\Message\AMQPMessage;
use Ramsey\Uuid\Uuid;

class CorrelationId
{
    /** @var string */
    private $value;

    /**
     * CorrelationId constructor.
     * @param $value
     */
    private function __construct($value) {
        $this->value = $value;
    }

    /**
     * @param AMQPMessage $message
     * @return CorrelationId
     */
    public static function createFromMessage(AMQPMessage $message)
    {
        $body = json_decode($message->body);

        return new self($body->correlation_id);
    }

    public static function createWithRandomUUID()
    {
        return new self(Uuid::uuid1());
    }

    /**
     * @return string
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
