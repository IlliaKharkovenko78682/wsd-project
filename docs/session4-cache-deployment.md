# Session 4 - Cache and Deployment

## What `tasks.index` caches

The `tasks.index` cache key stores the response data for the task list endpoint.  
When the `/api/tasks` endpoint is requested, Laravel first checks whether the `tasks.index` key already exists in the cache.  
If the key exists, the cached list of tasks is returned immediately.  
If the key does not exist, Laravel queries the PostgreSQL database, retrieves the latest tasks, stores the result in Redis for 60 seconds, and then returns the data.

## Why `store`, `update`, and `destroy` call `Cache::forget('tasks.index')`

The `store`, `update`, and `destroy` methods modify the task data in the database.  
Because of this, the previously cached task list may become outdated.  
To prevent stale data from being returned to the client, these methods explicitly remove the `tasks.index` cache entry.  
The next request to `/api/tasks` then recreates the cache with the updated database content.

## Purpose of Redis in this stack

Redis is used as the cache backend for Laravel.  
Its purpose is to store frequently requested data in memory so that repeated reads can be served faster than querying PostgreSQL every time.  
In this laboratory, Redis stores the cached task list under the `tasks.index` key and allows the application to demonstrate cache population, invalidation, and repopulation.

## Purpose of Nginx in this stack

Nginx acts as the public entry point of the application.  
It serves the frontend static files and also works as a reverse proxy for API requests.  
Requests sent to `/api/` are forwarded to the Laravel backend container, while frontend routes are handled as a single-page application using `index.html`.  
Nginx also exposes a simple health endpoint used for service checks.

## Commands used to verify cache behavior

```bash
docker compose exec redis redis-cli PING
docker compose exec redis redis-cli DBSIZE
curl http://127.0.0.1:8080/api/tasks
docker compose exec redis redis-cli DBSIZE
curl -X POST http://127.0.0.1:8080/api/tasks -H "Content-Type: application/json" -d '{"title":"Created after caching","description":"This write should invalidate tasks.index","status":"todo","priority":"medium"}'
curl http://127.0.0.1:8080/api/tasks
docker compose exec redis redis-cli DBSIZE
time curl -s http://127.0.0.1:8080/api/tasks > /dev/null
time curl -s http://127.0.0.1:8080/api/tasks > /dev/null

# Session 6 – URL Shortener Module

## Purpose of the module

This module allows users to create short URLs from long URLs and redirect users from a short code to the original URL.

## Functional requirements

The system accepts a long URL and returns a short URL.

The system redirects users from a short code to the original URL.

The system validates the original URL.

The system stores URL mappings in PostgreSQL.

The system counts redirects using click_count.

## Non-functional requirements

The redirect should be fast.

The short code should be unique.

The API should return consistent JSON responses.

The system should use correct HTTP status codes.

The list endpoint should use Redis cache.

## Base62 encoding

Base62 converts numeric IDs into short text codes using digits, lowercase letters, and uppercase letters. This is useful because database IDs can be represented as short readable strings.

## Endpoints

POST /api/78682/v1/short-links

GET /api/78682/v1/short-links

GET /api/78682/v1/short-links/{id}

GET /r/{code}

## Testing evidence

The implementation was tested using curl commands. The evidence includes successful POST request, successful GET list request, validation error 422, redirect response 302, missing code response 404, and Redis DBSIZE after cache usage.