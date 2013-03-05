<?php
/**
 * EvaThumber
 * light-weight url based image transformation php library
 *
 * @link      https://github.com/AlloVince/EvaThumber
 * @copyright Copyright (c) 2013 AlloVince (http://avnpc.com/)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    AlloVince
 */

error_reporting(E_ALL);

// Check php version
if( version_compare(phpversion(), '5.3.0', '<') ) {
    printf('PHP 5.3.0 is required, you have %s', phpversion());
    exit(1);
}

$dir = __DIR__ . '/../../../vendor/EvaThumber';
$autoloader = $dir . '/vendor/autoload.php';
$localConfig = __DIR__ . '/../../../config/local.front.image.config.php';

if (file_exists($autoloader)) {
    $loader = include $autoloader;
} else {
    die('Dependent library not found, run "composer install" first.');
}

/** Debug functions */
function p($r, $usePr = false)
{
    echo '<pre>' . var_dump($r); 
}

$loader->add('EvaThumber', $dir . '/src');

$config = new EvaThumber\Config\Config(include $dir . '/config.default.php');
if(file_exists($localConfig)){
    $localConfig = new EvaThumber\Config\Config(include $localConfig);
    $config = $config->merge($localConfig);
}

$thumber = new EvaThumber\Thumber($config);

try {
    $thumber->show();
} catch(Exception $e){
    throw $e;
    //header('location:' . $config->error_url . '?msg=' . urlencode($e->getMessage()));
}

