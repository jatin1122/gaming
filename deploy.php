<?php namespace Deployer;

require 'recipe/common.php';
require __DIR__.'/resources/deploy/upload_dirs.php';

// Make sure each task has plenty of time to run
set('default_timeout', 2400);

// Set our current path
set('rsync_src', __DIR__);

// Set the path to the repo
set('repository', $_ENV['CI_REPOSITORY_URL'] ?? `git config --get remote.origin.url`);

// Set the branch to our stage
set('branch', function () {
    return input()->getArgument('stage');
});

// Set the environment
set('environment', function () {
    return input()->getArgument('stage');

    return $env;
});

set('local/php', function () {
    return runLocally('which php');
});

set('remote/php', function () {
    return run('which php');
});

// Shared files/dirs between deploys
set('shared_dirs', ['storage']);

// Writable dirs by web server
set('writable_chmod_recursive', true);
set('writable_mode', 'chown');
set('http_user', 'www-data');
set('writable_use_sudo', true);
set('writable_dirs', ['storage']);

// Hosts
inventory('hosts.yml')->roles('app');

// Migrations
desc('Execute migrations');
task('artisan:migrate', function () {
    run('{{remote/php}} {{release_path}}/artisan migrate');
});

// Link storage
desc('Link storage');
task('storage:link', function () {
    run('{{remote/php}} {{release_path}}/artisan storage:link');
});

// Set path to composer binary
set('local/cp', function () {
    return runLocally('which cp');
});

// Copy the example environment file
desc('Copy the example env file');
task('copy:env', function () {
    runLocally("{{local/cp}} .env.{{environment}} .env");
})->local();

// Set path to composer binary
set('local/composer', function () {
    return runLocally('which composer');
});

// Install composer packages
desc('Installing composer packages');
task('composer:install', function () {
    runLocally('cd '.__DIR__.' && {{local/composer}} --ignore-platform-reqs {{composer_options}}');
})->local();

// Set path to npm binary
set('local/npm', function () {
    return runLocally('which npm');
});

// Install npm packages locally
desc('Install npm packages');
task('npm:install', function () {
    runLocally("cd ".__DIR__." && {{local/npm}} install  --verbose");
})->local();

// Run our build script locally
desc('Run npm build scripts');
task('npm:build', function () {
    runLocally("cd ".__DIR__." && {{local/npm}} run prod");
})->local();

// Some weird issues happen when the symbolic link is
// changed. I will find the root cause for this in the
// future. For now, this works.
desc('Restart PHP-FPM');
task('restart:php', function () {
    run('sudo systemctl restart php7.2-fpm.service');
});

// Deploy
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'composer:install',
    'copy:env',
    'npm:install',
    'npm:build',
    'deploy:lock',
    'deploy:release',
    'rsync:warmup',
    'rsync',
    'deploy:shared',
    'deploy:writable',
    // 'storage:link',
    // 'artisan:migrate',
    'deploy:symlink',
    'restart:php',
    'deploy:unlock',
    'cleanup',
])->desc('Deploy');

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
