FROM co0ontty/ubuntu:16.04
RUN apt update && apt install -y apache2 php libapache2-mod-php && \
    rm -rf /var/www/html/index.html && \
    echo "service apache2 start\ntail -f /var/log/apache2/access.log" >> /etc/startapache2.sh
COPY html /var/www/html
CMD [ "sh","/etc/startapache2.sh" ]
