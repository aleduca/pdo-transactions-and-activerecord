<?php

namespace app\database;

use app\database\Transaction;

use PDO;

abstract class ActiveRecordActions
{
  protected array $data = [];

  private function update(string $tableName)
  {
    $conn = Transaction::get();

    $sql = "update {$tableName} set ";
    foreach (array_keys($this->data) as $field) {
      if ($field != 'id') {
        $sql .= "{$field} = :{$field},";
      }
    }
    $sql = rtrim($sql, ',');

    $sql .= " where id = :id";

    $prepare = $conn->prepare($sql);
    return $prepare->execute($this->data);
  }

  private function insert(string $tableName)
  {
    $conn = Transaction::get();

    $sql = "insert into {$tableName}(" . implode(',', array_keys($this->data)) . ") values(:" . implode(',:', array_keys($this->data)) . ")";

    $prepare = $conn->prepare($sql);
    return $prepare->execute($this->data);
  }

  public function save()
  {
    $class = get_class($this);
    $tableName = constant("{$class}::TABLENAME");

    return array_key_exists('id', $this->data) ?
      $this->update($tableName) :
      $this->insert($tableName);
  }

  public function getById(string $fields = '*', ?int $id = null)
  {
    $class = get_class($this);
    $tableName = constant("{$class}::TABLENAME");

    if (array_key_exists('id', $this->data)) {
      $id = $this->data['id'];
    }

    $sql =  "select {$fields} from {$tableName} where id = :id";
    $conn = Transaction::get();

    $prepare = $conn->prepare($sql);
    $prepare->execute([
      'id' => $id
    ]);

    return $prepare->fetchObject($class);
  }

  public function all(string $fields = '*')
  {
    $class = get_class($this);
    $tableName = constant("{$class}::TABLENAME");

    $sql = "select {$fields} from {$tableName}";
    $conn = Transaction::get();

    $query = $conn->query($sql);
    return $query->fetchAll(PDO::FETCH_CLASS, static::class);
  }

  public function delete(?int $id = null)
  {
    $conn = Transaction::get();

    if (array_key_exists('id', $this->data)) {
      $id = $this->data['id'];
    }

    $prepare = $conn->prepare('delete from posts where id = :id');
    return $prepare->execute(['id' => $id]);
  }
}
