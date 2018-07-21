# Set Up Instructios

Assuming a fresh installation of Ubuntu 16.04 on a server/virtual machine

## Installing Python 3.6
Python 3.6 should be installed and be in use by `python3` in terminal.
https://www.rosehosting.com/blog/how-to-install-python-3-6-on-ubuntu-16-04/


### In case SSL is missing from pip

sudo apt-get install libreadline-gplv2-dev libncursesw5-dev libssl-dev libsqlite3-dev tk-dev libgdbm-dev libc6-dev libbz2-dev

And then re run the installation using 
`make`
`make install`

## Loacle
export LC_ALL="en_US.UTF-8"
export LC_CTYPE="en_US.UTF-8"
sudo dpkg-reconfigure locales

## Installing Bigchaindb
https://docs.bigchaindb.com/projects/server/en/latest/simple-network-setup.html#install-the-required-software


## NGINX 
After installing nginx from apt-get:

`sudo /etc/init.d/nginx start`

Open Port 80 using 

`sudo ufw allow 80`

Visit the IP address and Nginx Welcome message should appear

## uWSGI

`pip install uwsgi`

Create a file called `wsgi.py`
In it simply import the application and run it, the appication **must** be imported as `application` irresepective of it's actual name.

Sample File:

```python
from app import app as application

if __name__=="__main__":
	application.run()
```

### Testing uWSGI

```
uwsgi --socket 0.0.0.0:8000 --protocol=http -w wsgi
```

The flask app should be accessible at \<ip-address\>:8000




## Service File 

```
[Unit]
Description=Custom API uWSGI service

[Service]
User=abhinav
Group=www-data
Environment=PATH=/home/abhinav/chainDB-iot-simulation/custom-api/venv/bin
WorkingDirectory=/home/abhinav/chainDB-iot-simulation/custom-api
ExecStart=/home/abhinav/chainDB-iot-simulation/custom-api/venv/bin/uwsgi --ini custom-api.ini
Restart=always

[Install]
WantedBy=multi-user.target
```



## NGINX Config

```
server {
    listen 80;
    server_name 212.189.207.119;
    root /var/www/html;
    location / {
        include uwsgi_params;
        uwsgi_pass unix:/home/abhinav/chainDB-iot-simulation/custom-api/custom-api.sock;
    }
    location ~ \.php$ {
#       root /var/www/html;
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
        }

}

```


sudo mkdir -p /data/db/
sudo chown -R `id -u` /data/db


https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-in-ubuntu-16-04
https://www.digitalocean.com/community/tutorials/how-to-serve-flask-applications-with-uwsgi-and-nginx-on-ubuntu-14-04
https://www.digitalocean.com/community/questions/convert-run-at-startup-script-from-upstart-to-systemd-for-ubuntu-16

sudo lsof -i -P -n | grep LISTEN





mongod --fork --logpath /var/log/mongod.log
service mongod status
service mongod start
service mongod stop


## NODES

### Coordinator Node - Member 1
Host Name: `212.189.207.119`
Node ID: `513b536e3ebb2bc60c817c4e640d3ddbe6e0c7cb`
Public Key: `ntjRee68kn5ijvCMd01LyNm2dMuhpKaLieeaydLg3ns=`

### Member 2
Host Name: `40.115.47.175`
Node ID: `99966473345eb668695d29b2e12f6614597e0330`
Public Key: `2cU5ZnA3bo6Rm01XRqyQxqIddc4GQAMwEbRQ38+lDGI=`

### Member 3
Host Name: `bigchaindb3.unime.it`
Node ID: `8669eb382282b8759156760e004095bcdb10986a`
Public Key: `v3CI6fpQ59tNnmZ4VkFWZPs4sFKnl6L7mnGjZCxr97Y=`

### Member 4
Host Name: `139.99.201.115`
Node ID: `6d237812ba69562846c73a00225afc1f2796702a`
Public KeyL: `90cslPYMfdWD640GSuIafCQVQOi7wBgzF6PMqBwYHWM=`

513b536e3ebb2bc60c817c4e640d3ddbe6e0c7cb@212.189.207.119:26656,99966473345eb668695d29b2e12f6614597e0330@40.115.47.175:26656,8669eb382282b8759156760e004095bcdb10986a@bigchaindb3.unime.it:26656,6d237812ba69562846c73a00225afc1f2796702a@139.99.201.115:26656


{  
   "services":[  
      {  
         "id":"n1",
         "name":"node",
         "address":"212.189.207.119",
         "tags":[  
            "node1"
         ],
         "port":80
      },
      {  
         "id":"n2",
         "name":"node",
         "address":"40.115.47.175",
         "tags":[  
            "node2"
         ],
         "port":80
      },
      {  
         "id":"n3",
         "name":"node",
         "address":"bigchaindb3.unime.it",
         "tags":[  
            "node3"
         ],
         "port":80
      },
      {  
         "id":"n4",
         "name":"node",
         "address":"139.99.201.115",
         "tags":[  
            "node4"
         ],
         "port":80
      }

   ]
}


const { Resolver } = require('dns');
const resolver = new Resolver();
resolver.resolve4('node.service.consul', (err,addresses)=> {console.log(addresses);});
resolver.setServers(['212.189.207.119:8600']);