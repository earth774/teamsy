<?php

namespace App\Models;

use App\Scopes\TenantScope;
use App\Traits\BelongsToTenant;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function($model) {
            if(session()->has('tenant_id')) {
                $model->tenant_id = session()->get('tenant_id');
            }
        });
    }

    public function avatarUrl()
    {
        if($this->photo) {
            return Storage::disk('s3-public')->url($this->photo);
        }
        return '';
    }

    public function isAdmin()
    {
        return $this->role == 'Admin';
    }

    public function isHR()
    {
        return $this->role == 'Human Resources';
    }

    public function applicationUrl()
    {
        if($this->application()) {
            return url('/documents/' . $this->id . '/' . $this->application()->filename);
        }
        return '#';
    }

    public function application()
    {
        return $this->documents()->where('type', 'application')->first();
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
