<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

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

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($user) {
            
            $email = Str::lower($user->email);

            if (Str::startsWith($email, 'admin')) {
                $user->role = 'admin';
            } 
    
            elseif (Str::startsWith($email, 'kasir')) {
                $user->role = 'kasir';
            } 

            else {
                $user->role = 'kasir';
            }
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->role === 'kasir' && $panel->getId() === 'admin') {
            redirect()->to('/kasir-dashboard')->send();
            exit();
        }

        return $this->role === 'admin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKasir(): bool
    {
        return $this->role === 'kasir';
    }
}