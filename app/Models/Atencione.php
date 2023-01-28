<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atencione extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function cliente(){
        return $this->belongsTo(cliente::class);
    }

    public function medio(){
        return $this->belongsTo(Medio::class);
    }

    public function deposito(){
        return $this->hasOne(Deposito::class);
    }
}
