<?php
class db_connect {
	private $DB_HOST = 'localhost';
	private $DB_NAME = 'bjp';
	private $DB_USER = 'root';
	private $DB_PASS = '';
	private $DB_CHARSET = 'UTF8';
	
    protected $db;
    protected function __construct($dbo=NULL)
    {
		if( isset($dbo) ){
			if ( is_object($dbo) ){
				$this->db = $dbo;
			}
		}
        else{
            $dsn = "mysql:host=" . $this->DB_HOST . ";dbname=" . $this->DB_NAME . ";charset=" . $this->DB_CHARSET;
            try{ $this->db = new PDO($dsn, $this->DB_USER, $this->DB_PASS); }
            catch ( Exception $e ){ die ( $e->getMessage() ); }
        }
    }
}