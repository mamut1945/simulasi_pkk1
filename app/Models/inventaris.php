<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $table = 'inventaris';

    protected $primaryKey = 'id_inventaris';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_inventaris',
        'nama_barang',
        'kondisi',
        'stok',
        'tanggal_register',
        'foto',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // generate ID unik
            $last = self::orderBy('id', 'desc')->first();
            $number = $last ? ((int)substr($last->id_inventaris, 3)) + 1 : 1;
            $model->id_inventaris = 'INV' . str_pad($number, 4, '0', STR_PAD_LEFT);
        });
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_inventaris', 'id_inventaris');
    }

}
