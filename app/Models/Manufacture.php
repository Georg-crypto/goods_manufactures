<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
    use HasFactory;

    public function goods() {
        return $this->belongsToMany(Good::class);
    }

    protected $guarded = [];
}
