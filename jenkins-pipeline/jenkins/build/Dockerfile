FROM php:7.2-fpm

# Copy composer.lock composer.json /var/www
COPY composer.lock composer.json   /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    default-mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean &&  rm -rf  /var/lib/apt/list/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd


# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd  -u 1000 -ms /bin/bash -g www www
# Copy existing application directory contents

COPY . /var/www/

COPY start.sh /usr/local/bin/start
# Copy existing applications directory permissions
COPY --chown=www:www . /var/www
RUN chmod +x  /usr/local/bin/start
# Change current user to www
USER www

# Expose port and php-fpm server
EXPOSE 9000

#CMD ["php-fpm"]

CMD ["/usr/local/bin/start"]


