#!/usr/bin/env bash
hostname API
###############################################################################
#
# API [API.git] Provision Shell Script
#
#				..Kris
###
export PATH="/sbin:/bin:/usr/sbin:/usr/bin:/usr/local/bin"
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
yum install kernel-devel-$(uname -r) kernel-headers-$(uname -r) dkms -y #fix for guest additions centos7.x
/etc/init.d/vboxadd setup
echo '...done'

##
# Install PHP
# This will add the custom repo and install php
#
echo '--- Installing PHP ---'
if [[ -n $(yum repolist | grep webtatic) ]]; then
	echo '[Webtatic Repository already installed]'
else
	rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
	rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
XDEBUGCONF=$(cat <<EOF
	zend_extension=/usr/lib64/php/modules/xdebug.so
	xdebug.profiler_enable = 1
	xdebug.remote_enable = 1
	xdebug.remote_connect_back = 1
EOF
)
	echo "${XDEBUGCONF}" > /etc/php.d/xdebug.ini
fi
yum install -y php56w php56w-cli php56w-mbstring php56w-devel php56w-opcache php56w-pdo php56w-mysql php56w-xml php56w-soap php56w-mcrypt php56w-pecl-apcu php56w-pecl-xdebug php56w-posix
yum install -y mod_php #Needed for Apache
echo '...done'

##
# Install Cassandra Driver
#
# Here be dragons
#
cd /usr/local/src
yum install -y gmp gmp-devel
wget http://downloads.datastax.com/cpp-driver/centos/7/cassandra-cpp-driver-2.1.0-1.el7.centos.amd64.rpm #CPP Driver
wget http://downloads.datastax.com/cpp-driver/centos/7/cassandra-cpp-driver-devel-2.1.0-1.el7.centos.amd64.rpm #CPP Driver Libraries
wget http://downloads.datastax.com/cpp-driver/centos/7/libuv-1.7.4-1.el7.centos.amd64.rpm #Libuv
wget http://downloads.datastax.com/cpp-driver/centos/7/libuv-devel-1.7.4-1.el7.centos.amd64.rpm #Libuv devel
rpm -ivh cassandra-cpp-driver-2.1.0-1.el7.centos.amd64.rpm
rpm -ivh cassandra-cpp-driver-devel-2.1.0-1.el7.centos.amd64.rpm
rpm -ivh libuv-1.7.4-1.el7.centos.amd64.rpm
rpm -ivh libuv-devel-1.7.4-1.el7.centos.amd64.rpm
pecl install cassandra -y
echo "extension=cassandra.so" >> /etc/php.d/cassandra.ini

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
