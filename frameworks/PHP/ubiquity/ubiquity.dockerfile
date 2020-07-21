FROM ubuntu:20.04

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update -yqq && apt-get install -yqq software-properties-common > /dev/null
RUN LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php
RUN apt-get update -yqq > /dev/null && \
    apt-get install -yqq nginx git unzip php7.4 php7.4-common php7.4-cli php7.4-fpm php7.4-mysql  > /dev/null

RUN apt-get update && apt-get install memcached libmemcached-tools -y

RUN apt-get update && apt-get install -y pkg-config libmemcached-dev zlib1g-dev
    && pecl install memcached \
    && echo "extension=memcached.so" > /etc/php/7.4/fpm/conf.d/20-memcached.ini

RUN apt-get install -yqq composer > /dev/null

COPY deploy/conf/* /etc/php/7.4/fpm/

ADD ./ /ubiquity
WORKDIR /ubiquity

RUN if [ $(nproc) = 2 ]; then sed -i "s|pm.max_children = 1024|pm.max_children = 512|g" /etc/php/7.4/fpm/php-fpm.conf ; fi;

RUN php composer.phar require phpmv/ubiquity-devtools:dev-master --dev

RUN chmod 777 -R /ubiquity/app/cache/*

RUN echo "opcache.preload=/ubiquity/app/config/preloader.script.php" >> /etc/php/7.4/fpm/php.ini

RUN /ubiquity/vendor/bin/Ubiquity init-cache

RUN composer install --optimize-autoloader --classmap-authoritative --no-dev --quiet

CMD /ubiquity/run-fpm-memcached.sh
