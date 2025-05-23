<?php
namespace App\Http\Helpers;
//C:\Apache24\htdocs\projetos\laravel11\app\Http\Helpers\SSP.php
/*
 * Helper functions for building a DataTables server-side processing SQL query
 *
 * The public functions in this class are just helper functions to help build
 * the SQL used in the DataTables demo server-side processing scripts. These
 * functions obviously do not represent all that can be done with server-side
 * processing, they are intentionally simple to show how it works. More complex
 * server-side processing operations will likely require a custom script.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */


// Please Remove below 4 lines as this is use in Datatatables test environment for your local or live environment please remove it or else it will not work
// $file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
// if ( is_file( $file ) ) {
// 	include( $file );
// }


class SSP_Postgress {

	private $db;
	private $conn;
	private $tipo_banco;
	private $deleted_at = null;
	private $where_filter = null;
	private $where_id_filter = null;
/*
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_SCHEMA=laravelapi
DB_PASSWORD=@eatila5@
*/
	public function __construct() {
		//--> Variável customizada em app.php <--//
		$this->tipo_banco = 'postgres';
		$DB_USER   = config('app.pdo_values.db_user'); 
		//'postgres';
		$DB_PASS   = config('app.pdo_values.db_pass'); 
		$DB_HOST   = config('app.pdo_values.db_host');
		$DB_CONN   = config('app.pdo_values.db_con');
		$DB_NAME   = config('app.pdo_values.db_name');
        $DB_SCHEMA = config('app.pdo_values.db_schema');

		//'@eatila5@';
		//config('DB_PASSWORD');
		//'@eatila5@';
		//$DB_SCHEMA = config('DB_SCHEMA');
		//$DB_HOST = config('DB_HOST');
		$DSN = "$DB_CONN:host=$DB_HOST;dbname=$DB_NAME";
		//$DSN = "pgsql:host=localhost;dbname=postgres";
		//env('DB_HOST');
		//'mysql:dbname=crud_teste;host=localhost';
		try {
			$this->db = @new \PDO(
				$DSN,
				$DB_USER,
				$DB_PASS,
				array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
			);
			$this->db->exec("SET search_path TO $DB_SCHEMA");

		}
		catch (\PDOException $e) {
			$this->fatal(
				"An error occurred while connecting to the database. ".
				"The error reported by the server was: ".$e->getMessage()
			);
		}
		//return $this->db; 
	}

	public function setDeleted( $field = null){
	   $this->deleted_at = $field;	
	}

	public function setWhereFilter( $field = null,$id = null){
		$this->where_filter = $field;	
		$this->where_id_filter = $id;
    }
	/**
	 * Create the data output array for the DataTables rows
	 *
	 *  @param  array $columns Column information array
	 *  @param  array $data    Data from the SQL get
	 *  @return array          Formatted data in a row based format
	 */
	public function data_output ( $columns, $data )
	{
		$out = array();

		for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
			$row = array();

			for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
				$column = $columns[$j];

				// Is there a formatter?
				if ( isset( $column['formatter'] ) ) {
                    if(empty($column['db'])){
                        $row[ $column['dt'] ] = $column['formatter']( $data[$i] );
                    }
                    else{
                        $row[ $column['dt'] ] = $column['formatter']( $data[$i][ $column['db'] ], $data[$i] );
                    }
				}
				else {
                    if(!empty($column['db'])){
                        $row[ $column['dt'] ] = $data[$i][ $columns[$j]['db'] ];
                    }
                    else{
                        $row[ $column['dt'] ] = "";
                    }
				}
			}

