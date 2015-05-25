<?php
include_once 'core/ftp/autoload.php';

use LibreMVC\Ftp\Config\Config;
use LibreMVC\Ftp;

$config = [
    'host'      => '',
    'port'      => 21,
    'timeout'   => 90,
    'passive'   => true,
    'usr'       => '',
    'pwd'       => ''
];

try {

    $configObj = new Config(
        $config['host'],
        $config['port'],
        $config['timeout']
    );

    $ftp = new Ftp();
    $valid = $ftp->addServer($configObj, $config['usr'], $config['pwd']);
    if($valid) {
        $server1 = $ftp->getServer('ftp.inwebo.net');
        $server1->cd('/www/temp/');
        $server1->setPassive(true);
        $server1->put('/home/inwebo/index.html');
        echo $server1->cwd();
        $files = $server1->ls();
        var_dump($files);

        /* @var Ftp\File $file */
        $file = $files[0];

        echo $file->getAbsolutePath();
        echo( $file->getSize() );
        var_dump($file->getContent());
        var_dump($file->isFile());
        var_dump($file->isDir());
        $file->save('test.html');
        echo $file->delete();
    }

}
catch (Exception $e) {
    var_dump($e);
}