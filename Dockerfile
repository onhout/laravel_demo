FROM php:8.0.8
RUN apt update && apt upgrade -y && apt install software-properties-common unzip nano mariadb-client curl wget gnupg2 ca-certificates lsb-release apt-transport-https -y
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt update && apt install --no-install-recommends nodejs yarn -y && apt clean && apt autoremove

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN composer global require laravel/installer
RUN echo 'export PATH="$HOME/.composer/vendor/bin:$PATH"' >> ~/.bashrc
WORKDIR /app
