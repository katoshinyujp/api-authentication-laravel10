FROM php:8.2-fpm
ENV TZ Asia/Tokyo
ENV COMPOSER_ALLOW_SUPERUSER 1
# install Lib for composer
RUN apt-get update -qq && \
    apt-get install --no-install-recommends -y libpq-dev libzip-dev git zip unzip && \
    apt-get clean && \
    rm -rf /var/cache/apt
RUN docker-php-ext-install pdo pdo_pgsql zip pdo_mysql mysqli
RUN apt-get install -y \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev libxpm-dev \
    libfreetype6-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install gd
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis
    
# php.conf php-fpm.conf
COPY php.ini /usr/local/etc/php/php.ini
COPY docker.conf /usr/local/etc/php-fpm.d/docker.conf
# install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update && \
    chmod +x /usr/local/bin/composer
COPY --chown=www:www . /var/www
# change owner
RUN chown www-data:www-data -R ./
