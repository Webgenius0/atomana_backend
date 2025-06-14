<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'email_verified_at',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
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
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * sccessor for avater attribute
     * @param mixed $url
     * @return string
     */
    public function getAvatarAttribute($url): string
    {
        if ($url) {
            if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
                return $url;
            } else {
                return asset('storage/' . $url);
            }
        } else {
            return asset('assets/img/user_placeholder.png');
        }
    }

    // _____________________________
    // _____________________________

    /**
     * Define the relationship between the current model and the Profile model.
     *
     * This method defines a "has one" relationship, where the current model
     * has one associated Profile. The foreign key for this relationship is
     * expected to be present in the Profile model's table (typically `user_id`).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Define the relationship between the current model and the Otp model.
     *
     * This method defines a "has many" relationship, where the current model
     * can have multiple associated OTP (One-Time Password) entries. The foreign key
     * for this relationship is expected to be present in the Otp model's table
     * (typically `user_id` or a relevant identifier).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function otps(): HasMany
    {
        return $this->hasMany(OTP::class);
    }


    /**
     * Getting the role of the user
     *
     * @return BelongsTo<Role, User>
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }


    /**
     * Businesses of the user
     * @return BelongsToMany<Business, User>
     */
    public function businesses(): BelongsToMany
    {
        return $this->belongsToMany(Business::class);
    }

    /**
     * retunring the business of the user;
     * @return mixed
     */
    public function business(): mixed
    {
        return $this->businesses->first();
    }

    /**
     * relstion with Proerty Model.
     * @return HasMany<Property, User>
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    /**
     * Model may have multipel SalesTrack
     * @return HasMany<SalesTrack, User>
     */
    public function SalesTrack(): HasMany
    {
        return $this->hasMany(SalesTrack::class);
    }

    /**
     * Model may have multiple vendor review
     * @return HasMany<VendorReview, User>
     */
    public function vendorReviews(): HasMany
    {
        return $this->hasMany(VendorReview::class);
    }

    /**
     * may have many targets
     * @return HasMany<Target, User>
     */
    public function targets(): HasMany
    {
        return $this->hasMany(Target::class);
    }


    /**
     * may have many expences
     * @return HasMany<Expense, User>
     */
    public function expences(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * has one ytd
     * @return HasOne<UserYTCView, User>
     */
    public function ytd(): HasOne
    {
        return $this->hasOne(UserYTCView::class);
    }

    /**
     * has one agentEarning
     * @return HasOne<AgentEarningView, User>
     */
    public function agentEarning(): HasOne
    {
        return $this->hasOne(AgentEarningView::class);
    }

    /**
     * getRouteKeyName
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'handle';
    }


    /**
     * openHouse
     * @return HasMany<OpenHouse, User>
     */
    public function openHouse(): HasMany
    {
        return $this->hasMany(OpenHouse::class);
    }

    /**
     * openHouseFeedback
     * @return HasMany<OpenHouseFeedback, User>
     */
    public function openHouseFeedback(): HasMany
    {
        return $this->hasMany(OpenHouseFeedback::class);
    }


    /**
     * contracts
     * @return HasMany<Contract, User>
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'agent');
    }

    /**
     * coContracts
     * @return HasMany<Contract, User>
     */
    public function coContracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'co_agent');
    }
}
