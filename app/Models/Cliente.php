<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Cliente extends Model
{
    use HasFactory,SoftDeletes;//preenche deletet_at e nao delete registro //;

    public $timestamps = true; //--> update automarically by laravel <--//
    protected $table = 'cli_clientes';
    protected $primaryKey = 'cli_id';
    protected $appends = ['acao'];
    protected $fillable = [
        'cli_type', 'cli_name', 'cli_cpf_cnpj', 'cli_ativo', 'created_at', 'updated_at', 'deleted_at'
    ];
    protected $dates = ['deleted_at'];//campo obrigatório pra o SoftDeletes
    
    //protected $dateFormat = 'U';

    protected $casts = [//output
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected function getacaoAttribute(){ //--> qtde_escopos
        return 1; 
    }

    //boot events
    public static function boot()
    {
        parent::boot();

        self::creating(function($model){//before create
            $model->created_at = date("Y-m-d H:i:s.u");
            $model->updated_at = date("Y-m-d H:i:s.u");
        });
        
        self::updating(function($model){
            $model->updated_at = date("Y-m-d H:i:s.u");
        });
        /*
        self::created(function($model){
            // ... code here
        });
       

        self::updated(function($model){
            // ... code here
        });

        self::deleting(function($model){
            // ... code here
        });

        self::deleted(function($model){
            // ... code here
        });
        */
    }

}

