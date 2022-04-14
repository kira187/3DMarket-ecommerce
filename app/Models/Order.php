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
    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getDescriptionStatusAttribute()
    {
        switch ($this->status) {
            case 1:
                $status =  'Pendiente';
                break;
            case 2:
                $status =  'Recibido';
                break;
            case 3:
                $status =  'Enviado';
                break;
            case 4:
                $status =  'Entregado';
                break;
            case 5:
                $status =  'Anulado';
                break;
            default:
                break;
        }
        return $status;
    }
}
