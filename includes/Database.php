<?php
class DbConnect
{
    const DB_USER = 'root';
    const DB_PASSWORD = '';
    const DB_HOST = 'localhost';
    const DB_NAME = 'booksy';

    private $dbc;

    public function __construct()
    {
        $this->dbc = @mysqli_connect(
            self::DB_HOST,
            self::DB_USER,
            self::DB_PASSWORD,
            self::DB_NAME
        )
        or die(
            'Could not connect to MySQL: ' . mysqli_connect_error()
        );

        mysqli_set_charset($this->dbc, 'utf8');
    }

    public function prepare_string($string)
    {
        $string = strip_tags($string);
        $string = mysqli_real_escape_string($this->dbc, trim($string));
        return $string;
    }

    public function query($query, $params=[]){
        $stmt = mysqli_stmt_init($this->dbc);
        mysqli_stmt_prepare($stmt, $query);
        if(count($params)){
            $param_types = implode('',array_keys($params));
            $params_values = array_values($params);
            mysqli_stmt_bind_param($stmt, $param_types, ...$params_values);
        }
        $result = mysqli_stmt_execute($stmt);
        $res = $stmt->get_result();
        if(!$res){
            return false;
        }
        $output = [];
        while($row = $res->fetch_assoc()){
            $output[] = $row;
        }
        return $output;
    }
    
    public function get_dbc()
    {
        return $this->dbc;
    }
}