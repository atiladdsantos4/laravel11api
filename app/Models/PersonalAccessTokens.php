<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalAccessTokens extends Model
{
    use SoftDeletes;//preenche deletet_at e nao delete registro //
    
    public $timestamps = false;
    protected $table = 'personal_access_tokens';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];//campo orbiogatorio pra o SoftDeletes
    protected $fillable = [
                           'tokenable_type',
                           'tokenable_id',
                           'name',
                           'abilities',
                           'last_used_at',
                           'abilities',
                           'expires_at',
                           'created_at',
                           'updated_at',
                        ];
    use HasFactory;


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'tokenable_id');
    }

    public function userApi()
    {
        return $this->hasOne(User::class, 'id', 'tokenable_id')->select('name','email');
    }

}
