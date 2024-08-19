<?php

namespace App\Dto;

class AddComponentToProductDTO{
    public function __construct(public int $productId, public int $componentId) {}
}