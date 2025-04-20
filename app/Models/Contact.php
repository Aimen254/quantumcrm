<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Contact extends Model
{
    use HasRoles;
    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'specialty', 'gender', 'birth',
        'phone', 'email', 'country', 'city' ,'is_active'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
