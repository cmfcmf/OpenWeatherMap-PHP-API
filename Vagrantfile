# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/xenial64"

  config.vm.provision "shell", inline: <<-SHELL
    apt-get -y -qq update
    apt-get -y -qq install php-cli php-curl php-xml php-zip php-xdebug unzip git

    curl --silent https://getcomposer.org/installer | php > /dev/null 2>&1
    mv composer.phar /usr/local/bin/composer
    echo "cd /vagrant" >> /home/ubuntu/.bashrc
  SHELL
end
