#!/usr/bin/env python
import pika

credentials = pika.credentials.PlainCredentials(
    username='root',
    password='admin'
)
connection = pika.BlockingConnection(
    pika.ConnectionParameters(host='haproxy', credentials=credentials)
)
channel = connection.channel()

channel.queue_declare(queue='hello')

channel.basic_publish(exchange='',
                      routing_key='hello',
                      body='Hello World!')
print(" [x] Sent 'Hello World!'")
connection.close()