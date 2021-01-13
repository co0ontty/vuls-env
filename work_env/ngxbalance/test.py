import sys
import requests
remote_server = sys.argv[1]
remote_port = sys.argv[2]
proxies = {'http': "{}:{}".format(remote_server,remote_port)}
resp = requests.get("http://myip.ipip.net",proxies=proxies)
if remote_server in resp.text:
    print ("success")
else:
    print (resp.text)