<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Contracts\Entities\UserEntityInterface;
use App\Traits\HasUUIDID;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $id
 * @property string $name
 * @property string|null $email
 * @property string $phone
 * @property CarbonInterface|null $email_verified_at
 * @property string $password
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class User extends Authenticatable implements UserEntityInterface
{
    use HasFactory, Notifiable, HasApiTokens;
    use HasUUIDID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    protected ?string $token = null;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): UserEntityInterface
    {
        return $this->fill(['name' => $name]);
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): UserEntityInterface
    {
        return $this->fill(['phone' => $phone]);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): UserEntityInterface
    {
        return $this->fill(['email' => $email]);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): UserEntityInterface
    {
        return $this->fill(['password' => $password]);
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): UserEntityInterface
    {
        $this->token = $token;

        return $this;
    }

    public function getCreatedAt(): ?CarbonInterface
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?CarbonInterface
    {
        return $this->updated_at;
    }
}
