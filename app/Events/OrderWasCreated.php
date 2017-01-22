<?php

namespace Cart\Events;

use Cart\Models\Order;
use Cart\Models\Basket;

class OrderWasCreated extends Event
{
	public $order;

	public $basket;
	
	public function __construct (Order $order, $basket)
	{
		$this->order = $order;
		$this->basket= $basket;
	}
}