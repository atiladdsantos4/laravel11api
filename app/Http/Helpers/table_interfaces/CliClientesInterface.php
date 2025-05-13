<?php
namespace App\Http\Helpers\table_interfaces;
use Carbon\Carbon;

    class CliClientesInterface { 
        
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
                    array( 'db' => 'cli_id', 'dt' => 0 ),
                    array( 'db' => 'cli_type',  'dt' => 1 ),
                    array( 'db' => 'cli_name',   'dt' => 2 ),
                    array( 'db' => 'cli_cpf_cnpj',     'dt' => 3 ),
                    array( 'db' => 'cli_ativo',     'dt' => 4 ),
                    array(
                        'db'        => 'cli_date_creation',
                        'dt'        => 5,
                        'formatter' => function( $d, $row ) {
                            return Carbon::parse($d)->format('d/m/Y H:i:s');
                            //date( 'jS M y', strtotime($d));
                        }
                    ),
                    array(
                        'db'        => 'cli_date_update',
                        'dt'        => 6,
                        'formatter' => function( $d, $row ) {
                            return Carbon::parse($d)->format('d/m/Y H:i:s');
                            //return date( 'jS M y', strtotime($d));
                        }
                    ),
                    array(
                        'db'        => 'cli_id',
                        'dt'        => 7,
                        'formatter' => function( $d, $row ) {
                            return '<a href=""><i class="tol_escopo_edit grid-roxo fas fa-lg fa-pen-square text-gray-400 pt" aria-hidden="false"></i></a>';
                            //date( 'jS M y', strtotime($d));
                        }
                    ),
                    /*
                    echo'<td class="ct">'.Carbon::parse($item["cli_date_creation"])->format('d/m/Y H:i:s').'</td>';
                                            echo'<td class="ct">'.Carbon::parse($item["cli_date_update"])->format('d/m/Y H:i:s').'</td>';
                                            echo'<td class="td_ce tol_escopo_edit"><a href=""><i class="fas fa-pen-square text-gray-400 pt" aria-hidden="false"></i></a></td>';
                    */
                    // array(
                    //     'db'        => 'salary',
                    //     'dt'        => 5,
                    //     'formatter' => function( $d, $row ) {
                    //         return '$'.number_format($d);
                    //     }
                    // )
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
  