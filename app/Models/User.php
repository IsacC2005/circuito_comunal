<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relación con las comunidades
    public function communities(): BelongsToMany
    {
        return $this->belongsToMany(Community::class);
    }

    // Obligatorio para Filament: qué comunidades puede ver este usuario
    public function getTenants(Panel $panel): Collection
    {
        return $this->communities;
    }

    // Obligatorio: ¿tiene permiso para entrar a esta comunidad específica?
    public function canAccessTenant(Model $tenant): bool
    {
        return $this->communities->contains($tenant);
    }
}
