JDHM-api
========

A Symfony project created on January 27, 2016, 10:50 am.

[![Build Status](https://travis-ci.org/Pierre-Henri-Bourdeau/jdhm-api.svg?branch=master)](https://travis-ci.org/Pierre-Henri-Bourdeau/jdhm-api)

# Installation
------------

#### Server deploy

``` bash
sudo visudo
# Allow ph for Capifony deploy
ph ALL=(ALL) NOPASSWD:ALL
```

#### Composer

``` bash
curl -sS https://getcomposer.org/installer | php && mv composer.phar ~/bin/composer && chmod +x ~/bin/composer
```

#### Project

``` bash
git clone git@github.com:Pierre-Henri-Bourdeau/jdhm-api.git && cd jdhm-api && composer install
```

#### Folders permission
``` bash

HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var/cache var/logs
sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var/cache var/logs

```
