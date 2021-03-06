<?php

use Cart\App;
use Slim\Views\Twig;
use Illuminate\Database\Capsule\Manager as Capsule;

session_start();

require __DIR__.'/../vendor/autoload.php';

$app = new App;
$container = $app->getContainer();
$capsule = new Capsule;
$capsule->addConnection([
	'driver' => 'mysql',
	'host' => 'localhost',
	'database' =>  'cart',
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix' => ''
	]);

	$capsule->setAsGlobal();
	$capsule->bootEloquent();

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('c6fphq67y7hq3t57');
Braintree_Configuration::publicKey('swfb8b8z7bnptr38');
Braintree_Configuration::privateKey('0fbeb6c84f44b82bbcef738692b149f1');

require __DIR__.'/../app/routes.php';

$app->add(new \Cart\Middleware\ValidationErrorsMiddleware($container->get(Twig::class)));
$app->add(new \Cart\Middleware\OldInputMiddleware($container->get(Twig::class)));

?>