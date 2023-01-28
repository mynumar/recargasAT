<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function atencione(){
        return $this->belongsTo(Atencione::class);
    }

    public function banco(){
        return $this->belongsTo(Banco::class);
    }
}
