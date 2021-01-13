docker rm -f $(docker ps -aq)
docker build -t phpvulenv .
docker run -it -p 81:80 -d phpvulenv
