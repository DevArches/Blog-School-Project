<?php

class Instance {
    private static $instance = null;

    static function getInstance() {
        $dns = 'mysql:host=localhost;dbname=fa111;port=3306';
        $user = 'root';
        $pwd = '';
        $opt = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        ];
        if (is_null(self::$instance)) {
            try {
                self::$instance = new PDO($dns, $user, $pwd, $opt);
                echo "Connected to database";
            } catch (PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
                exit;
            }
        }
        return self::$instance;
    }
}