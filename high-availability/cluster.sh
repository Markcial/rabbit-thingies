#!/bin/bash

docker-compose up -d rabbit1 rabbit2 haproxy
# wait a moment
sleep 10
# join the cluster
docker-compose exec rabbit2 rabbitmqctl stop_app
docker-compose exec rabbit2 rabbitmqctl join_cluster rabbit@rabbit1
docker-compose exec rabbit2 rabbitmqctl start_app
# start receiver
docker-compose up -d receiver
# start emitter
docker-compose up -d emitter