# =============================================================
#  Ступень 1: общая база. Всё, что нужно и разработке, и проду
# =============================================================
FROM php:8.5-fpm-alpine AS base

# libpq нужна для работы, postgresql-dev — только для сборки расширения.
# Ставим сборочные пакеты во временную группу .build-deps и удаляем её же командой
RUN apk add --no-cache libpq \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS postgresql-dev \
    && docker-php-ext-install pdo_pgsql \
    && apk del .build-deps

COPY docker/php/conf.d/ "$PHP_INI_DIR/conf.d/"

WORKDIR /var/www/html


# =============================================================
#  Ступень 2: зависимости. Нужна только на этапе сборки прод-образа
# =============================================================
FROM composer:2 AS vendor

WORKDIR /app

# Сначала только манифесты — слой переиспользуется, пока они не изменились
COPY composer.json composer.lock ./

RUN composer install \
        --no-dev \
        --no-scripts \
        --no-autoloader \
        --prefer-dist

# Теперь код, и только после него генерация автозагрузчика
COPY src/ ./src/
RUN composer dump-autoload --no-dev --optimize


# =============================================================
#  Ступень 3: образ для разработки — с Xdebug и Composer
# =============================================================
FROM base AS dev

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS linux-headers \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del .build-deps

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY docker/php/dev/ "$PHP_INI_DIR/conf.d/"

# Лог Xdebug пишут рабочие процессы от www-data, а не root
RUN touch /tmp/xdebug.log && chown www-data:www-data /tmp/xdebug.log


# =============================================================
#  Ступень 4: образ для продакшена — код внутри, ничего лишнего
# =============================================================
FROM base AS prod

COPY docker/php/prod/ "$PHP_INI_DIR/conf.d/"

# Готовые зависимости из ступени vendor — без Composer в финальном образе
COPY --from=vendor /app/vendor/ ./vendor/

COPY src/ ./src/
COPY public/ ./public/

USER www-data
