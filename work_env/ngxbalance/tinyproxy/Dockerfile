FROM co0ontty/ubuntu:16.04
RUN apt update && apt install -y tinyproxy
COPY tinyproxy.conf /etc/tinyproxy.conf
RUN echo "/etc/init.d/tinyproxy start\nsleep 3\ntail -f /var/log/tinyproxy/tinyproxy.log" >> /etc/run.sh 
CMD ["sh","/etc/run.sh"]