# php-rss-reader

Create .env form .env.example

Run:
```
    docker-compose up -d
    docker exec app php artisan key:generate
    docker exec app php artisan migrate
    docker exec app php artisan queue:listen
    docker exec app php artisan schedule:work


Local Urls:
    http://127.0.0.1:9500/feed
    http://127.0.0.1:9500/rss

Local RabbitMq:
    http://localhost:15672/#/queues

Credentials:
    RabbitMq:
        user:guest
        password:guest
    Mysql:
        user:root
        password:password
        port: 13012

RSS Feed URLs:
        https://feeds.simplecast.com/qm_9xx0g
        https://thewest.com.au/rss
