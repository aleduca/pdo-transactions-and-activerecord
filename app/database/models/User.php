<?php

namespace app\database\models;

use app\database\ActiveRecord;
use app\database\Transaction;

class User extends ActiveRecord
{
  public const TABLENAME = 'users';

  public function getUsers()
  {
    $conn = Transaction::get();
    $prepare = $conn->prepare('select * from users');
    $prepare->execute();
    return $prepare->fetchAll();
  }

  public function delete(int $id)
  {
    $conn = Transaction::get();
    $prepare = $conn->prepare('delete from users where id = :id');
    return $prepare->execute(['id' => $id]);
  }
}
