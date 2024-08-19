<?php

namespace App\Dto;

class CreateProductsDTO{

    public function __construct(
        public string $title,
        public int $amount,
        public string $source,
        public float $welding,
        public float $assembly,
        public float $electro) {}
}