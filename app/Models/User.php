<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'age_group',
        'email',
        'country_code',
        'phone',
        'organization',
        'password',
        'role',
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
            'password' => 'hashed',
        ];

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        $name = $this->first_name;

        if ($this->middle_name) {
            $name .= ' ' . $this->middle_name;
        }

        $name .= ' ' . $this->last_name;

        return $name;
    }

    /**
     * Get the user's age group in a human-readable format.
     *
     * @return string
     */
    public function getFormattedAgeGroupAttribute(): string
    {
        return match ($this->age_group) {
            'below_20' => 'Below 20',
            '20_to_32' => '20 to 32',
            '32_to_45' => '32 to 45',
            '45_to_60' => '45 to 60',
            '60_to_70' => '60 to 70',
            'above_70' => 'Above 70',
            default => $this->age_group,
        };
    }

    /**
     * Get the user's full phone number with country code.
     */
    public function getFullPhoneAttribute(): string
    {
        return $this->country_code . $this->phone;
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the discourses the user is enrolled in.
     */
    public function enrolledDiscourses()
    {
        return $this->belongsToMany(Discourse::class, 'user_discourses')
            ->withPivot(['enrolled_at', 'expires_at', 'payment_id', 'payment_status', 'amount_paid'])
            ->withTimestamps();
    }

    /**
     * Check if the user is enrolled in a specific discourse.
     */
    public function isEnrolledIn(Discourse $discourse): bool
    {
        return $this->enrolledDiscourses()
            ->where('discourse_id', $discourse->id)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->exists();
    }

    /**
     * Check if the user has access to a specific video.
     */
    public function hasAccessToVideo(DiscourseVideo $video): bool
    {
        // Check if the user is enrolled in the discourse
        return $this->isEnrolledIn($video->discourse);
    }
}
