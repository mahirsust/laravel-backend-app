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
| `redisinsight_container` | RedisInsight (Redis GUI) | http://localhost:5541 |
| `horizon_container` | Laravel Horizon (queue dashboard) | http://localhost:8001/horizon |
| `scheduler_container` | Laravel task scheduler | — |

## Quick Start

**1. Clone the repo**

```bash
git clone https://github.com/mahirsust/laravel-backend-app.git
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
docker compose up -d --build
```

**4. Install dependencies, run migrations and seed**

```bash
docker exec laravel_backend composer install
docker exec laravel_backend php artisan key:generate
docker exec laravel_backend php artisan migrate
docker exec laravel_backend php artisan db:seed --class=ProjectSeeder
```

The app is now running at **http://localhost:8001**.

## Demo Endpoints

All endpoints are available at `http://localhost:8001`.

### Caching (Redis)

| Route | Description |
|---|---|
| `GET /slow-projects` | Fetches 100,000 projects directly from MySQL every time |
| `GET /fast-projects` | Serves from Redis cache (60s TTL), falls back to MySQL on miss |

Both return `source`, `time` (ms), and `count`. Hit `/fast-projects` twice to see the speed difference.

### Queue / Jobs

| Route | Description |
|---|---|
| `GET /without-queue` | Simulates a 5-second task synchronously — blocks the response |
| `GET /with-queue` | Dispatches the task to Redis queue and returns instantly |

### Scheduler

The `app:send-task-reminder` command runs every 15 seconds via the scheduler container. It logs a timestamped message to `storage/logs/laravel.log`.

## Dashboards

| Dashboard | URL |
|---|---|
| Laravel Horizon (queue monitor) | http://localhost:8001/horizon |
| RedisInsight (Redis GUI) | http://localhost:5541 |

## RedisInsight Setup

1. Open **http://localhost:5541**
2. Click **Connect existing database**
3. Replace `127.0.0.1` with `redis` (the Docker service name)
4. Click **Test Connection** — it should show success
5. Click **Add Database**
6. Click the database to open it

Once inside, you can switch between Redis databases using the **DB** selector:

| DB | Used for |
|---|---|
| `0` (default) | Queue jobs |
| `1` | Cache |
