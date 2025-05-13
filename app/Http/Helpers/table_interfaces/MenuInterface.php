<?php
namespace App\Http\Helpers\table_interfaces;
use \Carbon\Carbon;

    class MenuInterface { 
        
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
                    array( 'db' => 'men_id', 'dt' => 0 ),
                    array( 'db' => 'men_name',  'dt' => 1 ),
                    array( 'db' => 'menu_nome_pai',   'dt' => 2 ),
                    array( 'db' => 'menu_escopo',   'dt' => 3 ),
                    array(
                        'db'        => 'men_data_criacao',
                        'dt'        => 4,
                        'formatter' => function( $d, $row ) {
                            return Carbon::parse($d)->format('d/m/Y H:i:s');
                        }
                    ),
                    array(
                        'db'        => 'men_id',
                        'dt'        => 5,
                        'formatter' => function( $d, $row ) {
                            $url = route('menu.editar', $d);
                            $linha ='<a href="'.$url.'"><i data-toggle="tooltip" data-placement="top" title = "Editar Resgistro" class="tol_escopo_edit fas fa-lg fa-pen-square grid-roxo pt" aria-hidden="false"></i></a>';
                            $linha .='&nbsp <a href="#" data-id="'.$d.'" data-toggle="modal" data-target="#excluiModal"><i data-toggle="tooltip" data-placement="top" title = "Excluir Resgistro" class="tol_escopo_delete fas fa-lg fa-trash grid-red pt" aria-hidden="false"></i></a>';
                            return $linha;
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

        
        /*
        data-toggle="tooltip" data-placement="top" title = "Editar Resgistro" 
        $('.tol_escopo_edit').attr("data-toggle","tooltip"); 
        $('.tol_escopo_edit').attr("data-placement","top");
        $('.tol_escopo_edit').attr("title","Editar Resgistro");  
        // DB table to use
        $table = 'oauth_users';
        
        // Table's primary key
        $primaryKey = 'username';
        
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'username', 'dt' => 0 ),
            array( 'db' => 'password',  'dt' => 1 ),
            array( 'db' => 'first_name',   'dt' => 2 ),
            array( 'db' => 'last_name',     'dt' => 3 ),
            array(
                'db'        => 'created_at',
                'dt'        => 4,
                'formatter' => function( $d, $row ) {
                    return date( 'jS M y', strtotime($d));
                }
            ),
            // array(
            //     'db'        => 'salary',
            //     'dt'        => 5,
            //     'formatter' => function( $d, $row ) {
            //         return '$'.number_format($d);
            //     }
            // )
        );
        
        // SQL server connection information
        $sql_details = array(
            'user' => '',
            'pass' => '',
            'db'   => '',
            'host' => ''
            // ,'charset' => 'utf8' // Depending on your PHP and MySQL config, you may need this
        );
        */
    }    
  