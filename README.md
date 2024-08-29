# eduardo_pimentel-prueba-tecnica-php

# Proyecto PHP con Docker y PostgreSQL

Este proyecto utiliza PHP y PostgreSQL en contenedores Docker. A continuación, se detallan los pasos para clonar el repositorio, construir y levantar los contenedores, y ejecutar las migraciones.

## Pasos para Ejecutar el Proyecto

1. **Clonar el Repositorio**

   Clona el repositorio del proyecto en tu máquina local:

   git clone <URL_DEL_REPOSITORIO>
   cd <NOMBRE_DEL_REPOSITORIO>

2. **copiar y renombar archivo env**

    copia y renombre el archivo .env.templated a .env

3. **Construir y Levantar los Contenedores**

    levantar el ambiente:

    docker-compose up --build

4. **Ejecutar migracion inicial**

    Listar contenedores y acceder al contenedor web:

    4.1. docker ps (Lista de contenedores)

    4.2. docker exec -it <container-name> php scripts/migrations/create_users_table.php 
        example: docker exec -it backend-web-1 php scripts/migrations/create_users_table.php

4. **Open on**

    verifica el estatus del server

    http://localhost:8000/status
