<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    protected $table = 'seminars';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'pendaftarans', 'id_seminar', 'id_user');
    }

    public function pendaftarans()
    {
        return $this->belongsTo(Pendaftaran::class, 'id', 'id_seminar');
    }
}
