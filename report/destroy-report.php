<?php

require 'vendor/autoload.php';

use App\Request;
use App\Validate;
use App\Database\DB;

$validate = new Validate();
$response = $validate->validate([
    'id' => 'required|number'
]);
if ($response || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: $_SERVER[HTTP_REFERER]");
} else {
    $request = new Request();
    DB::table('reports')->where('id', $request->id)->delete();
    session_start();
    $_SESSION['status'] = true;
    header("Location: $_SERVER[HTTP_REFERER]");
}

