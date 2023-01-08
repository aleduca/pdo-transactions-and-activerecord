<?php

namespace app\database;

use app\database\Transaction;

use PDO;

abstract class ActiveRecordActions
{
  protected array $data = [];

  private function update(string $tableName)
  {
    $sql = "update {$tableName} set ";
    foreach (array_keys($this->data) as $field) {
      if ($field != 'id') {
        $sql .= "{$field} = :{$field},";
      }
    }
    $sql = rtrim($sql, ',');

    $sql .= " where id = :id";

    return $this->execute($sql, $this->data);
  }

  private function insert(string $tableName)
  {
    $sql = "insert into {$tableName}(" . implode(',', array_keys($this->data)) . ") values(:" . implode(',:', array_keys($this->data)) . ")";

    return $this->execute($sql, $this->data);
  }

  public function save()
  {
    $class = get_class($this);
    $tableName = constant("{$class}::TABLENAME");

    $saved = array_key_exists('id', $this->data) ?
      $this->update($tableName) :
      $this->insert($tableName);

    return $saved;
  }

  public function getById(string $fields = '*', ?int $id = null)
  {
    $class = get_class($this);
    $tableName = constant("{$class}::TABLENAME");

    if (array_key_exists('id', $this->data)) {
      $id = $this->data['id'];
    }

    $sql =  "select {$fields} from {$tableName} where id = :id";

    $prepare = $this->execute($sql, ['id' => $id], true);

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
    $class = get_class($this);
    $tableName = constant("{$class}::TABLENAME");

    if (array_key_exists('id', $this->data)) {
      $id = $this->data['id'];
    }

    return $this->execute("delete from {$tableName} where id = :id", ['id' => $id]);
  }

  private function execute(string $sql, array $execute, bool $returnPrepare = false)
  {
    $this->data = [];

    $conn = Transaction::get();

    $prepare = $conn->prepare($sql);

    $executed = $prepare->execute($execute);

    if ($returnPrepare) {
      return $prepare;
    }

    return $executed;
  }
}
