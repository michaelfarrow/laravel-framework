set :ssh_options, {
   keys: %w(~/.ssh/id_rsa),
   forward_agent: true,
   auth_methods: %w(publickey)
}

set :repo_url,  ENV['DEPLOY_REPO_URL']

namespace :composer do

	desc "Running Composer Install"
	task :install do
		on roles(:all), in: :sequence, wait: 2 do
			within release_path  do
				execute :composer, "install --no-dev --prefer-dist --no-interaction --quiet"
			end
		end
	end

end

namespace :laravel do

	desc "Setup Laravel folder permissions"
	task :permissions do
		on roles(:all), in: :sequence, wait: 2 do
			within release_path  do
				execute :chmod, "u+x artisan"
				execute :find, "storage/ -mindepth 1 -maxdepth 1 -type d -print0 | xargs -0 chmod 0775"
			end
		end
	end

	desc "Run Laravel Artisan migrate task."
	task :migrate do
		on roles(:all), in: :sequence, wait: 2 do
			within release_path  do
				execute :php, "artisan migrate --force"
			end
		end
	end

	desc "Run Laravel Artisan seed task."
	task :seed do
		on roles(:all), in: :sequence, wait: 2 do
			within release_path  do
				execute "[ $(find #{releases_path}/* -maxdepth 0 -type d | wc -l) != 1 ] || php #{release_path}/artisan db:seed"
			end
		end
	end

	desc "Optimize Laravel Class Loader"
	task :optimize do
		on roles(:all), in: :sequence, wait: 2 do
			within release_path  do
				execute :php, "artisan clear-compiled"
				execute :php, "artisan optimize"
				execute :php, "artisan route:cache"
				execute :php, "artisan config:cache"
				execute :php, "artisan view:clear"
			end
		end
	end

end

namespace :environment do

	desc "Check environment file exists"
	task :check do
		on roles(:all), in: :sequence, wait: 2 do
			execute "if [ ! -f #{shared_path}/.env ]; then exit 1; else echo Environment file exists; fi"
		end
	end

	desc "Excecute shell commands"
	task :shell do
		on roles(:all), in: :sequence, wait: 2 do
			execute "[ -d #{shared_path}/storage ] || cp -r #{release_path}/storage #{shared_path}/storage"
			execute "rm -rf #{release_path}/storage"
			execute "ln -s #{shared_path}/storage #{release_path}/storage"
			execute "ln -s #{shared_path}/.env #{release_path}/.env"
		end
	end

end

namespace :deploy do

	before :started, "environment:check"
	after :published, "composer:install"
	after :published, "environment:shell"
	after :published, "laravel:permissions"
	after :published, "laravel:optimize"
	after :published, "laravel:migrate"
	after :published, "laravel:seed"

end