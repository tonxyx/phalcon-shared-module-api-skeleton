VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "debian/jessie64"

  # modify port and IP params if needed
  config.vm.network :forwarded_port, guest: 80, host: 10901
  config.vm.network :forwarded_port, guest: 8081, host: 10902
  config.vm.network :forwarded_port, guest: 22, host: 10135
  config.vm.network :private_network, ip: "192.168.99.99"
  config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"
  config.ssh.forward_agent = true


  config.vm.provider :virtualbox do |vb|
    vb.name = "PSMAS"
    vb.customize ["modifyvm", :id, "--memory", "2048"]
    vb.customize ["modifyvm", :id, "--ostype", "Debian_64"]
  end

  config.vm.synced_folder "./", "/vagrant", id: "vagrant-root", nfs: true, mount_options: ['rw', 'vers=3', 'tcp', 'fsc']
  config.vm.provision :shell, path: "Vagrant/provision.sh"
  config.vm.provision :shell, run: "always",  path: "Vagrant/restart.sh"
end
