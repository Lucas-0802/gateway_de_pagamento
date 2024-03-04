FROM php:7.1.33-buster
RUN apt update -y && apt install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app
COPY . /app
RUN composer install
RUN touch /app/.env
CMD php artisan serve --host=0.0.0.0 --port=8080
EXPOSE 8080