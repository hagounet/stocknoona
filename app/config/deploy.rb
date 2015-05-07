
set   :application,   "stock_noona"
set   :deploy_to,     "/home/steph/www/trucmuche"
set   :domain,        "steph@localhost"

set   :scm,           :git
set   :repository,    "git@github.com:hagounet/stocknoona.git"

role  :web,           domain
role  :app,           domain, :primary => true

set   :use_sudo,      true
set   :keep_releases, 3

default_run_options[:pty] = true

set :use_composer, false
set :update_vendors, false

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]