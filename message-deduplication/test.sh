#!/bin/bash

docker-compose up -d rabbit
sleep 12
docker-compose up -d deduper
docker-compose up -d emitter
docker-compose logs deduper