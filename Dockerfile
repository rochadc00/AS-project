FROM tomsik68/xampp:latest

RUN rm -R /opt/lampp/htdocs/*
COPY app /opt/lampp/htdocs

# create database
WORKDIR /opt/lampp/var/mysql/
RUN mkdir gamebet
RUN chmod -R a+rwx gamebet

WORKDIR /opt/lampp/htdocs
COPY db-init.sh .
RUN chmod +x db-init.sh