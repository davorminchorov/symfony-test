FROM php:8.1-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip gcc \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN pecl channel-update pecl.php.net \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && git clone https://github.com/nrk/phpiredis.git \
    && ( \
        cd phpiredis \
        && phpize \
        && ./configure --enable-phpiredis \
        && make \
        && make install \
    ) \
    && rm -r phpiredis \
    && docker-php-ext-enable phpiredis

WORKDIR /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list
RUN apt update
RUN apt install symfony-cli

COPY php.ini /usr/local/etc/php/conf.d/extra-php-config.ini