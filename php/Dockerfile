FROM php:8.3-fpm

RUN apt-get update \
    && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip libgmp-dev libc-ares2 libnode108 libuv1 node-acorn node-busboy node-cjs-module-lexer node-undici node-xtend nodejs-doc libpng-dev\
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-configure gmp \
    && docker-php-ext-install gmp \
    && curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install nodejs \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install gd
WORKDIR /var/www

RUN cd /opt \
    # Download installer and check for its integrity.
    && curl -sSL https://getcomposer.org/installer > composer-setup.php \
    && curl -sSL https://composer.github.io/installer.sha384sum > composer-setup.sha384sum \
    && sha384sum --check composer-setup.sha384sum \
    # Install Composer 2.
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer --2 \
    # Remove installer files.
    && rm /opt/composer-setup.php /opt/composer-setup.sha384sum
