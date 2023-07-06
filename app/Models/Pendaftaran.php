<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftarans';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable= [
        'id_seminar',
        'id_user',
        'id_status',
        'image'
    ];

    public function seminars()
    {
        return $this->belongsTo(Seminar::class, 'id_seminar', 'id');
    }

    public function yuser()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function statuses()
    {
        return $this->belongsTo(Status::class, 'id_status', 'id');
    }
}
