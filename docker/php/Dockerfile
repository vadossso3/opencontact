FROM php:8.2-fpm-alpine

ENV PROJECT_ROOT /var/www/html

ARG PHP_EXTENSIONS="pdo pdo_mysql mysqli"

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN docker-php-ext-install $PHP_EXTENSIONS \
    && apk add --update apk-cron bash \
    && docker-php-ext-enable pdo_mysql

COPY ./docker/php/crontab /etc/cron.d/crontab

RUN chmod 0644 /etc/cron.d/crontab

RUN /usr/bin/crontab /etc/cron.d/crontab

CMD ["/usr/sbin/crond", "-f"]

EXPOSE 9000
CMD ["php-fpm"]

WORKDIR /var/www/html