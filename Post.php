<?php

class Post
{
  public function delete(int $id)
  {
    $conn = Transaction::get();
    $prepare = $conn->prepare('delete from posts where id = :id');
    return $prepare->execute(['id' => $id]);
  }
}
