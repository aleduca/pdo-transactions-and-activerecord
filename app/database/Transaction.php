<?php

namespace app\database;

use app\database\Connection;
use PDO;

class Transaction
{
  private static ?PDO $conn = null;

  public static function open()
  {
    self::$conn = Connection::getConnetion();
    self::$conn->beginTransaction();
  }

  public static function rollback()
  {
    if (self::$conn) {
      self::$conn->rollback();
      self::$conn = null;
    }
  }

  public static function get()
  {
    if (self::$conn) {
      return self::$conn;
    }
  }

  public static function close()
  {
    if (self::$conn) {
      self::$conn->commit();
      self::$conn = null;
    }
  }
}
