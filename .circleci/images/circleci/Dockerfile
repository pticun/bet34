FROM php:7.1-fpm

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -

RUN apt-get update && \
    apt-get install -y \
        apt-transport-https \
        build-essential devscripts

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list
RUN curl -sS https://www.dotdeb.org/dotdeb.gpg | apt-key add -
RUN echo "deb http://packages.dotdeb.org stable all" > /etc/apt/sources.list.d/dotdeb.list

RUN echo "deb http://http.debian.net/debian jessie-backports main" >> /etc/apt/sources.list.d/jessie-backports.list
RUN echo "deb http://ppa.launchpad.net/pinepain/libv8/ubuntu xenial main"  > /etc/apt/sources.list.d/pinepain-ubuntu-libv8-xenial.list
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 8A1FA819ADE4A6FA974A746240ECBCF960C60AA4

RUN apt-get update && \
    apt-get install -y -t jessie-backports \
        g++ \
        git \
        jq \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libv8-6.6 \
        libv8-6.6-dev \
        locales \
        mysql-client \
        nodejs \
        openjdk-8-jdk \
        python-pip \
        patchelf \
        redis-server \
        tomcat8 \
        unzip \
        yarn \
        zip && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install -j$(nproc) gd && \
    docker-php-ext-install intl && \
    docker-php-ext-install pdo pdo_mysql

RUN update-java-alternatives -s java-1.8.0-openjdk-amd64
RUN pip install awscli --upgrade

# Install libv8
RUN for A in /opt/libv8-6.6/lib/*.so; do patchelf --set-rpath '$ORIGIN' $A; done

RUN pecl install redis-3.1.6 && \
    pecl install apcu && \
    echo "/opt/libv8-6.6" | pecl install v8js && \
    echo "extension=redis.so" > /usr/local/etc/php/conf.d/php.ini && \
    echo "extension=apcu.so" >> /usr/local/etc/php/conf.d/php.ini && \
    echo "extension=v8js.so" >> /usr/local/etc/php/conf.d/php.ini && \
    echo "memory_limit=-1" >> /usr/local/etc/php/conf.d/php.ini

ENV DOCKERIZE_VERSION v0.3.0
RUN curl -L https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz > dockerize.tar.gz && \
    tar -C /usr/local/bin -xzvf dockerize.tar.gz && \
    rm dockerize.tar.gz

RUN locale-gen en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8
RUN echo "LC_ALL=en_US.UTF-8" >> /etc/environment
RUN echo "en_US.UTF-8 UTF-8" >> /etc/locale.gen
RUN echo "LANG=en_US.UTF-8" > /etc/locale.conf
RUN locale-gen en_US.UTF-8 --purge

RUN mkdir -p /var/www/project

ENV CATALINA_HOME=/usr/share/tomcat8/
ENV CATALINA_BASE=/var/lib/tomcat8/

WORKDIR /var/www/project
