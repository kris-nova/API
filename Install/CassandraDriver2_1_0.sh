#!/usr/bin/env bash
###############################################################################
#	Simple shell script to install our version of Cassandra CPP Driver
#
#				..Kris
###

cd /usr/local/src
yum install -y gmp gmp-devel
wget http://downloads.datastax.com/cpp-driver/centos/7/cassandra-cpp-driver-2.1.0-1.el7.centos.amd64.rpm #CPP Driver
wget http://downloads.datastax.com/cpp-driver/centos/7/cassandra-cpp-driver-devel-2.1.0-1.el7.centos.amd64.rpm #CPP Driver Libraries
wget http://downloads.datastax.com/cpp-driver/centos/7/libuv-1.7.4-1.el7.centos.amd64.rpm #Libuv
wget http://downloads.datastax.com/cpp-driver/centos/7/libuv-devel-1.7.4-1.el7.centos.amd64.rpm #Libuv devel
rpm -ivh cassandra-cpp-driver-2.1.0-1.el7.centos.amd64.rpm
rpm -ivh cassandra-cpp-driver-devel-2.1.0-1.el7.centos.amd64.rpm
rpm -ivh libuv-1.7.4-1.el7.centos.amd64.rpm
rpm -ivh libuv-devel-1.7.4-1.el7.centos.amd64.rpm