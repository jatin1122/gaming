FROM ubuntu:bionic

RUN ln -sf /usr/share/zoneinfo/Europe/London /etc/localtime
RUN apt-get update
RUN apt-get install -y php-cli php-zip php-bcmath php-mbstring composer nodejs npm rsync
RUN composer global require deployer/deployer

ENV PATH /root/.composer/vendor/bin:$PATH