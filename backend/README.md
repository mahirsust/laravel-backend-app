# Laravel Backend App

A demo project showcasing three core Laravel backend concepts: **Redis caching**, **queue/job processing**, and **task scheduling** — all running in Docker.

## Stack

| Service | Technology |
|---|---|
| App | PHP 8.3 + Laravel 13 |
| Web server | Nginx 1.31.2 |
| Database | MySQL 8.0 |
| Cache & Queue | Redis 7.0 |
| Redis GUI | RedisInsight 3.6.0|
| Queue dashboard | Laravel Horizon |
| Scheduler | Laravel Scheduler |

## Getting Started

**1. Clone and set up environment variables**

```bash
cp .env.example .env
```

**2. Start all services**

```bash
docker compose up -d
```

**3. Install dependencies and run migrations**

```bash
docker exec laravel_container composer install
docker exec laravel_container php artisan migrate
docker exec laravel_container php artisan db:seed --class=ProjectSeeder
```

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
