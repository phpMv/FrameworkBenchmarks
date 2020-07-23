#!/bin/bash

/etc/init.d/memcached stop
systemctl disable memcached
/etc/init.d/memcached -d -p 11211 -m 256 -u memcache
/etc/init.d/memcached -d -p 11212 -m 256 -u memcache

ps aux | grep memcached

/ubiquity/vendor/bin/Ubiquity init-cache -t=all

composer install --optimize-autoloader --classmap-authoritative --no-dev

service php7.4-fpm start && nginx -c /ubiquity/deploy/nginx.conf -g "daemon off;"