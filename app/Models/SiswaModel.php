<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;


class SiswaModel extends Model
{
    use HasFactory;

    protected $table = 'tb_siswa';
    protected $primarykey = 'id';

    protected $fillable = ['nisn', 'nama', 'tgl_lahir','jenis_kelamin','alamat','id_kota'];

    public function getIdAttribute()
    {
        return strtoupper($this->attributes['id']);
    }

    public function kota() {
        return $this->belongsTo(KotaModel::class, 'id_kota', 'id');
    }
}
