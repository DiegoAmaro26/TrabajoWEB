<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development/)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


####

####

# Autor

Desarrollado por: Diego Amaro Lopez  
Rol: Desarrollador

# Sobre PETMEDICINE

PetMedicine pretende ayudar en la gestion veterinaria a las empresas, ofreciendo un sistema dinamico y sencillo.
No requiere de formacion previa para los empleados y la escalabilidad es infinita.

A continuacion se detallan los requisitos, el metodo de instalacion, la distribucion de los archivos, y la ejecución.

## Requisitos

**Backend:** Laravel (PHP)
**Frontend:** HTML, CSS, Tailwind CSS, JavaScript
**Base de datos:** MySQL (XAMPP)
**Servidor local:** XAMPP
**Entorno de desarrollo:** Visual Studio Code

## Instalacion

Antes de continuar con el desarrolllo, debemos asegurarnos de tener todas las dependencias necesarias.
Prueba los siguentes comandos en la terminal:

    composer install
    npm install

## Distribucion del proyecto

### Gestión de usuarios
- Registro y login de hospitales veterinarios.
- Acceso a una plataforma de gestión personalizada.

### Gestión de clientes y mascotas
- Crear, editar y eliminar clientes.
- Asociar mascotas a clientes.
- Historial médico de cada mascota.
- Subida y almacenamiento de archivos relacionados (imágenes, documentos clínicos, etc.)

### Gestión de empleados
- Creación de fichas de empleados.
- Asignación de actos realizados por cada empleado, asegurando trazabilidad.

### Citas
- Gestión de citas en tabla.
- Visualización de la mascota asociada y motivo de consulta.

### Facturación
- Creación de productos y servicios personalizados.
- Generación automática de facturas con datos del hospital, cliente y productos/servicios usados.

## Ejecucion
Para lanzar la ejecicion del codigo recomiendo activar dos servidores.
Esto permitira que el motor de laravel y el de node.js trabajen juntos y muestren los cambios al momento.

- php artisan serve
- npm run dev

Para ello puedes usar la terminal que ofrece el IDE VisualStudio y la propia terminal del sistema operativo que utilices.
Si solo activas uno de ellos, es posible que haya secciones de codigo que no se ejecuten correctamente.

