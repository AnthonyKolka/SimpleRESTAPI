<?php
$config = [
    'app_root' => __DIR__
];
$localConfig = json_decode(file_get_contents($config['app_root'] . "/config/config.ini"), true);
$config = array_merge($config, $localConfig);
//auth
if(!array_key_exists('k', $_GET) || $_GET['k'] != $config['api_key'])
{
    header(401);
    exit;
}
//register composer autoloader if it exists
if(is_dir ($config['app_root'] . '/vendor') && file_exists($config['app_root'] . '/vendor/autoload.php'))
{
    require $config['app_root'] . '/vendor/autoload.php';
}

require_once $config['app_root'] . "/lib/DB.class.php";
require_once $config['app_root'] . "/lib/ROUTER.class.php";
require_once $config['app_root'] . "/controllers/base_controller.php";
require_once $config['app_root'] . "/views/json.php";
include_once $config['app_root'] . "/routes/routes.php";
$config['db'] = new DB(
    $config['datasources']['default']['host'],
    $config['datasources']['default']['user'],
    $config['datasources']['default']['password'],
    $config['datasources']['default']['database'],
    $config['datasources']['default']['driver']
);
if($config['db']->error)
{
    header(500);
    echo "Connection Failure";
    exit;
}
$router = new ROUTER($routes, $config);
?>