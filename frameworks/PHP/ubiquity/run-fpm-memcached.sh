#!/bin/bash
cp /ubiquity/deploy/memcached/memcached.conf /etc/memcached.conf 

/etc/init.d/memcached start

/etc/init.d/memcached status

ps aux | grep memcached

/ubiquity/vendor/bin/Ubiquity init-cache -t=all

composer install --optimize-autoloader --classmap-authoritative --no-dev

service php7.4-fpm start && nginx -c /ubiquity/deploy/nginx.conf -g "daemon off;"