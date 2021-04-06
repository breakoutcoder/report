<?php

namespace App;

/**
 * Class Validate
 * @package App
 */
class Validate
{
    /**
     * @param $data
     * @return array
     */
    public function validate($data)
    {
        $response = array();
        foreach ($data as $key => $item) {
            $required = explode('|', $item);
            foreach ($required as $value) {
                if (strpos($value, ':')) {
                    $multiple = explode(':', $value);
                    $function = $multiple[0] . 'Explode';
                    $message = $this->$function($key, $multiple[1]);
                    if ($message) {
                        $response[$key] = $message;
                    }
                    continue;
                }
                $message = $this->$value($key);
                if ($message) {
                    $response[$key] = $message;
                }
            }
        }
        return $response;
    }

    /**
     * @param $key
     * @param $max
     * @return string|null
     */
    private function maxWordExplode($key, $max)
    {
        if (isset($_REQUEST[$key])) {
            if (str_word_count($_REQUEST[$key]) > $max) {
                return "sorry, you can't add more than $max word";
            }
            return null;
        }
        return null;
    }

    /**
     * @param $key
     * @param $max
     * @return string|null
     */
    private function maxExplode($key, $max)
    {
        if (isset($_REQUEST[$key])) {
            if (strlen($_REQUEST[$key]) > (int)$max) {
                return "sorry, you can't add more than $max character";
            }
            return null;
        }
        return null;
    }

    /**
     * @param $key
     * @param $min
     * @return string|null
     */
    private function minExplode($key, $min)
    {
        if (isset($_REQUEST[$key])) {
            if (strlen($_REQUEST[$key]) < (int)$min) {
                return "sorry, you cannot add less than $min character";
            }
            return null;
        }
        return null;
    }

    /**
     * @param $key
     * @return string|null
     */
    private function required($key)
    {
        if (isset($_REQUEST[$key])) {
            if ($_REQUEST[$key] == null) {
                return "$key field is required";
            }
            return null;
        }
        return "$key field is required";
    }

    /**
     * @param $key
     * @return string|null
     */
    private function number($key)
    {
        if (isset($_REQUEST[$key])) {
            if (is_numeric($_REQUEST[$key])) {
                return null;
            }
            return "$key must be numeric";
        }
        return null;
    }

    /**
     * @param $key
     * @return string|null
     */
    private function email($key)
    {
        if (isset($_REQUEST[$key])) {
            if (!filter_var($_REQUEST[$key], FILTER_VALIDATE_EMAIL)) {
                return "$key field is invalid email format";
            }
            return null;
        }
        return null;
    }
}