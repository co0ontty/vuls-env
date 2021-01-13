FROM co0ontty/ubuntu:16.04
RUN apt update && apt install -y nginx
COPY nginx.conf /etc/nginx/
RUN echo "/etc/init.d/nginx start\ntail -f /var/log/nginx/access.log" >> /etc/nginxbalance.sh
CMD [ "sh","/etc/nginxbalance.sh" ]