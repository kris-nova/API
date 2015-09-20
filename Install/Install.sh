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

##
# Install Composer because we all enjoy deployable code
#
echo '--- Installing composer ---'
if [[ ! -f /usr/local/bin/composer ]]; then
    curl -s https://getcomposer.org/installer | php
	# Make Composer available globally
	mv composer.phar /usr/local/bin/composer
else
	echo '[composer already installed]'
fi
echo '...done'

##
# Install the Apache Web Server and configure to start on boot
#
echo '--- Installing apache ---'
yum install -y httpd
chkconfig httpd on #Turn this on on boot!
echo '...done'

##
# Install the mod_ssl module for Apache because security is important
#
echo '--- Installing mod_ssl ---'
yum install -y mod_ssl
echo '...done'

##
# Install default vHost config
#
echo '--- Creating vHost ---'
cp -vp /workspace/API/Install/httpd/vhost.conf /etc/httpd/conf.d/vhost.conf
echo '...done'

##
# Install default HTTPd.conf
#
echo '--- Replacing Apache Config ---'
cp -vp /workspace/API/Install/httpd/httpd.conf /etc/httpd/conf/httpd.conf
echo '...done'

##
# Restart Apache!
#
echo '--- Restarting Services ---'
service httpd restart
echo '...done'

##
# Lets figure out how you can access this thing
# Spit out some IP addresses to try
#
echo '********************************************************************************'
echo '********************************************************************************'
echo '*'
echo '* You should now be able to find the VM IP address in here :' 
echo '*'
echo '*'
ifconfig | grep "inet"
echo '*'
echo '*'
echo '********************************************************************************'
echo '********************************************************************************'

##
# We should now have an updated and awesome dev server!
#