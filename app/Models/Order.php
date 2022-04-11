<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at', 'status'];

    const PENDIENTE = 1;
    const RECIBIDO = 2;
    const ENVIADO = 3;
    const ENTREGADO = 4;
    const ANULADO = 5;

    // Relationship invers 1:N
    public function department()
    {
        $this->belongsTo(Department::class);
    }

    // Relationship invers 1:N
    public function city()
    {
        $this->belongsTo(City::class);
    }

    // Relationship invers 1:N
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
