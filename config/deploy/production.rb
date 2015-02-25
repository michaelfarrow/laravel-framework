server ENV['DEPLOY_PRODUCTION_HOST'], user: ENV['DEPLOY_PRODUCTION_USER'], roles: %w{all}, my_property: :my_value

set :file_owner, ENV['DEPLOY_PRODUCTION_FILE_OWNER']

set :deploy_to, ENV['DEPLOY_PRODUCTION_PATH']
