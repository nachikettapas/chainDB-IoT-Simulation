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