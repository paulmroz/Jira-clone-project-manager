<?php

namespace App\Utilities;

class SortByStatusFilter {
    public function filter($builder, $value){
        return $builder->where('status_id','=', $value);
    }
}
