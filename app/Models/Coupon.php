<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
        'fecha_caducidad',
        'estado',       // 'activo' | 'inactivo'
        'descuento',    // decimal(8,2)
        'cantidad',     // stock o usos disponibles
        'referencia',
    ];

    // Casts recomendados
    protected $casts = [
        'fecha_caducidad' => 'date',
        'descuento'       => 'decimal:2',
        'cantidad'        => 'integer',
        'referencia'      => 'integer',
    ];
   

    public function userCoupons()
    {
        return $this->hasMany(UserCoupon::class, 'coupon_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_coupons')->withPivot('estado','cantidad')->withTimestamps();
    }

}