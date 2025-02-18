<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class KotaModel extends Model
{
    use HasFactory;

    protected $table = 'tb_kota';
    protected $primarykey = 'id';

    protected $fillable = ['nama_kota'];

    public function getIdAttribute()
    {
        return strtoupper($this->attributes['id']);
    }

    public function siswa() {
        return $this->hasMany(SiswaModel::class);
    }
} 
