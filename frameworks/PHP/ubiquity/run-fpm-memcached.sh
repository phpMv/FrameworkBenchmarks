#!/bin/bash

/etc/init.d/memcached start -d -p 11211 -m 256 -u memcache

#/etc/init.d/memcached status

ps aux | grep memcached

service php7.4-fpm start && \
    nginx -c /ubiquity/deploy/nginx.conf -g "daemon off;"