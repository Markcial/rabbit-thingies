<?php

namespace Ulabox\Messaging;

use PhpAmqpLib\Message\AMQPMessage;

class Message
{
    /** @var  CorrelationId */
    private $correlationId;
    /** @var string */
    private $message;

    /**
     * Message constructor.
     * @param $body
     * @param CorrelationId $correlationId
     */
    public function __construct($body, CorrelationId $correlationId)
    {
        $this->message = $body;
        $this->correlationId = $correlationId;
    }

    /**
     * @return AMQPMessage
     */
    public function encode()
    {
        return new AMQPMessage(
            json_encode($this->toPayload())
        );
    }

    /**
     * @return array
     */
    public function toPayload()
    {
        return [
            'correlation_id' => $this->correlationId->value(),
            'message' => $this->message
        ];
    }
}