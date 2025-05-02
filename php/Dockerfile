FROM php:8.4-fpm

ARG USERGID
ARG USERUID
ARG USERNAME
ARG NODE_MAJOR

# Instalação de pacotes essenciais para Laravel
RUN apt update \
    && apt install -y \
    curl \
    git \
    unzip \
    vim \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libxml2-dev \
    libxslt1-dev \
    zlib1g-dev \
    libonig-dev \
    cron \
    gnupg \
    software-properties-common \
    sudo \
    bash-completion \
    zip \
    apt-utils

# Instalação das extensões PHP necessárias para Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql zip exif bcmath opcache

# Instalar o Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Fixar permissões para o usuário e grupo
RUN groupadd --gid ${USERGID} ${USERNAME} \
    && useradd --uid ${USERUID} --gid ${USERNAME} --shell /bin/bash --create-home ${USERNAME} \
    && usermod -aG www-data ${USERNAME} \
    && usermod -aG ${USERNAME} www-data \
    && usermod -aG sudo www-data

RUN echo "www-data ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

# Configurar o diretório do Laravel
RUN mkdir -p /var/www \
    && chown -R www-data: /var/www \
    && chmod -R 775 /var/www

WORKDIR /var/www

# Instalar Laravel Installer globalmente (opcional)
RUN composer global require laravel/installer

# Limpeza
RUN rm -rf /var/lib/apt/lists/*

EXPOSE 9000
CMD ["php-fpm"]
