# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  config.vm.box = "debian/contrib-buster64"

  config.vm.synced_folder ".", "/home/vagrant/money"

  config.vm.provider "virtualbox" do |vb|
    vb.gui = false
    vb.memory = "512"
  end

  # uses Ansible 2.7
  config.vm.provision "setup", type: "ansible_local" do |ansible|
    ansible.compatibility_mode = "2.0"
    ansible.playbook = "setup.yaml"
    ansible.provisioning_path = "/home/vagrant/money/ansible"
  end

  config.vm.provision "composer", type: "ansible_local" do |ansible|
    ansible.compatibility_mode = "2.0"
    ansible.playbook = "composer.yaml"
    ansible.provisioning_path = "/home/vagrant/money/ansible"
  end

  config.ssh.extra_args = ["-t", "cd /home/vagrant/money; bash --login"]

end
