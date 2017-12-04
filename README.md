# Phalcon Shared Multi Module API skeleton

This is the application skeleton for a multi module application with integrated
API support and a shared module handler.

Idea behind the shared module is to have a one place which is not primarily used
as the application module but as a content module. Therefore you can find the
app module *common* which contains stuff like models, forms, library,
main (global) config, cache and logs. More things can be easily added here.

In this case, both *fronted* and *backend* modules have access to the shared data.
These two modules are initialized via *Module.php* which can be found in each module dir.
That's the main place where we merge things from *common* module, like config,
autoload paths and different services used by application globally or specific per
each module.

API part of application can be easily separated and used as a standalone application.
Main performance thing in this setup is that the application and API application
have independent initialization files so, for example - API does not need to init
all services and be dispatches through application setup.
See public files - *api.php* vs *index.php*...

As the main focus wasn't on API, the idea is taken from some other code example I
found and which seems me as an interesting solution on a Phalcon Micro structure.

### Vagrant machine built on:
- PHP 7.0 (PHP7.0-FPM)
- MySQL 8.0 (MariaDB)
- Nginx
- Elasticsearch 6.0
- Debian Jessie 64
- Redis
- Memcached
- Supervisor

## NOTE

The master branch will always contain the latest stable version.
If you wish to check older versions or newer ones currently under development, please switch to the relevant branch.

Feel free to contact me or send me a feedback or a suggestion. ;)

## Get Started

- fork project from github

- clone your project from github

- install vagrant - `run vagrant up`

- setup your local hosts file like:
  - 192.168.99.99   psmas.local
  - 192.168.99.99   psmas_api.local

- `vagrant ssh`

- `sudo -s` to become a root if needed

- `cd /vagrant` - go to main dir for app

- execute migrations with:
  - `phalcon migration run --config=app/common/config/cli_config.php`

- execute: `mysql -uroot -ppassword psmas < /vagrant/schemas/default.sql`

- run the APP on http://psmas.local

- run the API on http://psmas_api.local
  - user list example: http://psmas_api.local/user/list

- should be able to login with psmas@example.com/psmas_example
