<?php

namespace Deployer;

require __DIR__.'/rsync.php';

task('upload:dirs', function() {
    $config = get('rsync');

    $dirs = get('upload_dirs');

    if (empty($dirs)) {
        throw new \RuntimeException('You need to specify some directories that need uploading.');
    }

    foreach ($dirs as $key => $src) {

        // Check if an array of rsync options have been passed
        if (is_array($src)) {
            $config = $src;
            $src = $key;
        }

        $dst = get('release_path').'/'.$src;

        $server = \Deployer\Task\Context::get()->getHost();
        if ($server instanceof \Deployer\Host\Localhost) {
            runLocally("rsync -{$config['flags']} {{rsync_options}}{{rsync_excludes}}{{rsync_includes}}{{rsync_filter}} '$src/' '$dst/'", $config);
            return;
        }
        $host = $server->getRealHostname();
        $port = $server->getPort() ? ' -p' . $server->getPort() : '';
        $sshArguments = $server->getSshArguments();
        $user = !$server->getUser() ? '' : $server->getUser() . '@';
        runLocally("rsync -{$config['flags']} -e 'ssh$port $sshArguments' {{rsync_options}}{{rsync_excludes}}{{rsync_includes}}{{rsync_filter}} '$src/' '$user$host:$dst/'", $config);

    }
});