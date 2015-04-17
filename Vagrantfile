# -*- mode: ruby -*-
# vi: set ft=ruby :

osname = "ubuntu"
bootstraprepo = "https://weyforth@bitbucket.org/weyforth/puppet-bootstrap.git"
r10krepo = "https://weyforth@bitbucket.org/weyforth/puppet-repository.git"
environment = "laravel5"

Vagrant.configure("2") do |config|	
	config.vm.network "private_network", type: "dhcp"

	config.vm.define environment do |config|

		config.vm.box = "ubuntu/trusty64"
		config.vm.box_url = "https://vagrantcloud.com/ubuntu/trusty64"

		# support 32-bit hosts :(
		if ENV["PROCESSOR_ARCHITECTURE"] == "x86"
			puts "falling back to 32-bit guest architecture"
			config.vm.box = "ubuntu/trusty32"
			config.vm.box_url = "https://vagrantcloud.com/ubuntu/trusty32"
		end

		config.ssh.forward_agent = true
		config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"
		
		config.vm.network :forwarded_port, guest: 80, host: 8888, auto_correct: true
		config.vm.network :forwarded_port, guest: 3306, host: 8889, auto_correct: true
		config.vm.network :forwarded_port, guest: 5432, host: 5433, auto_correct: true

		config.vm.synced_folder ".", "/vagrant", nfs: true
		config.vm.synced_folder ".", "/var/www/default", id: "vagrant-root", nfs: true

		config.vm.provision :shell, :inline => "dpkg-reconfigure --frontend noninteractive tzdata; sudo locale-gen en_GB.UTF-8"

		config.vm.provider :virtualbox do |v|
			v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]

			host = RbConfig::CONFIG['host_os']

			# Give VM 1/4 system memory & access to all cpu cores on the host
			if host =~ /darwin/
				cpus = `sysctl -n hw.ncpu`.to_i
				# sysctl returns Bytes and we need to convert to MB
				mem = `sysctl -n hw.memsize`.to_i / 1024 / 1024 / 4
			elsif host =~ /linux/
				cpus = `nproc`.to_i
				# meminfo shows KB and we need to convert to MB
				mem = `grep 'MemTotal' /proc/meminfo | sed -e 's/MemTotal://' -e 's/ kB//'`.to_i / 1024 / 4
			else # sorry Windows folks, I can't help you
				cpus = 2
				mem = 1024
			end

			v.customize ["modifyvm", :id, "--memory", mem]
			v.customize ["modifyvm", :id, "--cpus", cpus]
		end

		config.vm.host_name = File.basename(ENV['PWD']) + ".local"

		config.vm.provision "shell" do |shell|
			shell.path = "bootstrap.sh"
			shell.args = "'#{osname}' '#{bootstraprepo}' '#{r10krepo}' '#{environment}'"
		end

		config.vm.provision "shell" do |shell|
			shell.path = "install.sh"
		end

		config.vm.provision :shell, :inline => "cd /vagrant && php artisan migrate"
		config.vm.provision :shell, :inline => "[[ ! -f /etc/laravel_db_seeded ]] && cd /vagrant && php artisan db:seed && touch /etc/laravel_db_seeded; exit 0"

	end
end
