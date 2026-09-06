<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

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

    public function myRoles(): HasMany { return $this->hasMany(MyRole::class)->orderBy('sort_order'); }

    public function habits(): HasMany { return $this->hasMany(Habit::class); }
    public function wifeMessages(): HasMany { return $this->hasMany(WifeMessage::class); }
    public function daughterMessages(): HasMany { return $this->hasMany(DaughterMessage::class); }
    public function bookableSlots(): HasMany { return $this->hasMany(BookableSlot::class); }
    public function ventures(): HasMany { return $this->hasMany(Venture::class); }
    public function books(): HasMany { return $this->hasMany(Book::class); }
    public function articles(): HasMany { return $this->hasMany(Article::class); }
    public function courses(): HasMany { return $this->hasMany(Course::class); }
    public function songs(): HasMany { return $this->hasMany(Song::class); }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
