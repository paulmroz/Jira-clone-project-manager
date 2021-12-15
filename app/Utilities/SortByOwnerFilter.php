<?php

namespace App\Utilities;

class SortByOwnerFilter{

    public function filter($builder, $value){
        return $builder->where('user_id','=', $value);
    }
}
