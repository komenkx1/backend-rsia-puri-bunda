<?php

namespace App\Models;

use App\Traits\LoggableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory, LoggableTrait;

    protected $guarded = ['id'];
    protected $table = "jabatan";

    public function userJabatan()
    {
        return $this->hasMany(UserJabatan::class);
    }
}
