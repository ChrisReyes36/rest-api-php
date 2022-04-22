<?php
class Connection
{
    // Información para conectarse la base de datos.
    // Information to connect the database.
    private static $host = 'localhost';
    private static $username = 'root';
    private static $password = '';
    private static $database = 'api_rest_php';
    private static $connection;
    private static $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::MYSQL_ATTR_FOUND_ROWS => true
    );
    // Creamos método para conectar.
    // We create method to connect.
    public static function connect()
    {
        try {
            self::$connection = new PDO(
                'mysql:host=' . self::$host . ';dbname=' . self::$database,
                self::$username,
                self::$password,
                self::$options
            );
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$connection;
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
            self::$connection = null;
            return self::$connection;
        }
    }
    // Creamos método para desconectar.
    // We create method to disconnect.
    public static function disconnect()
    {
        return self::$connection = null;
    }
}
?>