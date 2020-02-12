# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  config.vm.box = "debian/contrib-buster64"

  config.vm.synced_folder ".", "/home/vagrant/money"

  config.vm.provider "virtualbox" do |vb|
    vb.gui = false
    vb.memory = "512"
  end

  config.ssh.extra_args = ["-t", "cd /home/vagrant/money; bash --login"]

end
