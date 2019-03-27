<?php

class Connection
{
    public static function getPDOConnection($config)
    {
        static $connection;

        if (!empty($connection)) {
            return $connection;
        }

        try {
            $connection = new PDO(
                $config['connection'].';dbname='.$config['name'],
                $config['username'],
                $config['password'],
                $config['options']
            );

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}