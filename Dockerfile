FROM php:8.5-fpm-bookworm

ARG user=appuser
ARG uid=1000

RUN apt-get update && apt-get install -y \
    git \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" bcmath gd intl pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=node:24-bookworm-slim /usr/local/bin /usr/local/bin
COPY --from=node:24-bookworm-slim /usr/local/lib/node_modules /usr/local/lib/node_modules

RUN useradd --create-home --groups www-data --uid "$uid" --shell /bin/bash "$user" \
    && mkdir -p "/home/$user/.composer" \
    && chown -R "$user:$user" "/home/$user"

WORKDIR /var/www

USER $user
