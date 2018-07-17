# Set Up Instructios

Assuming a fresh installation of Ubuntu 16.04 on a server/virtual machine

## Installing Python 3.6
Python 3.6 should be installed and be in use by `python3` in terminal.
https://www.rosehosting.com/blog/how-to-install-python-3-6-on-ubuntu-16-04/

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






