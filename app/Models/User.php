<?php

/**
 * Created by EduInLive.
 */

namespace App\Models;

use Carbon\Carbon;
use App\Models\Scopes\ModelScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    use ModelScopes;

    protected $table = 'users';

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'role_id',
        'nid',
        'name',
        'company_name',
        'contact_number',
        'address',
        'username',
        'email',
        'password',
        'is_superadmin',
    ];
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];
    public function validate($input)
    {
        $validate = Validator::make($input, [
            'nid' => 'required',
            'name' => 'required',
            'company_name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        return $validate;
    }

    public function roles()
    {
        return $this->belongsTo(Role::class,'role_id','id');
    }


}
