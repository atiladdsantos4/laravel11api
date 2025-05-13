<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Escopo extends Model
{
    use SoftDeletes;//preenche deletet_at e nao delete registro //
    
    public $timestamps = false;
    protected $table = 'esc_escopo';
    protected $primaryKey = 'esc_id_esc';
    protected $dates = ['deleted_at'];//campo orbiogatorio pra o SoftDeletes
    protected $fillable = [
                           'esc_title',
                           'esc_posicao',
                           'created_at',
                           'updated_at',
                           'deleted_at'
                        ];
    use HasFactory;

    public static function getEscopos(){
        $itens = Escopo::select('esc_id_esc','esc_title')->orderBy('esc_title','asc')->get();
        return $itens; 
    }

    public static function getEscopo($id){
        $itens = Escopo::select('esc_id_esc','esc_title')
        ->where('esc_id_esc',$id)->get();
        return $itens; 
    }

    //boot events
    public static function boot()
    {
        parent::boot();

        self::creating(function($model){//before create
            $model->created_at = date("Y-m-d H:i:s.u");
            $model->updated_at = date("Y-m-d H:i:s.u");
        });
        /*
        self::created(function($model){
            // ... code here
        });

        self::updating(function($model){
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
