<?php

namespace App\Dto;

enum Direction: string{
    case UP = 'UP';
    case DOWN = 'DOWN';
}

class MoveDTO{
    public function __construct(public int $product_id, public Direction $where) {}
}