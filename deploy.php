<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/npm.php';

// HARUS DIGANTI SESUAI KEBUTUHAN ANDA
set('application', 'Sawitone'); // Nama aplikasi Anda
set('repository', 'https://github.com/Crysna-Wima/sawitone.git'); // URL SSH untuk clone Git
set('bin/php', '/usr/bin/php8.3'); // Sesuaikan path PHP di server Anda
// HARUS DIGANTI SESUAI KEBUTUHAN ANDA

set('keep_releases', 5);
add('shared_files', ['.env']);
add('shared_dirs', ['storage']);
add('writable_dirs', ['bootstrap/cache', 'storage']);

// ----- Hosts -----
// HARUS DIGANTI SESUAI KEBUTUHAN ANDA
host('production') // Nama alias untuk server Anda (cth: production)
    ->setHostname('109.110.188.195') // Hostname atau IP server
    ->set('remote_user', 'id_rsa') // User SSH di server
    ->set('port', 22) // Port SSH (default: 22)
    ->set('branch', 'main') // Branch Git yang akan di-deploy
    ->set('deploy_path', '~/public_html/sawitone'); // Path deploy di server
// HARUS DIGANTI SESUAI KEBUTUHAN ANDA

// ----- Tasks -----
task('deploy:secrets', function () {
    file_put_contents(__DIR__ . '/.env', getenv('DOT_ENV'));
    upload('.env', get('deploy_path') . '/shared');
});

task('deploy', [
    'deploy:prepare',
    'deploy:secrets',
    'deploy:vendors',
    'deploy:shared',
    'artisan:storage:link',
    'deploy:publish',
]);

after('deploy:failed', 'deploy:unlock');
// before('deploy:symlink', 'artisan:migrate');