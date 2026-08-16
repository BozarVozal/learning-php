# На проде нечего монтировать — статика должна быть внутри образа
FROM nginx:alpine

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# nginx сам отдаёт css, js и картинки, поэтому public/ нужен и ему тоже
COPY public/ /var/www/html/public/
