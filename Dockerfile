FROM joomla:latest

ARG UNAME=www-data
ARG UGROUP=www-data
ARG UID=1000
ARG GID=100
RUN mkdir -p /var/www/html/media/templates/site/andromeda/
RUN mkdir -p /var/www/html/templates/andromeda/
RUN mkdir -p /var/www/html/language/de-DE/
RUN usermod  --uid $UID $UNAME
RUN groupdel $(getent group $GID | cut -d: -f1)
RUN groupmod --gid $GID $UGROUP

RUN chgrp -hR www-data /var/www/html
RUN chown -hR www-data /var/www/html