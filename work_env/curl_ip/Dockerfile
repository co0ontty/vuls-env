FROM co0ontty/ubuntu:16.04
COPY html /var/www/html
RUN apt update && apt install -y apache2 php libapache2-mod-php && rm -rf /var/www/html/index.html
RUN echo "service apache2 start\ntail -f /var/log/apache2/access.log" >> /etc/StartMe.sh
CMD [ "sh","/etc/StartMe.sh" ]