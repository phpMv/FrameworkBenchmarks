#!/bin/bash

/etc/init.d/memcached stop
cp /etc/memcached.conf /etc/memcached_11212.conf
sed -i "s|11211|11212|g" /etc/memcached_11212.conf

cp /lib/systemd/system/memcached.service /lib/systemd/system/memcached2.service
sed -i "s|/etc/memcached.conf|/etc/memcached_11212.conf|g" /lib/systemd/system/memcached2.service

systemctl start memcached2.service
systemctl start memcached.service

#/etc/init.d/memcached start -d -p 11211 -m 256 -u memcache

ps aux | grep memcached

/ubiquity/vendor/bin/Ubiquity init-cache -t=all

composer install --optimize-autoloader --classmap-authoritative --no-dev

service php7.4-fpm start && nginx -c /ubiquity/deploy/nginx.conf -g "daemon off;"