# Message deduplication example

This example creates a rabbit queue, sends a message and the consumer processes the message sending a unack notification
so the message gets re-queued and sent again, the receiver has a function where he checks for the `redelivered` flag and
if the correlation id was already processed, skips that message.

The script `test.sh` executes the example with docker.

