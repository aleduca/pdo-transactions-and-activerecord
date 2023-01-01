<?php

use PDO;

class Connection
{
  public static ?PDO $connection = null;

  public static function getConnetion()
  {
    if (!self::$connection) {
      self::$connection = new PDO("mysql:host=localhost;dbname=blog_ci", "root", "", [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
      ]);
    }

    return self::$connection;
  }
}
