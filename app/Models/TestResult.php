<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nilai_keseluruhan', // UBAH INI
        'catatan_admin',
    ];

    /**
     * Get the user that owns the TestResult.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}