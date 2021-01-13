## 使用方法
```shell
docker build -t tinyproxy .
docker run -it -p 88:8888 -d tinyproxy
```
## 配置文件中的关键字段
- 用户 ip 白名单
Allow 127.0.0.1

- 默认连接超时时间
Timeout 600

- 开放端口
Port 8888