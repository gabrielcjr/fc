FROM php:7.1-alpine3.4

RUN apk add --no-cache bash \
                       curl \
                       jpeg-dev \
                       freetype-dev \
                       libpng-dev \
                       unzip \
                       mysql-client \
                       libxml2-dev \
                       git \
                       gnupg \
                       openjdk8 \
                       icu-dev && \
   curl https://raw.githubusercontent.com/eficode/wait-for/v2.1.3/wait-for --output /usr/bin/wait-for  && \
   chmod +x /usr/bin/wait-for

RUN docker-php-ext-install pdo pdo_mysql soap mbstring intl sockets zip && \
    docker-php-ext-configure gd --with-jpeg-dir=/usr --with-freetype-dir=/usr && \
    docker-php-ext-install gd

ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www
