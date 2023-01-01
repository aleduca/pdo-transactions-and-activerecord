<?php

class User
{
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
