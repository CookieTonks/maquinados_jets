<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    use HasFactory;
<<<<<<< HEAD

    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }
    
    public function empresa()
    {
        return $this->belongsTo(Empresas::class);
    }
=======
>>>>>>> master
}
