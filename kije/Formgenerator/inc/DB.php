<?php
namespace kije\Formgenerator\inc;

class DB
{
	const MYSQL_DATE = 'Y-m-d';
	const MYSQL_DATETIME = 'Y-m-d H:i:s';

	protected static $_dbh;

	public static function dbh() {
		if (!self::$_dbh) {
			// connect to database
			try {
				self::$_dbh = new \PDO(
					'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE,
					DB_USER,
					DB_PASSWORD,
					array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
				);
				self::$_dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			} catch (\PDOException $e) {
				return NULL;
			}
		}

		return self::$_dbh;
	}

	public static function unix2datetime($timestamp) {
		return date(self::MYSQL_DATETIME, $timestamp);
	}

}