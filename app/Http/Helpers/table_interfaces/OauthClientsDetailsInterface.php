<?php
   namespace App\Http\Helpers\table_interfaces;
   use Carbon\Carbon;
   //C:\Apache24\htdocs\projetos\crud_teste\app\Views\sb\table_interfaces\OauthClientsDetailsInterface.php
    class OauthClientsDetailsInterface { 
        
        private $table;
        private $primaryKey;
        private $columns; 

        public function __construct($array) {
            $this->table = $array["table"];
            $this->primaryKey = $array["primaryKey"];
        }

        public function colunas( $d, $row) {
                // Array of database columns which should be read and sent back to DataTables.
                // The `db` parameter represents the column name in the database, while the `dt`
                // parameter represents the DataTables column identifier. In this case simple
                // indexes
                $this->columns = array(
                    array( 'db' => 'client_id', 'dt' => 0 ),
                    array( 'db' => 'client_secret', 'dt' => 1 ),
                    array( 'db' => 'redirect_uri', 'dt' => 2 ),
                    array( 'db' => 'grant_types',  'dt' => 3 ),
                    array( 'db' => 'scope',  'dt' => 4 ),
                    array( 'db' => 'user_id',  'dt' => 5 ),
                    array(
                        'db'        => 'created_at',
                        'dt'        => 6,
                        'formatter' => function( $d, $row ) {
                            return Carbon::parse($d)->format('d/m/Y H:i:s');
                            //return date( 'd/m/Y H:i:s', strtotime($d));
                        }
                    ),
                    array(
                        'db'        => 'updated_at',
                        'dt'        => 7,
                        'formatter' => function( $d, $row ) {
                            return Carbon::parse($d)->format('d/m/Y H:i:s');
                            //return date( 'd/m/Y H:i:s', strtotime($d));
                        }
                    ),
                    array(
                        'db'        => 'client_id',
                        'dt'        => 8,
                        'formatter' => function( $d, $row ) {
                            $url ='index.php/clientapp/editar/'.$d;
                            $td = '<a href="'.base_url($url).'"><i class="tol_escopo_edit grid-roxo fas fa-lg fa-pen-square text-gray-400 pt" aria-hidden="false"></i></a>';
                            $url ='index.php/clientapp/token/'.$d;
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
  