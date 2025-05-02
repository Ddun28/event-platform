# Plataforma de Gestión de Eventos

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Redis](https://img.shields.io/badge/Redis-DC382D?style=for-the-badge&logo=redis&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![GitHub Actions](https://img.shields.io/badge/GitHub_Actions-2088FF?style=for-the-badge&logo=github-actions&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-FF5722?style=for-the-badge&logo=laravel&logoColor=white)

## 🚀 Tecnologías Principales

- **Backend**: Laravel 11
- **Base de Datos**: MySQL 8.0
- **Caché**: Redis
- **Contenerización**: Docker + Laravel Sail
- **Panel de Administración**: Filament
- **Búsqueda**: Meilisearch (opcional)
- **CI/CD**: GitHub Actions

## 📋 Requisitos del Sistema

- Docker >= 20.10
- Docker Compose >= 2.20
- PHP 8.3+
- Composer 2.6+

## 🛠️ Instalación Local

```bash
# 1. Clonar el repositorio
git clone https://github.com/tu-usuario/event-platform.git
cd event-platform

# 2. Copiar archivo de entorno
cp .env.example .env

# 3. Instalar dependencias PHP
./vendor/bin/sail composer install

# 4. Levantar servicios con Docker
./vendor/bin/sail up -d

# 5. Ejecutar migraciones y seeders
./vendor/bin/sail artisan migrate --seed

# 6. Instalar Filament (panel de administración)
./vendor/bin/sail artisan filament:install --panels
./vendor/bin/sail artisan make:filament-user

# 7. Compilar assets (opcional)
./vendor/bin/sail npm install && npm run dev
```

## 🔌 Acceso a Servicios

| Servicio          | URL                          |
|-------------------|------------------------------|
| 🚀 Aplicación     | http://localhost:8080        |
| 🛠️ Panel Admin   | http://localhost:8080/admin  |
| 📧 Mailpit        | http://localhost:8025        |
| 🔍 Meilisearch    | http://localhost:7700        |
