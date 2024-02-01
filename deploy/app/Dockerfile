FROM php:8.2-fpm

ARG UID
ARG USER
ARG APP_MOUNTING_AREA
ENV UID=${UID:-1000} USER=${USER:-sammy} APP_MOUNTING_AREA=${APP_MOUNTING_AREA:-/var/www/cs2-skin-helper/app}

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
