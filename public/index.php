<?php

require '../vendor/autoload.php';

use app\database\models\Post;
use app\database\models\User;
use app\database\Transaction;

try {
  Transaction::open();

  // $post = new Post;
  $user = new User;
  $user->id = 5;
  // $post->id = 13;
  // $user->id = 93;
  // $user->firstName = 'Alexandre';
  // $user->lastName = 'Cardoso';
  // $user->email = 'email12@email.com.br';
  // $user->password = password_hash('123', PASSWORD_DEFAULT);
  // $user = $user->getById('id, firstName, lastName', 99);
  $users = $user->getById('firstName,lastName,email');

  // $deleted = $user->delete(92);

  var_dump($users);

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
