<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'provider',
        'provider_id',
        'profile_picture',
        'last_login_at',
        'last_login_ip',
        'login_count',
        'role',
        'remember_token',
        'email_verified_at',
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
            'last_login_at' => 'datetime',
        ];
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'user_organization')->withPivot('organization_role');
    }

    /**
     * Get the currently selected organization for the user.
     */
    public function getCurrentOrganizationAttribute()
    {
        if (session()->has('selected_organization_id')) {
            return $this->organizations()->where('id', session('selected_organization_id'))->first();
        }

        // If no organization is selected in the session, and the user has only one organization, return that one.
        if ($this->organizations->count() === 1) {
            return $this->organizations->first();
        }

        return null;
    }
    
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($key === 'organization') {
            return $this->current_organization;
        }

        return parent::__get($key);
    }
}
