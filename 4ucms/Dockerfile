FROM co0ontty/lamp
COPY 4u /var/www/html/
RUN service apache2 restart && \
    service mysql restart && \
    apt update -y && \
    apt install php-mysql -y && \
    mysql -u root -p123456 -e "create database 4u;" && \
    echo "service apache2 restart && service mysql restart && tail -f /var/log/apache2/*" > /root/start.sh && \
    chmod +x /root/start.sh   
CMD ["sh", "-c", "/root/start.sh"]
