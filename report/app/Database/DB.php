<?php

namespace App\Database;

/**
 * Class DB
 * @package App\Database
 */
class DB
{
    /**
     * @var
     */
    private static $table;

    /**
     * @var
     */
    private static $instance;

    /**
     * @var \mysqli
     */
    public static $mysqli;

    /**
     * @var
     */
    private $limit;

    /**
     * @var string
     */
    private $whereQuery = ' where';

    /**
     * @var
     */
    private $sort;

    /**
     * DB constructor.
     */
    public function __construct()
    {
        self::$mysqli = new \mysqli(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'), env('DB_PORT'));
        if (self::$mysqli->connect_error) {
            die("Connection failed: " . self::$mysqli->connect_error);
        }
    }

    /**
     * @param $table
     * @return DB
     */
    public static function table($table)
    {
        self::$table = $table;
        self::$instance = new self();
        return self::$instance;
    }

    /**
     * @return DB
     */
    public static function run()
    {
        self::$instance = new self();
        return self::$instance;
    }

    /**
     * @param $data
     * @return bool
     */
    public function insert($data)
    {
        $dataLength = count($data);
        if ($dataLength >= 1) {
            $table = self::$table;
            $columns = null;
            $values = null;
            $i = 1;
            foreach ($data as $key => $value) {
                $key = input($key);
                $value = input($value);
                if ($dataLength != $i) {
                    $columns .= $key . ',';
                    $values .= "'$value'" . ',';
                } else {
                    $columns .= $key;
                    $values .= "'$value'";
                }
                $i++;
            }
            $query = "INSERT INTO $table ($columns) VALUES ($values)";
            self::$mysqli->query($query);
            $this->Close();
            return true;
        }
        return false;
    }

    /**
     * @param $key
     * @param $operator
     * @param null $value
     * @return mixed
     */
    public function where($key, $operator, $value = null)
    {
        return $this->whereQuery($key, 'AND', $operator, $value);

    }

    /**
     * @param $key
     * @param $operator
     * @param null $value
     * @return mixed
     */
    public function orWhere($key, $operator, $value = null)
    {
        return $this->whereQuery($key, 'OR', $operator, $value);

    }

    /**
     * @param $key
     * @param $andOr
     * @param $operator
     * @param null $value
     * @return mixed
     */
    private function whereQuery($key, $andOr, $operator, $value = null)
    {
        if ($value == null) {
            if (strlen($this->whereQuery) > 6) {
                $this->whereQuery .= "$andOr $key = '$operator'";
            } else {
                $this->whereQuery .= " $key = '$operator'";
            }
        } else {
            if (strlen($this->whereQuery) > 6) {
                $this->whereQuery .= "$andOr $key $operator '$value'";
            } else {
                $this->whereQuery .= " $key $operator '$value'";
            }
        }
        return self::$instance;
    }

    /**
     * @return string
     */
    public function query()
    {
        $query = self::$table;
        strlen($this->whereQuery) > 6 ? $query .= $this->whereQuery : null;
        return $query;

    }

    /**
     * @return bool
     */
    public function exists()
    {
        $table = self::$table;
        $query = "SELECT * FROM $table";
        strlen($this->whereQuery) > 6 ? $query .= $this->whereQuery : null;
        $result = self::$mysqli->query($query);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param null $sql
     * @return object
     */
    public function get($sql = null)
    {
        if ($sql == null) {
            $table = self::$table;
            $query = "SELECT * FROM $table";
            strlen($this->whereQuery) > 6 ? $query .= $this->whereQuery : null;
        } else {
            $query = "SELECT * FROM " . $sql;
        }
        $this->sort ? $query .= $this->sort : null;
        $this->limit ? $query .= $this->limit : null;
        $result = self::$mysqli->query($query);
        $arr = array();
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        }
        $arr = json_decode(json_encode($arr));
        return (object)$arr;
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        $data = (array)$this->get();
        return $data ? ($data[0]) : null;
    }

    /**
     * @param null $sql
     * @return mixed
     */
    public function count($sql = null)
    {
        if ($sql == null) {
            $query = "SELECT count(id) FROM ";
            $query .= self::$table;
            strlen($this->whereQuery) > 6 ? $query .= $this->whereQuery : null;
        } else {
            $query = "SELECT count(id) FROM " . $sql;
        }
        $run = self::$mysqli->query($query);
        return $run->fetch_all(MYSQLI_ASSOC)[0]['count(id)'];
    }

    /**
     * @param $limit
     * @param null $start
     * @return mixed
     */
    public function limit($limit, $start = null)
    {
        if ($start) {
            $this->limit = " LIMIT $start, $limit";
        } else {
            $this->limit = " LIMIT $limit";
        }
        return self::$instance;
    }

    /**
     * @param $data
     * @return bool|\mysqli_result
     */
    public function update($data)
    {
        $table = self::$table;
        $query = "UPDATE $table SET";
        $dataLength = count($data);
        $i = 1;
        foreach ($data as $key => $value) {
            $dataLength != $i ? $query .= " $key = '$value'," : $query .= " $key = '$value'";
            $i++;
        }

        if (strlen($this->whereQuery) > 6) {
            $query .= $this->whereQuery;
        }
        return self::$mysqli->query($query);
    }

    /**
     * @return bool|\mysqli_result
     */
    public function delete()
    {
        $table = self::$table;
        $query = "DELETE FROM $table";
        strlen($this->whereQuery) > 6 ? $query .= $this->whereQuery : null;
        return self::$mysqli->query($query);

    }

    /**
     * @param $column
     * @param $type
     * @return mixed
     */
    public function order($column, $type)
    {
        $this->sort = " ORDER BY $column $type";
        return self::$instance;
    }

    /**
     * close mysql connection
     */
    private function Close()
    {
        if (self::$mysqli) {
            self::$mysqli->close();
        }
    }
}
