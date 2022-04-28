<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'deploy/recipe/rsync.php';

echo __DIR__;
set('rsync_src', __DIR__ . '/public');
set('rsync_dest', '{{release_path}}/public');

// Project name
set('application', 'Backend.Svobodnyi');

// Project repository
set('repository', 'git@gitlab.hexide-digital.com:InHouse/Svobodnyi/Backend.Svobodnyi.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);
set('allow_anonymous_stats', false);
set('keep_releases', 1);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', ['storage']);

//github token
set('github_oauth_token', '66ef4719f8d2c3894631d12cd9d71fab27300eae');
set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader');


set('rsync',[
    'exclude'      => [],
    'exclude-file' => false,
    'include' => [
//        'public/css',
//        '*/',
//        'js/**'
    ],
    'include-file' => false,
    'filter'       => [],
    'filter-file'  => false,
    'filter-perdir'=> false,
    'flags'        => 'rz', // Recursive, with compress
//    'options'      => ['delete'],
    'options'      => [],
    'timeout'      => 60,
]);


// Hosts

host('backend.svobodnyi.nwdev.net')
    ->stage('dev')
    ->set('branch', 'dev')
    ->set('deploy_path', '/home/backend-svobodnyi-dev/web/backend.svobodnyi.nwdev.net/public_html')
    ->set('bin/php', 'php74')
    ->set('bin/composer', '/usr/bin/php74 /usr/bin/composer')
    ->user('backend-svobodnyi-dev')
    ->port(22)
    ->identityFile('.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no');

task('build', function () {
    run('cd {{release_path}} && build');
});

after('deploy:failed', 'deploy:unlock');


before('deploy:symlink', 'artisan:migrate');

desc('Execute npm run dev');

task('npm:run:dev', function () {
  run('cd {{release_path}} && npm run dev');
});

task('config:clear', function () {
    if(getenv('CI_COMMIT_REF_NAME') == 'master')
    {
        run('cd {{release_path}} && php artisan config:clear');
    }
    else
    {
        run('cd {{release_path}} && php74 artisan config:clear');
    }

});

task('file_manager:publish', function (){
    run('cd {{release_path}} && /usr/bin/php74 artisan vendor:publish --tag=fm-assets --force');
});

after('artisan:migrate','config:clear');

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'rsync',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:cache:clear',
    'artisan:config:cache',
    'file_manager:publish',
//        'artisan:optimize',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);
