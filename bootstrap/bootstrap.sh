#!/usr/bin/env bash

OSNAME="$1"
BOOTSTRAPREPO="$2"
R10KREPO="$3"
ENVIRONMENT="$4"

BOOTSTRAP_DIR="/etc/puppet-bootstrap"
ENV_DIR="/etc/puppet-environment"

apt-get install -y git ruby-dev make

if [ ! -d "$BOOTSTRAP_DIR/.git" ]
then
	git clone -b master --single-branch "$BOOTSTRAPREPO" "$BOOTSTRAP_DIR"
else
	cd "$BOOTSTRAP_DIR"
	git pull
fi

/etc/puppet-bootstrap/scripts/init/$OSNAME.sh

gem install librarian-puppet -v 2.1.0

if [ ! -d "$ENV_DIR/.git" ]
then
	git clone -b "$ENVIRONMENT" --single-branch "$R10KREPO" "$ENV_DIR"
else
	cd "$ENV_DIR"
	git pull
fi

cd "$ENV_DIR"

hiera_conf='/etc/puppet/hiera.yaml'

[[ -f $hiera_conf ]] && rm $hiera_conf
[[ ! -h $hiera_conf ]] && ln -s /vagrant/hiera/hiera.yaml $hiera_conf

librarian-puppet install --verbose

users=$'root\nvagrant'

FACTER_users="${users}" FACTER_vhosts="default" FACTER_vhosts_full="/var/www/vhosts/default" puppet apply --modulepath "$ENV_DIR/modules" "$ENV_DIR/manifests/site.pp" --verbose --debug

