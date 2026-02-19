FROM ubuntu:24.04

ARG WWWGROUP=1000
ARG NODE_VERSION=24

# Install additional OS packages.
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get -y install --no-install-recommends gnupg curl ca-certificates git libcap2-bin \
    && mkdir -p ~/.gnupg \
    && chmod 600 ~/.gnupg \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E5267A6C \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C300EE8C \
    && echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu noble main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get -y install --no-install-recommends php8.4 php8.4-curl php8.4-intl php8.4-gmp php8.4-xml php8.4-zip \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

# Development user
RUN userdel -r ubuntu
RUN groupadd --force -g $WWWGROUP development
RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 development
RUN git config --global --add safe.directory /var/www/html

# Configure PHP4 as default
RUN update-alternatives --set php /usr/bin/php8.4
RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.4

USER development
WORKDIR /var/www/html