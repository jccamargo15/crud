<?php

class Manager extends Conexao {

    public function insertClient($table, $data) {
        $pdo = parent::getInstance();
        $fields = implode(", ", array_keys($data));
        $values = ":".implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $statement = $pdo->prepare($sql);
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value, PDO::PARAM_STR);
        }
        $statement->execute();
    }

    public function listClient($table) {
        $pdo = parent::getInstance();
        $sql = "SELECT * FROM $table ORDER BY name ASC";
        $statement = $pdo->query($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function deleteClient($table, $id) {
        $pdo = parent::getInstance();
        $sql = "DELETE FROM $table where id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();
    }

    public function getInfo($table, $id) {
        $pdo = parent::getInstance();
        $sql = "SELECT * FROM $table WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function updateClient($table, $data, $id) {
        $pdo = parent::getInstance();
        $new_values = "";
        foreach ($data as $key => $value) {
            $new_values .= "$key=:$key, ";
        }
        $new_values = substr($new_values, 0, -2);
        $sql = "UPDATE $table SET $new_values WHERE id = :id";
        $statement = $pdo->prepare($sql);
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value, PDO::PARAM_STR);
        }
        $statement->bindValue(":id", $id);
        $statement->execute();
    }
}