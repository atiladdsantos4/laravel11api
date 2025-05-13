<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
  
class Product extends Model
{
    use HasFactory,SoftDeletes;//preenche deletet_at e nao delete registro //;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = true; //--> update automarically by laravel <--//
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $appends = ['acao'];
    protected $fillable = [
        'name', 'detail','price','imagem','created_at','updated_at','deleted_at'
    ];
    protected $dates = ['deleted_at'];//campo obrigatório pra o SoftDeletes
    
    //protected $dateFormat = 'U';

    protected $casts = [
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
            $valor = str_replace(",", "", $model->price);
            $model->price = $valor;
            
        });
        
        self::updating(function($model){
            $model->updated_at = date("Y-m-d H:i:s.u");
            $valor = str_replace(",", "", $model->price);
            $model->price = $valor;
        });
        
        self::created(function($model){
            $model->imagem = $model->id.'/'.$model->imagem; 
        });

        
        /*
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