FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libssl-dev \
    zip \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install PHP extensions
RUN docker-php-ext-install mbstring exif pcntl bcmath gd
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Get latest Composer
COPY .env.example /var/www/.env
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Create system user to run Composer and Artisan Commands

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

COPY ./.docker/php/laravel.ini /usr/local/etc/php/conf.d
COPY ./.docker/php/xlaravel.pool.conf /usr/local/etc/php-fpm.d/

# Set working directory
WORKDIR /var/www

USER $user

