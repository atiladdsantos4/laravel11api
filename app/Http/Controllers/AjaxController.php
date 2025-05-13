<?php

namespace App\Http\Controllers;

use App\Http\Helpers\SSP_Postgress;
//use App\Libraries\ApiRequest;
use  App\Http\Helpers\table_interfaces\OauthUsersInterface;
use  App\Http\Helpers\table_interfaces\OauthClientsInterface;
use  App\Http\Helpers\table_interfaces\OauthAccessTokenInterface;
use  App\Http\Helpers\table_interfaces\OauthClientsDetailsInterface;
use  App\Http\Helpers\table_interfaces\CliClientesDetaisInterface;
use  App\Http\Helpers\table_interfaces\OauthAccessTokenInterfaceDetail;
use  App\Http\Helpers\table_interfaces\EscopoInterface;
use  App\Http\Helpers\table_interfaces\MenuInterface;
use  App\Http\Helpers\table_interfaces\UsuarioInterface;
use  App\Http\Helpers\table_interfaces\PersonalAccessTokensInterface;

class AjaxController extends Controller
{
    public function index($interface, $campo = null,$id = null)
    {
        $ssp = new SSP_Postgress(); //instanciando de forma geral
        switch($interface){

            case "index_clidetail":
                 $array = [
                    "table" => "cli_clientes",
                    "primaryKey" => "cli_id"         
                ]; 
 
                $table = new CliClientesDetaisInterface($array);
                 $columns =  $table->colunas($d =null,$row = null); 
                $sql_details =  null;
                echo json_encode(
                    $ssp->simple( $_GET, $sql_details, $table->getTable(), $table->getPrimary(), $columns ),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                );
            break;
            
            case "index_back":
                $array = [
                    "table" => "oauth_users",
                    "primaryKey" => "username"         
                ]; 
                
                $table = new OauthUsersInterface($array);
                $columns =  $table->colunas($d =null,$row = null);
                $sql_details =  null;
                //$ssp = new SSP(); 
            
                echo json_encode(
                    $ssp->simple( $_GET, $sql_details, $table->getTable(), $table->getPrimary(), $columns ),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                );
            break;
            
            case "indexAjax":
                $array = [
                    "table" => "oauth_clients",
                    "primaryKey" => "client_id"         
                ]; 
                $table = new OauthClientsInterface($array);
                $columns =  $table->colunas($d =null,$row = null); 
                $sql_details =  null;
                //$ssp = new SSP(); 
               
                echo json_encode(
                    $ssp->simple( $_GET, $sql_details, $table->getTable(), $table->getPrimary(), $columns ),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                );   
            break;   

            case "tokens":
                $array = [
                    "table" => "oauth_access_tokens",
                    "primaryKey" => "access_token"         
                ]; 
                $table = new OauthAccessTokenInterface($array);
                $columns =  $table->colunas($d =null,$row = null); 
                $sql_details =  null;
                //$ssp = new SSP(); 
            
                echo json_encode(
                    $ssp->simple( $_GET, $sql_details, $table->getTable(), $table->getPrimary(), $columns ),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                ); 
            break;

            case "tokens_details":
                $array = [
                    "table" => "oauth_access_tokens",
                    "primaryKey" => "access_token"         
                ]; 
                $table = new OauthAccessTokenInterfaceDetail($array);
                $columns =  $table->colunas($d =null,$row = null); 
                $sql_details =  null;
                //$ssp = new SSP(); 
            
                echo json_encode(
                    $ssp->simple( $_GET, $sql_details, $table->getTable(), $table->getPrimary(), $columns ),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                ); 
            break;

            case "Escopo":
                $array = [
                    "table" => "laravelapi.esc_escopo",
                    "primaryKey" => "esc_id_esc"         
                ]; 
                $table = new EscopoInterface($array);
                $columns =  $table->colunas($d =null,$row = null); 
                $sql_details =  null;
                //$ssp = new SSP(); 
                $field_delete = 'deleted_at';
                $ssp->setDeleted($field_delete);
               
                echo json_encode(
                    $ssp->simple( $_GET, $sql_details, $table->getTable(), $table->getPrimary(), $columns ),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                );   
            break;

            case "Menu":
                $array = [
                    "table" => "laravelapi.v_menus",
                    "primaryKey" => "men_id"         
                ]; 
                $table = new MenuInterface($array);
                $columns =  $table->colunas($d =null,$row = null); 
                $sql_details =  null;
                //$ssp = new SSP();
                $field_delete = 'men_deleted_at';
                $ssp->setDeleted($field_delete);
                //men_deleted_at
                              
                echo json_encode(
                    $ssp->simple( $_GET, $sql_details, $table->getTable(), $table->getPrimary(), $columns ),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                );   
            break;

            case "Usuario":
                $array = [
                    "table" => "users",
                    "primaryKey" => "id"         
                ]; 
                $table = new UsuarioInterface($array);
                $columns =  $table->colunas($d =null,$row = null); 
                $sql_details =  null;
                //$ssp = new SSP();
                // $field_delete = 'men_deleted_at';
                // $ssp->setDeleted($field_delete);
                //men_deleted_at
                              
                echo json_encode(
                    $ssp->simple( $_GET, $sql_details, $table->getTable(), $table->getPrimary(), $columns ),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                );   
            break;

            case "PersonalToken":
                $array = [
                    "table" => "laravelapi.personal_access_tokens",
                    "primaryKey" => "id"         
                ]; 
                $table = new PersonalAccessTokensInterface($array);
                $columns =  $table->colunas($d =null,$row = null); 
                $sql_details =  null;
                //$ssp = new SSP();
                if( $id != null ){
                   $ssp->setWhereFilter($campo,$id);
                }
                // $field_delete = 'men_deleted_at';
                // $ssp->setDeleted($field_delete);
                //men_deleted_at
                              
                echo json_encode(
                    $ssp->simple( $_GET, $sql_details, $table->getTable(), $table->getPrimary(), $columns ),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                );   

            break;    

        }    
    }
}

