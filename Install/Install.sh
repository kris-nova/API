#!/usr/bin/env bash

###############################################################################
#
# API [API.git] Provision Shell Script
#
#				..Kris
###

PHP_TARBALL="php-7.0.0RC3.tar.gz"
PHP_TARBALL_URL="https://downloads.php.net/~ab/$PHP_TARBALL"

##
# Update our system first
#
echo '--- Updating ---'
yum -y update
echo '...done'

##
# Define front end dependencies here
# If we are missing a package on the server and it needs to be installed
# It is critical that we also add it here
#
echo '--- Installing dependencies ---'
yum install -y gcc gcc-c++ screen vim nano unzip curl wget man git strace emacs
echo '...done'

##
# Install PHP 7
#
# Here be dragons
#
echo '--- Installing PHP 7 ---'

if [[ -n $(php -i | grep phpinfo) ]]; then
	echo 'PHP Already Installed!'
else
	yum install -y libxml2 libxml2-devel
	cd /usr/local/src
	wget $PHP_TARBALL_URL
	tar -xzf $PHP_TARBALL
	cd php*
	./configure
	make
	make install
fi
echo '...done'

##
# Install PHPUnit
# Rule number 76
#
echo '--- Installing PHPUnit ---'
cd ~
wget https://phar.phpunit.de/phpunit.phar
chmod +x phpunit.phar
sudo mv phpunit.phar /usr/local/bin/phpunit
phpunit --version
echo '...done'
