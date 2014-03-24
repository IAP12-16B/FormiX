<?php
namespace kije\Formgenerator\inc;


/**
 * Class DB
 * @package kije\Formgenerator\inc
 */
class DB
{
    const MYSQL_DATE = 'Y-m-d';
    const MYSQL_DATETIME = 'Y-m-d H:i:s';

    protected static $instance;

    /**
     * Returns a configured PDO instance
     * @return null|\PDO
     */
    public static function dbh()
    {
        if (!self::$instance) {
            // connect to database
            try {
                self::$instance = new \PDO(
                    'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE,
                    DB_USER,
                    DB_PASSWORD,
                    array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                );
                self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                return null;
            }
        }

        return self::$instance;
    }

    /**
     * @param $timestamp
     *
     * @return bool|string
     */
    public static function unix2datetime($timestamp)
    {
        return date(self::MYSQL_DATETIME, $timestamp);
    }
}
