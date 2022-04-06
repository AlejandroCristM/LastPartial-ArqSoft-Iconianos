<?php

namespace App\Responses;

use App\Models\Customer;

class OrderResponse
{
    protected ?string $reference;
    protected ?string $description;
    protected ?float $amount;
    protected ?RestaurantResponse $restaurant;
    protected ?CustomerResponse $customer;

    public function __construct(
        ?string $reference = null,
        ?string $description = null,
        ?float $amount  = null,
        ?RestaurantResponse $restaurant = null,
        ?CustomerResponse $customer = null
    ) {
        $this->reference = $reference;
        $this->description = $description;
        $this->amount = $amount;
        $this->restaurant = $restaurant;
        $this->customer = $customer;
    }

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @return RestaurantResponse|null
     */
    public function getRestaurant(): ?RestaurantResponse
    {
        return $this->restaurant;
    }

    /**
     * @return CustomerResponse|null
     */
    public function getCustomer(): ?CustomerResponse
    {
        return $this->customer;
    }
}
