# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.vm.provision "shell", inline: <<-SHELL
    sudo apt-get update
    sudo apt-get install -y php5-cli

    sudo curl --silent https://getcomposer.org/installer | php > /dev/null 2>&1
    sudo mv composer.phar /usr/local/bin/composer
  SHELL
end
