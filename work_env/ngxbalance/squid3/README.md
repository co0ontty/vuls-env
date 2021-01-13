## 使用方法
```shell
docker build -t squid3 .
docker run -it -p 87:3128 -d squid3
```
## 配置文件中的关键字段
- 用户组 ip 白名单
acl knownsec src 172.17.0.1/24
http_access allow knownsec
