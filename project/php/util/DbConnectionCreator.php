<?php

class DbConnectionCreator
{
    public static function createConnection()
    {
        $ini = parse_ini_file('app.ini.php');
        $connectionString = 'mysql:host=' . $ini['db_host'] . ":" . $ini['db_port'] . ";dbname=" . $ini['db_name'];
        $username = $ini['db_user'];
        $password = $ini['db_password'];

        $conn = new PDO($connectionString, $username, $password);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        return $conn;
    }
}

