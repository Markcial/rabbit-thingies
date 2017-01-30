# High availability rabbitmq cluster

Sample configuration tested for a HA cluster with HAProxy managing connections to a rabbitmq cluster.

The configuration resides on the [infrastructure/haproxy/conf/haproxy.cnf]() file.

The shell script `cluster.sh` creates the network with docker and runs the messaging receiver and the producer.

This example is a single HAProxy box sending round robin connections to two connected rabbitmq boxes.

## Things to test

Due to lack of time i have not yet tested, how the cluster might behave on certain circumstances.

   * HAProxy + 2 disconnected rabbitmq boxes (same network).
   * 1 HAProxy + 1 rabbitmq boxes for each network with 2 networks (4 total).
   * 1 HAProxy + 2 disconnected rabbitmq boxes in 2 separated networks.
   * Other configurations?

  

