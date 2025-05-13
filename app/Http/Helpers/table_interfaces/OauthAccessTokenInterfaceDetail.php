<?php
   namespace App\Http\Helpers\table_interfaces;
   use Carbon\Carbon;

    class OauthAccessTokenInterfaceDetail { 
        
        private $table;
        private $primaryKey;
        private $columns; 

        public function __construct($array) {
            $this->table = $array["table"];
            $this->primaryKey = $array["primaryKey"];
        }

        public function colunas( $d, $row) {
                /*
                    <th>Client Id</th>
                    <th>User Id</th>
                    <th>Access Token</th>    
                    <th>Expira em</th>
                    <th>Scope</th>
                    <th>Criação</th>
                    <th>Atualização</th>
                    <th class="td_ce">Ação</th>
                */
                // Array of database columns which should be read and sent back to DataTables.
                // The `db` parameter represents the column name in the database, while the `dt`
                // parameter represents the DataTables column identifier. In this case simple
                // indexes
                $this->columns = array(
                    //array( 'db' => 'client_id', 'dt' => 'client_id' ),
                    array( 'db' => 'client_id', 
                           'dt' => 'DT_RowId',
                           'formatter' => function( $d, $row ) {
                                // Technically a DOM id cannot start with an integer, so we prefix
                                // a string. This can also be useful if you have multiple tables
                                // to ensure that the id is unique with a different prefix
                                return 'row_'.$d;
                            } 

                    ),
                    array( 'db' => 'client_id', 'dt' => 'client_id' ),
                    array( 'db' => 'user_id',   'dt' => 'user_id' ),
                    array( 'db' => 'access_token', 'dt' => 'access_token' ),
                    array(
                        'db'        => 'expires',
                        'dt'        => 'expires',
                        'formatter' => function( $d, $row ) {
                            return Carbon::parse($d)->format('d/m/Y H:i:s');
                            //return date( 'd/m/Y H:i:s', strtotime($d));
                        }
                    ),
                    array( 'db' => 'scope',  'dt' => 'scope' ),
                    array(
                        'db'        => 'client_id',
                        'dt'        => 'acao',
                        'formatter' => function( $d, $row ) {
                              $url ='index.php/clientapp/editar/'.$d;
                              $td  = '<a href="'.base_url($url).'"><i class=" tol_escopo_edit grid-roxo fas fa-lg fa-pen-square text-gray-400 pt" aria-hidden="false"></i></a>';
                              $td .='&nbsp;<a href="'.base_url($url).'"><i class=" tol_escopo_key grid-blue fas fa-lg fa-key text-gray-400 pt" aria-hidden="false"></i></a></td>';
                            return $td;
                        }
                    )
                );
            return $this->columns;    
        }

        public function getTable(){
           return $this->table;  
        }

        public function getPrimary(){
           return $this->primaryKey;  
        }
        
    }    
  