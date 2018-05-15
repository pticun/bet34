<?php

namespace Deployer;

require 'recipe/symfony4.php';

// Project name
set('application', 'betting');

// Project repository
set('repository', 'git@github.com:fbaudry/betting.git');
set('writable_use_sudo', false);

// Writable dirs by web server
set('allow_anonymous_stats', false);

// Hosts
host('betting.fr')
    ->set('deploy_path', '/var/www/betting')
    ->user('florian')
    ->port(22222)
    ->configFile('~/.ssh/config')
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
;

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');
