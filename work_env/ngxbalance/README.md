## 使用方法

- nginx

```bash
docker build -t nginxbalance .
docker run -it -p 86: -d nginxbalance
```

- squid3 

```bash
docker build -t squid3 .
docker run -it -p 87:3128 -d squid3
```

- tinyproxy

```bash
docker build -t tinyproxy .
docker run -it -p 88:8888 -d tinyproxy
```

- shadowsocks

```bash
docker build -t shadowsocks .
docker run -it -p 89:1234 -d shadowsocks
```

## 其他
- 使用 docker logs CONTAINER ID 即可查看相应 docker 的运行日志