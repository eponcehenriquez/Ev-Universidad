# Ev-Universidad

Esta aplicación es un proyecto de Laravel que se conecta con un endpoint externo para la autenticación y gestión de usuarios.

## Requisitos

- PHP >= 7.3
- Composer

## Instalación

1. Clonar el repositorio:
   ```bash
   gh repo clone eponcehenriquez/Ev-Universidad
   cd Ev-Universidad

Instalar las dependencia:
    composer install


Generar la clave de la aplicación:
    php artisan key:generate

Ejecutar el servidor de desarrollo:
    php artisan serve


## Prueba
    php artisan test

    php artisan test --filter AuthControllerTest

## Cambio de Provider
En este proyecto, se ha reemplazado el provider predeterminado de Eloquent por un provider personalizado llamado MockApiUserProvider. Este provider se encarga de interactuar con el endpoint externo https://653040df6c756603295e7806.mockapi.io/v1/users para la autenticación y gestión de usuarios, en lugar de utilizar una base de datos local.

##Documentación de la API
La documentación de la API se encuentra en el archivo Doc-Api.raml.


