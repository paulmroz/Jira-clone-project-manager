<?php

namespace App\Utilities;

class SortByDateFilter
{
    public function filter($builder, $value){
        return $builder->orderBy('created_at',"$value");
    }
}
