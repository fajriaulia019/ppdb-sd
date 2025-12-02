<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Pendaftar; // Penting: Impor model Pendaftar
use App\Models\TestResult; // Penting: Impor model TestResult

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the pendaftar record associated with the user.
     * (Relasi satu-ke-satu: satu user punya satu data pendaftar)
     */
    public function pendaftar()
    {
        return $this->hasOne(Pendaftar::class);
    }

    /**
     * Get the test result associated with the user.
     * (Relasi satu-ke-satu: satu user punya satu hasil tes)
     */
    public function testResult()
    {
        return $this->hasOne(TestResult::class);
    }
}