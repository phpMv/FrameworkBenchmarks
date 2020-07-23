#!/bin/bash

/etc/init.d/memcached stop

cp /usr/lib/systemd/system/memcached.service /usr/lib/systemd/system/memcached_controller.service
sed-i ' s% environmentfile=/etc/sysconfig/memcached%environmentfile=/etc/sysconfig/memcached_controller% ' /usr/lib/systemd/system/memcached_controller.service

ln -s /usr/lib/systemd/system/memcached_controller.service /etc/systemd/system/multi-user.target.wants/memcached_controller.service 

cp /etc/sysconfig/memcached /etc/sysconfig/memcached_controller
sed -i ' s/port= "11211/port=" 11212 "/' /etc/sysconfig/memcached_controller

systemctl Enable Memcached_controller
systemctl Restart Memcached_controller

ps aux | grep memcached

/ubiquity/vendor/bin/Ubiquity init-cache -t=all

composer install --optimize-autoloader --classmap-authoritative --no-dev

service php7.4-fpm start && nginx -c /ubiquity/deploy/nginx.conf -g "daemon off;"