# Laravel Backend App

A Dockerized Laravel 13 demo project showcasing **Redis caching**, **queue/job processing**, and **task scheduling**.

## Project Structure

```
laravel-backend-app/
├── backend/          # Laravel 13 application
├── docker/
│   ├── php/          # PHP 8.3-FPM Dockerfile
│   └── nginx/        # Nginx config
└── docker-compose.yml
```

## Services

| Container | Role | Exposed Port |
|---|---|---|
| `laravel_container` | PHP-FPM app server | — |
| `nginx_container` | Web server | http://localhost:8001 |
| `mysql_container` | MySQL 8.0 database | 3308 |
| `redis_container` | Redis (cache + queue) | 6380 |
| `horizon_container` | Laravel Horizon (queue dashboard) | http://localhost:8001/horizon |
| `scheduler_container` | Laravel task scheduler | — |
| `redisinsight_container` | RedisInsight (Redis GUI) | http://localhost:5541 |

## Quick Start

**1. Clone the repo**

```bash
git clone https://github.com/your-username/laravel-backend-app.git
cd laravel-backend-app
```

**2. Set up environment files**

```bash
# Docker environment
cp .env.example .env

# Laravel environment
cp backend/.env.example backend/.env
```

**3. Start all services**

```bash
docker compose up -d
```

**4. Install dependencies, run migrations and seed**

```bash
docker exec laravel_container composer install
docker exec laravel_container php artisan key:generate
docker exec laravel_container php artisan migrate
docker exec laravel_container php artisan db:seed --class=ProjectSeeder
```

The app is now running at **http://localhost:8001**.

> See [`backend/README.md`](backend/README.md) for details on demo endpoints and features.
