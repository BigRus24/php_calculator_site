<?php
declare(strict_types=1);

function get_all_tables(object $pdo) {

    try {
        $query = "SHOW TABLES";
        $stmt = $pdo->query($query);

        $tables = [];
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }

        return $tables;
    } catch (PDOException $e) {
        throw new Exception('Error fetching tables: ' . $e->getMessage());
    }
}

function get_table_columns(object $pdo, string $tableName) {

    try {
        $query = "SHOW COLUMNS FROM `" . str_replace("`", "``", $tableName) . "`";
        $stmt = $pdo->query($query);

        $columns = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $columns[] = $row['Field'];
        }

        return $columns;
    } catch (PDOException $e) {
        throw new Exception('Error fetching columns from table ' . htmlspecialchars($tableName) . ': ' . $e->getMessage());
    }
}

function get_table_data(object $pdo, string $tableName) {

    try {
        $query = "SELECT * FROM `" . str_replace("`", "``", $tableName) . "`";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    } catch (PDOException $e) {
        throw new Exception('Error fetching data from table ' . htmlspecialchars($tableName) . ': ' . $e->getMessage());
    }
}

function get_row(object $pdo, string $tableName, int $id) {

    try {
        $query = "SELECT * FROM `" . str_replace("`", "``", $tableName) . "` WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    } catch (PDOException $e) {
        throw new Exception('Error fetching row from table ' . htmlspecialchars($tableName) . ': ' . $e->getMessage());
    }
}

function create_row(object $pdo, string $tableName, array $data) {

    try {
        $columns = array_keys($data);
        $values = array_values($data);

        $query = "INSERT INTO `" . str_replace("`", "``", $tableName) . "` (" . implode(', ', $columns) . ") VALUES (:" . implode(', :', $columns) . ")";
        $stmt = $pdo->prepare($query);

        foreach ($data as $column => $value) {
            $stmt->bindValue(':' . $column, $value);
        }

        $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception('Error creating row in table ' . htmlspecialchars($tableName) . ': ' . $e->getMessage());
    }
}

function update_row(object $pdo, string $tableName, int $id, array $data) {

    try {
        $columns = array_keys($data);
        $values = array_values($data);

        $query = "UPDATE `" . str_replace("`", "``", $tableName) . "` SET ";
        foreach ($columns as $column) {
            $query .= $column . ' = :' . $column . ', ';
        }
        $query = substr($query, 0, -2);
        $query .= " WHERE id = :id";

        $stmt = $pdo->prepare($query);

        foreach ($data as $column => $value) {
            $stmt->bindValue(':' . $column, $value);
        }
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception('Error updating row in table ' . htmlspecialchars($tableName) . ': ' . $e->getMessage());
    }
}

function delete_row(object $pdo, string $tableName, int $id) {

    try {
        $query = "DELETE FROM `" . str_replace("`", "``", $tableName) . "` WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception('Error deleting row from table ' . htmlspecialchars($tableName) . ': ' . $e->getMessage());
    }
}