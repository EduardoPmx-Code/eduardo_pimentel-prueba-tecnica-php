# Usa una imagen base de PHP
FROM php:8.1-cli

# Instala las extensiones necesarias
RUN apt-get update && apt-get install -y libpq-dev git unzip && \
    docker-php-ext-install pdo pdo_pgsql

# Establece el directorio de trabajo en el contenedor
WORKDIR /app

# Copia solo los archivos necesarios para instalar las dependencias
COPY composer.json composer.lock /app/

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Ejecuta Composer install en la carpeta /app
RUN composer install --no-dev --optimize-autoloader

# Copia el resto del código fuente al contenedor
COPY . /app

# Expone el puerto en el que el servidor PHP escuchará
EXPOSE 8000

# Ejecuta el servidor PHP integrado
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
