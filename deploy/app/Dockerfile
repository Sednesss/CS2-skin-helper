FROM php:8.2-fpm

ARG UID
ARG USER
ARG APP_MOUNTING_AREA
ENV UID=${UID:-1000} USER=${USER:-sammy} APP_MOUNTING_AREA=${APP_MOUNTING_AREA:-/var/www/cs2-skin-helper/app}

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libwebp-dev \
    libxml2-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    nano \
    libpq-dev \
    bash \
    zlib1g-dev \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-webp --with-jpeg
RUN cd /usr/src/php/ext/gd && make
RUN docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath pgsql zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update

WORKDIR ${APP_MOUNTING_AREA}

# Change group
RUN chown -R www-data:www-data ${APP_MOUNTING_AREA}

# Add user
RUN useradd -G www-data,root -u ${UID} -d /home/${USER} ${USER}
RUN mkdir -p /home/${USER}/.composer && \
    chown -R ${UID}:${UID} /home/${USER}
USER ${USER}
