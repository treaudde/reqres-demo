FROM treaudde/simple-production-environment:latest
COPY ./src /var/www/html
RUN chmod -R 777 /var/www/html/storage