server ENV['DEPLOY_STAGING_HOST'], user: ENV['DEPLOY_STAGING_USER'], roles: %w{all}, my_property: :my_value

set :file_owner, ENV['DEPLOY_STAGING_FILE_OWNER']

set :deploy_to, ENV['DEPLOY_STAGING_PATH']

set :application, ENV['DEPLOY_STAGING_NAME']
