<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;

    public function manufactures() {
        return $this->belongsToMany(Manufacture::class);
    }

    protected $guarded = [];
}
