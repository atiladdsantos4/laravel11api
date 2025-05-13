<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;//preenche deletet_at e nao delete registro //
    
    public $timestamps = true;
    protected $table = 'men_menu';
    protected $primaryKey = 'men_id';
    protected $dates = ['men_deleted_at'];//campo obrigatorio pra o SoftDeletes
    protected $appends = ['qtde_escopos'];//append ths attribute
    protected $fillable = [
                           'men_name', 
                           'men_pai', 
                           'men_filho', 
                           'men_filho_pai',
                           'men_id_esc',
                           'men_position', 
                           'men_filho_position',
                           'men_ativo',
                           'men_data_ref',
                           'men_data_folder',
                           'men_classe_js',
                           'men_is_href',
                           'men_route',
                           'men_ul_id',
                           'men_data_criacao',
                           'men_updated_at',
                           'men_deleted_at'
                        ];
    const CREATED_AT  = 'men_data_criacao';
    const UPDATED_AT  = 'men_updated_at';
    const DELETED_AT  = 'men_deleted_at';
    
    use HasFactory;

    private $numReg;

    protected function getqtdeEscoposAttribute(){ //--> qtde_escopos
       return $this->escopo()->count(); 
    }
 
    public function escopo()
    {
        return $this->hasOne(Escopo::class, 'esc_id_esc', 'men_id_esc');
    }

    public function escopoApi()
    {
        return $this->hasOne(Escopo::class, 'esc_id_esc', 'men_id_esc')->select('esc_title','esc_posicao');
    }

    public function menupai()
    {
        return $this->hasOne(Menu::class, 'men_id', 'men_filho_pai');
    }

    public function menupaiApi()
    {
        return $this->hasOne(Menu::class, 'men_id', 'men_filho_pai')->select('men_name');
    }

    //--> select * from appapi.men_menu where men_id_esc = 1 order by men_position
    public static function getMenuPai($escope){
        $itens = Menu::where('men_id_esc','=',$escope)
        ->where('men_pai','=',"1")
        ->where('men_ativo','=',"1")
        ->orderBy('men_position', 'asc')->get();
        return $itens; 
    }
   
    public function getMenuFilho($id){
       $itens = Menu::where('men_pai','=',0)
       ->where('men_filho_pai','=',$id)
       ->where('men_ativo','=',"1")
       ->orderBy('men_filho_position', 'asc')->get();
       return $itens; 
    } 

    public static function ListaMenus(){
        $itens = Menu::select("men_id","men_name")
        ->where('men_pai','=',1)
        ->where('men_ativo','=',1)
        ->orderBy('men_name', 'asc')->get();
        return $itens; 
    }
    
    //functions para paginação
    public function numRows(){
       return Menu::all()->count();  
    }


   //boot events
   public static function boot()
   {
       parent::boot();

       self::creating(function($model){//before create
           $model->men_data_criacao = date("Y-m-d H:i:s");
           $model->men_updated_at = date("Y-m-d H:i:s");
           $model->men_ul_id = $model->men_data_ref;
           if($model->men_filho_pai == -1){
              $model->men_filho_pai = null;
           }
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



