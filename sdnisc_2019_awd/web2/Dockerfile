FROM co0ontty/ubuntu:16.04
RUN apt update && \
    apt install -y apache2 libapache2-mod-php php &&\
    echo "service apache2 start\nrm -rf /var/www/html/index.html\ntail -f /var/log/apache2/access.log" >> /etc/startweb2.sh && \
    echo "flag{s998fga2rfasg41tfsag1r}" >> /flag
COPY www/ /var/www/
CMD ["sh","/etc/startweb2.sh"]
