<?php

namespace app\database\models;

use app\database\ActiveRecord;
use app\database\Transaction;

class Post extends ActiveRecord
{
  public const TABLENAME = 'posts';

  public function delete(int $id)
  {
    $conn = Transaction::get();
    $prepare = $conn->prepare('delete from posts where id = :id');
    return $prepare->execute(['id' => $id]);
  }
}
