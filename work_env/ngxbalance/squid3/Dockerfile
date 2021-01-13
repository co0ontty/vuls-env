FROM co0ontty/ubuntu:16.04
RUN apt update && apt install -y squid3 
COPY ./config/squid.conf /etc/squid/
RUN echo "/etc/init.d/squid start \nsleep 5\ntail -f /var/log/squid/access.log" >> /home/startProxy.sh
RUN cat /home/startProxy.sh
CMD [ "sh","/home/startProxy.sh" ]