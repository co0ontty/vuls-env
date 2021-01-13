FROM co0ontty/ubuntu:16.04
RUN apt update && apt install -y python python-pip
RUN pip install shadowsocks -i https://pypi.tuna.tsinghua.edu.cn/simple
COPY config.json /etc/config.json
RUN echo "chmod 755 /etc/config.json\nssserver -c /etc/config.json start >> /var/log/ss.log\ntail -f /var/log/ss.log" >> /etc/startProxy.sh
CMD [ "sh","/etc/startProxy.sh" ]