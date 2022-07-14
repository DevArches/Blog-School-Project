<?php
final class DBConnector{
    public function dbConnect()
    {
        $dns = 'mysql:host=localhost;dbname=fa111;port=3306';
        $user = 'root';
        $pwd = '';
        $opt = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        ];
        try {
            return new PDO($dns, $user, $pwd, $opt);
        } catch (PDOException $e) {
            echo 'Verbindungsfehler: ' . $e->getMessage();
        }
    }
}