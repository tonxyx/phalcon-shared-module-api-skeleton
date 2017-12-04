if [[ ! -d /root/.ssh ]]; then
  echo "Add github.com to known_hosts"
  mkdir /root/.ssh && touch /root/.ssh/known_hosts && ssh-keyscan -H github.com >> /root/.ssh/known_hosts && chmod 600 /root/.ssh/known_hosts
fi
  export DEBIAN_FRONTEND=noninteractive
  apt-get update

  mkdir /var/cache/nginx/
  chmod a+w /var/cache/nginx/

  apt-get install apt-transport-https -y --force-yes
  apt-key adv --keyserver hkp://p80.pool.sks-keyservers.net:80 --recv-keys 58118E89F3A912897C070ADBF76221572C52609D

  wget -qO - https://artifacts.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -
  wget https://www.dotdeb.org/dotdeb.gpg | sudo apt-key add dotdeb.gpg

  echo "deb http://ppa.launchpad.net/webupd8team/java/ubuntu xenial main" | tee /etc/apt/sources.list.d/webupd8team-java.list
  echo "deb-src http://ppa.launchpad.net/webupd8team/java/ubuntu xenial main" | tee -a /etc/apt/sources.list.d/webupd8team-java.list
  apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys EEA14886

  echo "deb https://artifacts.elastic.co/packages/6.x/apt stable main" | sudo tee -a /etc/apt/sources.list.d/elastic-6.x.list

  echo "deb http://packages.dotdeb.org jessie all" | tee -a /etc/apt/sources.list.d/dotdeb.list
  echo "deb-src http://packages.dotdeb.org jessie all" | tee -a /etc/apt/sources.list.d/dotdeb.list

  echo "deb http://ftp.hr.debian.org/debian/ jessie-backports main" | tee -a /etc/apt/sources.list

  apt-key update
  apt-get update
  apt-get install python-software-properties libssl-dev dialog -y --force-yes
  apt-get install curl wget htop byobu -y --force-yes

  curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh |  bash

  apt-get install php7.0-fpm php7.0-dev php7.0-curl php7.0-mcrypt php7.0-gd -y --force-yes
  apt-get install php7.0-mysql php7.0-apcu php7.0-redis php7.0-memcached -y --force-yes
  apt-get install php7.0-ssh2 php7.0-phalcon php7.0-xml php7.0-intl -y --force-yes

  apt-get install nginx-extras -t jessie-backports -y --force-yes
  apt-get install git vim -y --force-yes
  apt-get install redis-server memcached -y --force-yes
  apt-get install cachefilesd -y --force-yes
  apt-get install elasticsearch -y --force-yes
  apt-get install re2c unzip supervisor -y --force-yes
  apt-get install nodejs -y --force-yes
  apt-get install sendmail-bin -y --force-yes

  apt-get update
  apt-get install build-essential libssl-dev
  curl -sL https://raw.githubusercontent.com/creationix/nvm/v0.33.6/install.sh -o install_nvm.sh
  bash install_nvm.sh
  source ~/.bashrc
  nvm install 9.2.0
  nvm use 9.2.0
  npm install --global gulp-cli

  echo oracle-java8-installer shared/accepted-oracle-license-v1-1 select true | /usr/bin/debconf-set-selections
  apt-get install oracle-java8-installer -y --force-yes

  update-rc.d elasticsearch defaults 95 10

  debconf-set-selections <<< 'mysql-server-8.0 mysql-server/root_password password password'
  debconf-set-selections <<< 'mysql-server-8.0 mysql-server/root_password_again password password'
  apt-get install mariadb-server -y

  echo "create database psmas" | mysql -uroot -ppassword

  echo "RUN=yes" > /etc/default/cachefilesd

  rm /etc/nginx/sites-enabled/default
  ln -s /vagrant/Vagrant/nginx/psmas /etc/nginx/sites-enabled/psmas
  ln -s /vagrant/Vagrant/nginx/psmas /etc/nginx/sites-available/psmas

  ln -s /vagrant/Vagrant/nginx/psmas_api /etc/nginx/sites-enabled/psmas_api
  ln -s /vagrant/Vagrant/nginx/psmas_api /etc/nginx/sites-available/psmas_api

  ln -s /vagrant/Vagrant/supervisor/psmas.resque.conf /etc/supervisor/conf.d/psmas.resque.conf

  git config core.preloadindex true

  byobu-enable
  byobu-enable-prompt

  runuser -l vagrant -c 'byobu-enable'
  runuser -l vagrant -c 'byobu-enable-prompt'

  service nginx restart

  rm /etc/php/7.0/fpm/pool.d/www.conf
  ln -s /vagrant/Vagrant/php7-fpm/www.conf /etc/php/7.0/fpm/pool.d/www.conf

  cd /vagrant/
  curl -sS https://getcomposer.org/installer | php
  php composer.phar config -g github-oauth.github.com a967eab59684a92bad1dbe9f44a39cd9221f569c
  mv composer.phar /usr/bin/composer
  cd /vagrant
  composer install

  ln -s /vagrant/vendor/phalcon/devtools/phalcon.php /usr/bin/phalcon
  chmod ugo+x /usr/bin/phalcon

  service supervisor restart

  export LANGUAGE=en_US.UTF-8
  export LANG=en_US.UTF-8
  export LC_ALL=en_US.UTF-8
  locale-gen en_US.UTF-8
  dpkg-reconfigure locales
