#!/usr/bin/env bash

HOME='/home/vagrant'



echo -e "\n--- Updating packages list ---\n"

apt-get update

debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'



echo -e "\n--- Install base packages ---\n"

apt-get install -y python-software-properties zsh curl wget git supervisor beanstalkd



echo -e "\n--- Setting Beanstalk to start on boot ---\n"

echo "START=yes" >> /etc/default/beanstalkd



echo -e "\n--- Add some repos to update our distro ---\n"

add-apt-repository ppa:ondrej/php5 -y



echo -e "\n--- Updating packages list ---\n"

apt-get update



echo -e "\n--- Installing Apache ---\n"

apt-get install -y apache2
rm -rf /var/www/html



echo -e "\n--- Installing MySql ---\n"

apt-get install -y mysql-server-5.5



echo -e "\n--- Installing PHP-specific packages ---\n"

apt-get install -y php5 phpunit libapache2-mod-php5 php5-curl php5-mysqlnd php5-mcrypt php5-gd php5-imagick



echo -e "\n--- Enabling mod-rewrite ---\n"

a2enmod rewrite



echo -e "\n--- We definitly need to see the PHP errors, turning them on ---\n"

sed -i "s/error_reporting .*/error_reporting = E_ALL/" /etc/php5/apache2/php.ini
sed -i "s/display_errors .*/display_errors = On/" /etc/php5/apache2/php.ini



echo -e "\n--- Updating apache user ---\n"

sed -i "s/APACHE_RUN_USER=.*/APACHE_RUN_USER=vagrant/" /etc/apache2/envvars



echo -e "\n--- Add environment variables to Apache ---\n"

cat > /etc/apache2/sites-enabled/000-default.conf <<EOF
<VirtualHost *:80>
	DocumentRoot /var/www/public
	
	<Directory />
		Options FollowSymLinks
		AllowOverride None
	</Directory>
	
	<Directory /var/www/>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>

	ErrorLog /var/log/apache2/error.log
	LogLevel warn
	CustomLog /var/log/apache2/access.log combined
</VirtualHost>
EOF



echo -e "\n--- Restarting Apache ---\n"

service apache2 restart



echo -e "\n--- Installing Composer for PHP package management ---\n"

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer



echo -e "\n--- Installing NodeJS and NPM ---\n"

apt-get install -y nodejs
apt-get install -y npm

ln -s /usr/bin/nodejs /usr/bin/node



echo -e "\n--- Installing Ruby dev tools ---\n"

apt-get build-dep ruby-libvirt
apt-get install -y ruby-dev


echo -e "\n--- Installing Gems ---\n"

gem install capistrano
gem install bundler
gem install compass


echo -e "\n--- Installing javascript components ---\n"

npm install -g bower@1.3.12
npm install -g gulp@^3.8.8



echo -e "\n--- Creating database ---\n"

mysql -uroot -proot -e "create database laravel5;"



echo -e "\n--- Updating project components and pulling latest versions ---\n"

cd /var/www
chown -R vagrant:vagrant "$HOME/tmp"

sudo -u vagrant -H sh -c "composer install"
sudo -u vagrant -H sh -c "npm install"
sudo -u vagrant -H sh -c "bower install --config.interactive=false"
sudo -u vagrant -H sh -c "php artisan migrate"
sudo -u vagrant -H sh -c "php artisan db:seed"
sudo -u vagrant -H sh -c "bundle install"
sudo -u vagrant -H sh -c "composer global require 'laravel/envoy=~1.0'"
[[ ! -f .env ]] && sudo -u vagrant -H sh -c "cp .env.example .env"


echo -e "\n--- Setting up dev tools and ssh start directory ---\n"

sudo -u vagrant -H sh -c "git clone https://weyforth@bitbucket.org/weyforth/dev.git $HOME/.dev"
sudo -u vagrant -H sh -c "$HOME/.dev/setup"

sudo -u vagrant -H sh -c "echo /var/www > $HOME/.start_dir"


echo -e "\n--- Setting up cron ---\n"

cat > /var/cron <<EOF
#!/bin/bash

source /var/www/cron/minutely
EOF

chmod +x /var/cron

(crontab -l ; echo "* * * * * sudo -u vagrant -H bash -c '/var/cron'") | crontab -



echo -e "\n--- Setting up Supervisor ---\n"

cat > /etc/supervisor/conf.d/queue.conf <<EOF
[program:queue]

command=php artisan queue:listen --tries=2
directory=/var/www
stdout_logfile=/var/www/storage/logs/supervisor.log
redirect_stderr=true
autostart=true
autorestart=true
EOF

supervisorctl reread
supervisorctl add queue
supervisorctl start queue



echo -e "\n--- Setting default shell to ZSH ---\n"

chsh -s /bin/zsh vagrant



echo -e "\n--- Generating SSH Key ---\n"

sudo -u vagrant -H sh -c "ssh-keygen -f $HOME/.ssh/id_rsa -t rsa -N ''"



echo -e "\n--- Public SSH Key: ---\n"

cat $HOME/.ssh/id_rsa.pub



