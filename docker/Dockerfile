FROM php:7.2-fpm

ARG TIMEZONE

# Install APT basic packages
RUN apt update && apt install -y curl git-all unzip gnupg bash-completion zlib1g-dev libicu-dev

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo_mysql bcmath intl
RUN pecl install apcu-5.1.8
RUN docker-php-ext-enable apcu

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

RUN \
    mkdir /var/www/app && \
    mkdir -p /var/log/nginx/ && \
    chmod -R 0777 /var/log/nginx

WORKDIR /var/www/app
