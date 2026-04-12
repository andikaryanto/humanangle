## syntax=docker/dockerfile:1.6
FROM andiaryanto11/wordpress:6.8.1-php8.3-apache-humanangle

USER root
WORKDIR /var/www/html

COPY --chown=www-data:www-data . /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80