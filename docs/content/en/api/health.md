---
title: Health
category: API
---

Health API endpoints are designed for your monitoring services.

# Install

1. Open **config/app.php**
2. Add `\LaraStrict\Health\HealthServiceProvider::class` to `providers`

# Usage

## API

> API middlewares are turned off for all APIs.

The service provider exposes these endpoints:

### /api/health/alive

This API endpoint is designed for checking if the Laravel app works. Especially we want to check NGINX -> PHP-FPM
connection and if the Laravel is booting.

Returns JSON response `{"message": "ok"}`.

## Docker compose

```yaml
  web:
    image: nginx:stable-alpine
    restart: "unless-stopped"
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./web:/app
      - ./docker/nginx/sites:/etc/nginx/conf.d/
      - ./docker/nginx/nginx.conf:/etc/nginx/nginx.conf:cached
    depends_on:
      - app
      - mailhog
    healthcheck:
      test: [ "CMD", "curl", "-f", "http://localhost/api/health/alive" ]
      retries: 3
      timeout: 5s

```

# Logs

When health APIs are used by monitoring every interval we do not want to spam the access log.

We do recommend to disable the access log for given API endpoint. Examples below will prevent logging
any `/api/health/*` call.

## Nginx

For NGINX we need to change the access_log definition in `server` or `http` block using `map`.

Example below prints access log to docker output.

```
http {
    ....
    map $request_uri $loggable {
        ~/api/health/ 0;
        default 1;
    }
    
    access_log /dev/stdout main_timed if=$loggable;
    ....
}
```

# Security

For security reasons you should disable access the API endpoint.

## Kubernetes - NGINX Ingress

```yaml
apiVersion: extensions/v1beta1
kind: Ingress
metadata:
  annotations:
    nginx.ingress.kubernetes.io/server-snippet: |
      if ( $request_uri ~ "^/api/health" ) { return 403; }
```

## Traefik

1. Install [blockpath plugin](https://github.com/traefik/plugin-blockpath)

### Router

Edit your **Dynamic file configuration** and add `middlewares.block-health`.

Then reference you middleware in your routes by the name `block-health`.

```yaml
http:
  routers:
    my-router:
      rule: host(`demo.localhost`)
      service: service-foo
      entryPoints:
        - web
      middlewares:
        - block-health
  middlewares:
    block-health:
      plugin:
        blockpath:
          regex:
            - ^/api/health/*
```

### Kubernetes ingress

For traefik ingress I've not found how to create middleware using annotations.

To make it add `middlewares.block-health` (from example above) in your existing dynamic file configuration and this to
your ingress.

Then just add `traefik.ingress.kubernetes.io/router.middlewares: block-health@file` to annotations.

```yaml
---
apiVersion: networking.k8s.io/v1
kind: Ingress
metadata:
  name: app
  annotations:
    kubernetes.io/ingress.class: traefik
    traefik.ingress.kubernetes.io/router.tls: "true"
    traefik.ingress.kubernetes.io/router.tls.certresolver: letsencrypt
    traefik.ingress.kubernetes.io/router.middlewares: block-health@file
```

### Proxy NGINX server

Example below should be in `http` or `server` block. This settings should not be applied to nginx that is
using `php-fpm` proxy pass.

```
if ( $request_uri ~ "^/api/health" ) { return 403; }
```
