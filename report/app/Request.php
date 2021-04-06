<?php

namespace App;

/**
 * Class Request
 * @package App
 */
class Request
{
    /**
     * @var array|object
     */
    private static $data = array();

    /**
     * Request constructor.
     */
    public function __construct()
    {
        self::data();
        self::$data = (object)self::$data;
    }

    /**
     * @param string $key
     * @return false
     */
    public function __get(string $key)
    {
        if (property_exists(self::$data, $key)) {
            return self::$data->$key;
        }
        return false;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        if (property_exists(self::$data, $key)) {
            return true;
        }
        return false;
    }

    /**
     *
     */
    private static function data()
    {
        if (($_SERVER['REQUEST_METHOD']) == 'POST') {
            if ($_POST) {
                foreach ($_POST as $key => $value) {
                    self::$data[input($key)] = input($value);
                }
            }
        }
        if (($_SERVER['REQUEST_METHOD']) == 'GET') {
            if ($_GET) {
                foreach ($_GET as $key => $value) {
                    self::$data[input($key)] = input($value);
                }
            }
        }
    }
}