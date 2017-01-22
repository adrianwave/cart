<?php

use function DI\get;
use Slim\Views\Twig;
use Cart\Basket\Basket;
use Cart\Models\Product;
use Slim\Views\TwigExtension;
use Interop\Container\ContainerInterface;
use Cart\Support\Storage\SessionStorage;
use Cart\Support\Storage\Contracts\StorageInterface;
use Cart\Validation\Contracts\ValidatorInterface;
use Cart\Validation\Validator;
use Cart\Models\Order;
use Cart\Models\Customer;
use Cart\Models\Address;
use Cart\Models\Payment;

return [
	'router'=>DI\object(Slim\Router::class),
	ValidatorInterface::class => function(ContainerInterface $c) {
		return new Validator;
	},
	StorageInterface::class=> function (ContainerInterface $c) {
		return new SessionStorage('cart');
	},
	Twig::class => function (ContainerInterface $c) {
		$twig = new Twig(__DIR__.'/../resources/views', [
			'cache' => false
			]);

	$twig ->addExtension(new TwigExtension(
	$c->get('router'),
	$c->get('request')->getUri()
	));			
	
	$twig->getEnvironment()->addGlobal('basket', $c->get(Basket::class));
	
	return $twig;
	},
	Product::class => function(ContainerInterface $c) {
		return new Product;
	},
	
	Order::class => function (ContainerInterface $c) {
		return New Order;
	},
	
	Customer::class => function (ContainerInterface $c) {
		return New Customer;
	},
	
	Address::class => function (ContainerInterface $c) {
		return New Address;
	},

	Payment::class => function (ContainerInterface $c) {
		return New Payment;
	},
	
	Basket::class => function (ContainerInterface $c) {
		return new Basket(
		$c->get(SessionStorage::class),
		$c->get(Product::class)
		);
	}
];