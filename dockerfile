# Usa una imagen base de PHP
FROM php:8.1-cli

# Instala las extensiones necesarias
RUN apt-get update && apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

# Establece el directorio de trabajo en el contenedor
WORKDIR /app

# Copia el archivo de configuración .env al contenedor
COPY .env /app/.env

# Copia el código fuente al contenedor
COPY . /app

# Expone el puerto en el que el servidor PHP escuchará
EXPOSE 8000

# Ejecuta el servidor PHP integrado
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
