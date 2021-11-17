<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable {
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'email', 'phone','country', 'city', 'state','post_code','address','nid','tin','address_secondary',
        'password','reset_password_code', 'role', 'default_module_id','is_seller', 'status', 'remember_token', 'profile_photo_path','balance',
        'is_social_login','google_id','fb_id','social_image_link','date_of_birth','language','time_zone','admin_verified','nid_picture',
        'btc_balance'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'reset_password_code',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

    public function user_payment_options(){
        $this->hasOne(UserPaymentOption::class);
    }
    public function AauthAcessToken(){
        return $this->hasMany(OauthAccessToken::class);
    }
}
