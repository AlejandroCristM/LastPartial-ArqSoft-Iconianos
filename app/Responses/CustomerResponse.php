<?php

namespace App\Responses;

use App\Models\Customer;
use App\Models\Restaurant;

class CustomerResponse
{
    protected ?string $name;
    protected ?string $lastname;
    protected ?string $address;
    protected ?string $phone;

    public function __construct(?string $name, ?string $lastname, ?string $address, ?string $phone)
    {
        $this->name = $name;
        $this->lastname = $lastname;
        $this->address = $address;
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }
}
