<?php

require '../vendor/autoload.php';

use app\database\models\Post;
use app\database\Transaction;

try {
  Transaction::open();

  $post = new Post;
  $post->id = 85;
  // $user->id = 99;
  // $user->firstName = 'Joao';
  // $user->lastName = 'Santos';
  // $user->email = 'email12@email.com.br';
  // $user->password = password_hash('123', PASSWORD_DEFAULT);
  // $user = $user->getById('id, firstName, lastName', 99);
  $deleted = $post->delete();

  var_dump($deleted);

  // foreach ($posts as $post) {
  //   echo $post->title . '<br />';
  // }

  // var_dump($user);


  // $post = new Post;
  // $post->delete(100);

  Transaction::close();
} catch (\Throwable $th) {
  var_dump($th->getTrace());
  Transaction::rollback();
}
