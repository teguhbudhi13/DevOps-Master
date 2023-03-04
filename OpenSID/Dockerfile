FROM ubuntu:20.04

RUN apt-get update && apt-get install -y nginx php7.4-fpm php7.4-mysql \
    php7.4-curl php7.4-fileinfo php7.4-gd php7.4-iconv php7.4-json \
    php7.4-mbstring php7.4-mysqli php7.4-mysqlnd php7.4-tidy \
    php7.4-zip

COPY default /etc/nginx/sites-available/default


RUN mkdir /var/www/html/opensid
COPY opensid/ /var/www/html/opensid
RUN chown -R $USER:www-data /var/www/html/opensid \
    && chmod -R 775 /var/www/html/opensid


RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log

CMD ["sh", "-c", "service php7.4-fpm start && nginx -g 'daemon off;' 2>&1 >/var/log/nginx/access.log"]
