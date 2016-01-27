logger.level = Logger::MAX_LEVEL

set :application, "JDHM"
set :domain,      "phb.li"
set :user,        "ph"
set :use_sudo,    false
set :deploy_to,   "/var/www/jdhm-api"
set :app_path,    "app"
set :cache_warmup, false
ssh_options[:port] = 2222


set :repository,  "https://github.com/Pierre-Henri-Bourdeau/jdhm-api.git"
set :scm,         :git

set :model_manager, "doctrine"

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3


set :writable_dirs, [var/cache, var/logs]
