JDHM-api
========

A Symfony project created on January 27, 2016, 10:50 am.

Install
------------

``` SET RIGHTS ON FOLDERS

### SET RIGHTS ON FOLDERS
HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var/cache var/logs
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var/cache var/logs
