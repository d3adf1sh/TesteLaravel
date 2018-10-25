<?php

namespace App;

use Eloquent;

class Album extends Eloquent {
    public $timestamps = false;

    public function scopeYear($query, $year, $anotherYear)
    {
        return $query->whereIn('year', [$year, $anotherYear]);
    }
}