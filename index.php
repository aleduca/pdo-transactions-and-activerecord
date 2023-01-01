<?php

require 'Transaction.php';
require 'User.php';
require 'Post.php';

try {
  Transaction::open();

  $user = new User;
  $user->delete(100);


  $post = new Post;
  $post->delete(100);

  Transaction::close();
} catch (\Throwable $th) {
  var_dump($th->getMessage());
  Transaction::rollback();
}