			$out[] = $row;
		}

		return $out;
	}


	/**
	 * Database connection
	 *
	 * Obtain an PHP \PDO connection from a connection details array
	 *
	 *  @param  array $conn SQL connection details. The array should have
	 *    the following properties
	 *     * host - host name
	 *     * db   - database name
	 *     * user - user name
	 *     * pass - user password
	 *  @return resource \PDO connection
	 */
	public function db ( $conn )
	{
		if ( is_array( $conn ) ) {
			return $this->sql_connect( $conn );
		}

		return $conn;
	}


	/**
	 * Paging
	 *
	 * Construct the LIMIT clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL limit clause
	 */
	public function limit ( $request, $columns )
	{
		$limit = '';

		if ( isset($request['start']) && $request['length'] != -1 ) {
			if( $this->tipo_banco == 'postgres' ){
				$limit = "LIMIT ".intval($request['length'])." OFFSET ".intval($request['start']);
			} else {//Mysql//
				$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
			}	
			
		}

		return $limit;
	}


	/**
	 * Ordering
	 *
	 * Construct the ORDER BY clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL order by clause
	 */
	public function order ( $request, $columns )
	{
		$order = '';

		if ( isset($request['order']) && count($request['order']) ) {
			$orderBy = array();
			$dtColumns = $this->pluck( $columns, 'dt' );

			for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
				// Convert the column index into the column data property
				$columnIdx = intval($request['order'][$i]['column']);
				$requestColumn = $request['columns'][$columnIdx];

				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['orderable'] == 'true' ) {
					$dir = $request['order'][$i]['dir'] === 'asc' ?
						'ASC' :
						'DESC';
					//if( $this->tipo_banco == 'postgres' ){
					    $orderBy[] = $column['db'].' '.$dir;
					//} else {
					//	$orderBy[] = ''.$column['db'].' '.$dir;
					//}	
				}
			}

			if ( count( $orderBy ) ) {
				$order = 'ORDER BY '.implode(', ', $orderBy);
			}
		}

		return $order;
	}


	/**
	 * Searching / Filtering
	 *
	 * Construct the WHERE clause for server-side processing SQL query.
	 *
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here performance on large
	 * databases would be very poor
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @param  array $bindings Array of values for \PDO bindings, used in the
	 *    sql_exec() function
	 *  @return string SQL where clause
	 */
	public function filter ( $request, $columns, &$bindings )
	{
		$globalSearch = array();
		$columnSearch = array();
		$dtColumns = $this->pluck( $columns, 'dt' );

		if ( isset($request['search']) && $request['search']['value'] != '' ) {
			$str = $request['search']['value'];

			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['searchable'] == 'true' ) {
					if(!empty($column['db'])){
						$binding = $this->bind( $bindings, '%'.$str.'%', \PDO::PARAM_STR );
						$globalSearch[] = 'CAST ('.$column['db']." AS VARCHAR) LIKE ".$binding;
					}
				}
			}
		}

		// Individual column filtering
		if ( isset( $request['columns'] ) ) {
			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				$str = $requestColumn['search']['value'];

				if ( $requestColumn['searchable'] == 'true' &&
				 $str != '' ) {
					if(!empty($column['db'])){
						$binding = $this->bind( $bindings, '%'.$str.'%', \PDO::PARAM_STR );
						$columnSearch[] = 'CAST ('.$column['db']." AS VARCHAR) LIKE ".$binding;
					}
				}
			}
		}

		// Combine the filters into a single string
		$where = '';

		if ( count( $globalSearch ) ) {
			$where = '('.implode(' OR ', $globalSearch).')';
		}

		if ( count( $columnSearch ) ) {
			$where = $where === '' ?
				implode(' AND ', $columnSearch) :
				$where .' AND '. implode(' AND ', $columnSearch);
		}

		if ( $where !== '' ) {
			$where = 'WHERE '.$where;

			//filtro do deleted field
			if( $this->deleted_at != null ){
				$where .= ' AND '.$this->deleted_at.' is null';		
			}

			//filtro show by id
			if( $this->where_filter != null ){
				$where .= ' AND '.$this->where_filter.'='.$this->where_id_filter;		
			}

		} else { 
			//filtro do deleted field
			$tem_delete = false;
			if(  ($this->deleted_at != null) && ($where =='') ){
				$where = 'WHERE '.$this->deleted_at.' is null';		
				$tem_delete = true;
			}
			
			//filtro show by id
			if( $this->where_filter != null ){
				if($tem_delete){
					$where .= ' AND '.$this->where_filter.'='.$this->where_id_filter;		
				} else {
					$where .= ' WHERE '.$this->where_filter.'='.$this->where_id_filter;		
				}	
			}
    	}

		return $where;
	}


	/**
	 * Perform the SQL queries needed for an server-side processing requested,
	 * utilising the helper functions of this class, limit(), order() and
	 * filter() among others. The returned array is ready to be encoded as JSON
	 * in response to an SSP request, or can be modified if needed before
	 * sending back to the client.
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array|\PDO $conn \PDO connection resource or connection parameters array
	 *  @param  string $table SQL table to query
	 *  @param  string $primaryKey Primary key of the table
	 *  @param  array $columns Column information array
	 *  @return array          Server-side processing response array
	 */
	public function simple ( $request, $conn, $table, $primaryKey, $columns)
	{
		$bindings = array();
		$db = $this->db;
		//$this->db( $conn );

		// Build the SQL query string from the request
		$limit = $this->limit( $request, $columns );
		$order = $this->order( $request, $columns );
		$where = $this->filter( $request, $columns, $bindings );

		// Main query to actually get the data
		$sql = "SELECT ".implode(", ", $this->pluck($columns, 'db'))."
				FROM $table
				$where
				$order
				$limit";

		$data = $this->sql_exec( $db, $bindings,
				"SELECT ".implode(", ", $this->pluck($columns, 'db'))."
				FROM $table
				$where
				$order
				$limit"
 		);

		// Data set length after filtering
		$resFilterLength = $this->sql_exec( $db, $bindings,
			"SELECT COUNT({$primaryKey})
			 FROM   $table
			 $where"
		);
		$recordsFiltered = $resFilterLength[0][0];

		// Total data set length
		$resTotalLength = $this->sql_exec( $db,
			"SELECT COUNT({$primaryKey})
			 FROM   $table"
		);
		$recordsTotal = $resTotalLength[0][0];

		/*
		 * Output
		 */
		return array(
			"draw"            => isset ( $request['draw'] ) ?
				intval( $request['draw'] ) :
				0,
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => $this->data_output( $columns, $data )
		);
	}


	/**
	 * The difference between this method and the simple one, is that you can
	 * apply additional where conditions to the SQL queries. These can be in
	 * one of two forms:
	 *
	 * * 'Result condition' - This is applied to the result set, but not the
	 *   overall paging information query - i.e. it will not effect the number
	 *   of records that a user sees they can have access to. This should be
	 *   used when you want apply a filtering condition that the user has sent.
	 * * 'All condition' - This is applied to all queries that are made and
	 *   reduces the number of records that the user can access. This should be
	 *   used in conditions where you don't want the user to ever have access to
	 *   particular records (for example, restricting by a login id).
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array|\PDO $conn \PDO connection resource or connection parameters array
	 *  @param  string $table SQL table to query
	 *  @param  string $primaryKey Primary key of the table
	 *  @param  array $columns Column information array
	 *  @param  string $whereResult WHERE condition to apply to the result set
	 *  @param  string $whereAll WHERE condition to apply to all queries
	 *  @return array          Server-side processing response array
	 */
	public function complex ( $request, $conn, $table, $primaryKey, $columns, $whereResult=null, $whereAll=null )
	{
		$bindings = array();
		$db = $this->db( $conn );
		$localWhereResult = array();
		$localWhereAll = array();
		$whereAllSql = '';

		// Build the SQL query string from the request
		$limit = $this->limit( $request, $columns );
		$order = $this->order( $request, $columns );
		$where = $this->filter( $request, $columns, $bindings );

		$whereResult = $this->_flatten( $whereResult );
		$whereAll = $this->_flatten( $whereAll );

		if ( $whereResult ) {
			$where = $where ?
				$where .' AND '.$whereResult :
				'WHERE '.$whereResult;
		}

		if ( $whereAll ) {
			$where = $where ?
				$where .' AND '.$whereAll :
				'WHERE '.$whereAll;

			$whereAllSql = 'WHERE '.$whereAll;
		}

		// Main query to actually get the data
		$data = $this->sql_exec( $db, $bindings,
			"SELECT ".implode(", ", $this->pluck($columns, 'db'))."
			 FROM $table
			 $where
			 $order
			 $limit"
		);

		// Data set length after filtering
		$resFilterLength = $this->sql_exec( $db, $bindings,
			"SELECT COUNT({$primaryKey})
			 FROM   $table
			 $where"
		);
		$recordsFiltered = $resFilterLength[0][0];

		// Total data set length
		$resTotalLength = $this->sql_exec( $db, $bindings,
			"SELECT COUNT({$primaryKey})
			 FROM   $table ".
			$whereAllSql
		);
		$recordsTotal = $resTotalLength[0][0];

		/*
		 * Output
		 */
		return array(
			"draw"            => isset ( $request['draw'] ) ?
				intval( $request['draw'] ) :
				0,
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => $this->data_output( $columns, $data )
		);
	}


	/**
	 * Connect to the database
	 *
	 * @param  array $sql_details SQL server connection details array, with the
	 *   properties:
	 *     * host - host name
	 *     * db   - database name
	 *     * user - user name
	 *     * pass - user password
	 * @return resource Database connection handle
	 */
	public function sql_connect ( $sql_details = null )
	{
		$DB_HOST = getenv('database.default.hostname');
		$DB_USER = getenv('database.default.username');
		$DB_PASS = getenv('database.default.password');
		$DB_NAME = getenv('database.default.database');
		try {
			$db = @new \PDO(
				"mysql:host={$DB_HOST};dbname={$DB_NAME}",
				$DB_USER,
				$DB_PASS,
				array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
			);
		}
		catch (\PDOException $e) {
			$this->fatal(
				"An error occurred while connecting to the database. ".
				"The error reported by the server was: ".$e->getMessage()
			);
		}
		/*
		try {
			$db = @new \PDO(

				"mysql:host={$sql_details['host']};dbname={$sql_details['db']}",
				$sql_details['user'],
				$sql_details['pass'],
				array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
			);
		}
		catch (PDOException $e) {
			$this->fatal(
				"An error occurred while connecting to the database. ".
				"The error reported by the server was: ".$e->getMessage()
			);
		}
        */
		//$db = \Config\Database::connect();
		return $db;
	}


	/**
	 * Execute an SQL query on the database
	 *
	 * @param  resource $db  Database handler
	 * @param  array    $bindings Array of \PDO binding values from bind() to be
	 *   used for safely escaping strings. Note that this can be given as the
	 *   SQL query string if no bindings are required.
	 * @param  string   $sql SQL query to execute.
	 * @return array         Result from the query (all rows)
	 */
	public function sql_exec ( $db, $bindings, $sql=null )
	{
		// Argument shifting
		if ( $sql === null ) {
			$sql = $bindings;
		}

		$stmt = $db->prepare( $sql );


		// Bind parameters
		if ( is_array( $bindings ) ) {
			for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
				$binding = $bindings[$i];
				$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
			}
		}

		// Execute
		try {

			$stmt->execute();
		}
		catch (\PDOException $e) {
			$this->fatal( "An SQL error occurred: ".$e->getMessage() );
		}

		// Return all
		return $stmt->fetchAll( \PDO::FETCH_BOTH );
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Internal methods
	 */

	/**
	 * Throw a fatal error.
	 *
	 * This writes out an error message in a JSON string which DataTables will
	 * see and show to the user in the browser.
	 *
	 * @param  string $msg Message to send to the client
	 */
	public function fatal ( $msg )
	{
		echo json_encode( array( 
			"error" => $msg
		) );

		exit(0);
	}

	/**
	 * Create a \PDO binding key which can be used for escaping variables safely
	 * when executing a query with sql_exec()
	 *
	 * @param  array &$a    Array of bindings
	 * @param  *      $val  Value to bind
	 * @param  int    $type \PDO field type
	 * @return string       Bound key to be used in the SQL where this parameter
	 *   would be used.
	 */
	public function bind ( &$a, $val, $type )
	{
		$key = ':binding_'.count( $a );

		$a[] = array(
			'key' => $key,
			'val' => $val,
			'type' => $type
		);

		return $key;
	}


	/**
	 * Pull a particular property from each assoc. array in a numeric array, 
	 * returning and array of the property values from each item.
	 *
	 *  @param  array  $a    Array to get data from
	 *  @param  string $prop Property to read
	 *  @return array        Array of property values
	 */
	public function pluck ( $a, $prop )
	{
		$out = array();

		for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
            if(empty($a[$i][$prop])){
                continue;
			}
			//removing the $out array index confuses the filter method in doing proper binding,
			//adding it ensures that the array data are mapped correctly
			$out[$i] = $a[$i][$prop];
		}

		return $out;
	}


	/**
	 * Return a string from an array or a string
	 *
	 * @param  array|string $a Array to join
	 * @param  string $join Glue for the concatenation
	 * @return string Joined string
	 */
	public function _flatten ( $a, $join = ' AND ' )
	{
		if ( ! $a ) {
			return '';
		}
		else if ( $a && is_array($a) ) {
			return implode( $join, $a );
		}
		return $a;
	}
}
