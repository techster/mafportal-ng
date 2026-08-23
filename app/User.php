<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use CrudTrait;
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fakeColumns = ['payment_data'];
    protected $fillable = [
        'name',
        'last_name',
        'nickname',
        'email',
        'date',
        'balance',
        'payment_data',
        'email_token',
        'verified',
        'password',
        'remember_token',
        'avatar',
        'google_id',
        'instagram_id'
    ];
//    protected $hidden = [];
    protected $casts = [
        'payment_data' => 'array',
    ];

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
    public function clubs()
    {
        return $this->belongsToMany('App\Models\Club')->withPivot('confirm', 'active', 'admin');
    }

    public function clubs_admin()
    {
        return $this->belongsToMany('App\Models\Club')
            ->withPivot('confirm', 'active', 'admin')
            ->wherePivot('admin', 1);
    }

    public function verified()
    {
        $this->verified = 1;
        // $this->email_token = null;
        $this->save();
    }
}
