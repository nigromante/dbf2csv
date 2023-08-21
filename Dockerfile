FROM php:7.4-fpm-alpine

RUN mkdir /Trabajo
WORKDIR /Trabajo

RUN apk add $PHPIZE_DEPS
RUN CPPFLAGS="-DHAVE_SYS_FILE_H" pecl install dbase
RUN docker-php-ext-enable dbase
