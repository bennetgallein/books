<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 29.10.18
 * Time: 00:28
 */

namespace Controllers;


use PDO;
use PDOException;

class DataBase {
    private $pdo;

    /**
     * DataBase constructor.
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     */
    public function __construct($host, $user, $password, $database) {
        Panel::setDatabase($this);
        try {
            $this->pdo = new PDO("mysql:host=" . $host . ";dbname=" . $database, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4';"));
            $this->pdo->exec("SET CHARACTER SET utf8mb4");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->query("set names utf8mb4");
        } catch (PDOException $e) {
            echo "error " . $e->getMessage();
        }
    }

    /**
     * custom query ,update,delete,insert,or fetch, joining multiple table etc, aritmathic etc
     * @param  string $sql custom query
     * @param  array $data associative array
     * @return bool|\PDOStatement recordset
     */
    public function custom_query($sql, $data = null, $mode = PDO::FETCH_OBJ) {
        if ($data !== null) {
            $dat = array_values($data);
        }
        $sel = $this->pdo->prepare($sql);
        if ($data !== null) {
            $sel->execute($dat);
        } else {
            $sel->execute();
        }
        $sel->setFetchMode($mode);
        return $sel;
    }

    /**
     * begin a transaction.
     */
    public function begin_transaction() {
        $this->pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
        $this->pdo->beginTransaction();
    }

    /**
     * commit the transaction.
     */
    public function commit() {
        $this->pdo->commit();
        $this->pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
    }

    /**
     * rollback the transaction.
     */
    public function rollback() {
        $this->pdo->rollBack();
        $this->pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
    }

    /**
     * fetch only one row
     * @param  string $table table name
     * @param  string $col condition column
     * @param  string $val value column
     * @return array recordset
     */
    public function fetch_single_row($table, $col, $val, $mode = PDO::FETCH_OBJ) {
        $nilai = array($val);
        $sel = $this->pdo->prepare("SELECT * FROM $table WHERE $col=?");
        $sel->execute($nilai);
        $sel->setFetchMode($mode);
        $obj = $sel->fetch();
        return $obj;
    }

    /**
     * fetch all data
     * @param  string $table table name
     * @param int $mode
     * @return bool|\PDOStatement recordset
     */
    public function fetch_all($table, $mode = PDO::FETCH_OBJ) {
        $sel = $this->pdo->prepare("SELECT * FROM $table");
        $sel->execute();
        $sel->setFetchMode($mode);
        return $sel;
    }

    /**
     * fetch multiple row
     * @param  string $table table name
     * @param  array $dat specific column selection
     * @return bool|\PDOStatement recordset
     */
    public function fetch_col($table, $dat) {
        if ($dat !== null)
            $cols = array_values($dat);
        $col = implode(', ', $cols);
        $sel = $this->pdo->prepare("SELECT $col from $table");
        $sel->execute();
        $sel->setFetchMode(PDO::FETCH_OBJ);
        return $sel;
    }

    /**
     * fetch row with condition
     * @param  string $table table name
     * @param  array $col which columns name would be select
     * @param  array $where what column will be the condition
     * @return bool|\PDOStatement recordset
     */
    public function fetch_multi_row($table, $col, $where, $mode = PDO::FETCH_OBJ) {
        $data = array_values($where);
        //grab keys
        $cols = array_keys($where);
        $colum = implode(', ', $col);
        foreach ($cols as $key) {
            $keys = $key . "=?";
            $mark[] = $keys;
        }
        $jum = count($where);
        if ($jum > 1) {
            $im = implode('? and  ', $mark);
            $sel = $this->pdo->prepare("SELECT $colum from $table WHERE $im");
        } else {
            $im = implode('', $mark);
            $sel = $this->pdo->prepare("SELECT $colum from $table WHERE $im");
        }
        $sel->execute($data);
        $sel->setFetchMode($mode);
        return $sel;
    }

    /**
     * fetch row with condition
     * @param  string $table table name
     * @param  array $col which columns name would be select
     * @param  array $where what column will be the condition
     * @param $order
     * @param  string $index based on which column
     * @return bool|\PDOStatement recordset
     */
    public function fetch_multi_row_order($table, $col, $where, $order, $index) {
        $data = array_values($where);
        //grab keys
        $cols = array_keys($where);
        $colum = implode(', ', $col);
        foreach ($cols as $key) {
            $keys = $key . "=?";
            $mark[] = $keys;
        }
        $jum = count($where);
        if ($jum > 1) {
            $im = implode('? and  ', $mark);
            $sel = $this->pdo->prepare("SELECT $colum from $table WHERE $im ORDER BY $index $order");
        } else {
            $im = implode('', $mark);
            $sel = $this->pdo->prepare("SELECT $colum from $table WHERE $im ORDER BY $index $order");
        }
        $sel->execute($data);
        $sel->setFetchMode(PDO::FETCH_OBJ);
        return $sel;
    }

    /**
     * check if there is exist data
     * @param  string $table table name
     * @param  array $dat array list of data to find
     * @return true or false
     */
    public function check_exist($table, $dat) {
        $data = array_values($dat);
        //grab keys
        $cols = array_keys($dat);
        $col = implode(', ', $cols);
        foreach ($cols as $key) {
            $keys = $key . "=?";
            $mark[] = $keys;
        }
        $jum = count($dat);
        if ($jum > 1) {
            $im = implode(' and  ', $mark);
            $sel = $this->pdo->prepare("SELECT $col from $table WHERE $im");
        } else {
            $im = implode('', $mark);
            $sel = $this->pdo->prepare("SELECT $col from $table WHERE $im");
        }
        $sel->execute($data);
        $sel->setFetchMode(PDO::FETCH_OBJ);
        $jum = $sel->rowCount();
        if ($jum > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * search data
     * @param  string $table table name
     * @param  array $col column name
     * @param  array $where where condition
     * @return bool|\PDOStatement recordset
     */
    public function search($table, $col, $where) {
        $data = array_values($where);
        foreach ($data as $key) {
            $val = '%' . $key . '%';
            $value[] = $val;
        }
        //grab keys
        $cols = array_keys($where);
        $colum = implode(', ', $col);
        foreach ($cols as $key) {
            $keys = $key . " LIKE ?";
            $mark[] = $keys;
        }
        $jum = count($where);
        if ($jum > 1) {
            $im = implode(' OR  ', $mark);
            $sel = $this->pdo->prepare("SELECT $colum from $table WHERE $im");
        } else {
            $im = implode('', $mark);
            $sel = $this->pdo->prepare("SELECT $colum from $table WHERE $im");
        }
        $sel->execute($value);
        $sel->setFetchMode(PDO::FETCH_OBJ);
        return $sel;
    }

    /**
     * get last insert id
     * @return int last insert id
     */
    public function get_last_id() {
        return $this->pdo->lastInsertId();
    }

    /**
     * insert data to table
     * @param  string $table table name
     * @param  array $dat associative array 'column_name'=>'val'
     */
    public function insert($table, $dat) {
        if ($dat !== null)
            $data = array_values($dat);
        //grab keys
        $cols = array_keys($dat);
        $col = implode(', ', $cols);
        //grab values and change it value
        $mark = array();
        foreach ($data as $key) {
            $keys = '?';
            $mark[] = $keys;
        }
        $im = implode(', ', $mark);
        $ins = $this->pdo->prepare("INSERT INTO $table ($col) values ($im)");
        $ins->execute($data);
    }

    /**
     * update record
     * @param  string $table table name
     * @param  array $dat associative array 'col'=>'val'
     * @param  string $id primary key column name
     * @param  int $val key value
     */
    public function update($table, $dat, $id, $val) {
        if ($dat !== null)
            $data = array_values($dat);
        array_push($data, $val);
        //grab keys
        $cols = array_keys($dat);
        $mark = array();
        foreach ($cols as $col) {
            $mark[] = $col . "=?";
        }
        $im = implode(', ', $mark);
        $ins = $this->pdo->prepare("UPDATE $table SET $im where $id=?");
        $ins->execute($data);
    }

    /**
     * delete record
     * @param  string $table table name
     * @param  string $where column name for condition (commonly primay key column name)
     * @param   int $id key value
     */
    public function delete($table, $where, $id) {
        $data = array($id);
        $sel = $this->pdo->prepare("Delete from $table where $where=?");
        $sel->execute($data);
    }

    public function __destruct() {
        $this->pdo = null;
    }
}