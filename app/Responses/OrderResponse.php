<?php

namespace App\Responses;

use App\Models\Customer;
use App\Models\Restaurant;

class OrderResponse
{
    protected string $reference;
    protected string $description;
    protected float $amount;
    protected Restaurant $restaurant;
    protected Customer $customer;

    public function __construct(string $reference, string $description, float $amount, Restaurant $restaurant, Customer $customer)
    {
        $this->reference = $reference;
        $this->description = $description;
        $this->amount = $amount;
        $this->restaurant = $restaurant;
        $this->customer = $customer;
    }
}
