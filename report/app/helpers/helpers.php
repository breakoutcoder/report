<?php

/**
 * @param null $path
 * @return string
 */
function basePath($path = null)
{
    $dir = dirname(__DIR__) . '/..';
    if ($path) {
        if ($path[0] == '/') {
            $dir .= $path;
        } else {
            $dir .= '/' . $path;
        }
    }
    return $dir;
}

/**
 * @param $key
 * @return string|null
 */
function env($key)
{
    $filename = basepath("/.env");
    $fp = fopen($filename, 'r');
    $value = null;
    while ($line = fgets($fp)) {
        $entry = explode("=", $line, 2);
        if ($key == trim($entry[0])) {
            $value = trim($entry[1]);
            break;
        }
    }
    return $value;
}

/**
 * @param $data
 * @return string
 */
function input($data): string
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = addslashes($data);
    return htmlspecialchars($data);
}

/**
 * @return mixed
 */
function ipAddress()
{
    return (isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
}

/**
 * @param null $url
 * @return string|null
 */
function url($url = null)
{
    $env = rtrim(env('APP_URL'), '/');
    if ($url) {
        $url = ltrim($url, '/');
        return $env . '/' . $url;
    }
    return $env;
}