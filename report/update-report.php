<?php

require 'vendor/autoload.php';

use App\Request;
use App\Validate;
use App\Database\DB;

$validate = new Validate();
$response = $validate->validate([
    'id' => 'required|number',
    'buyer' => 'required|max:20',
    'items' => 'required|max:255',
    'amount' => 'required|number|max:10',
    'receipt_id' => 'required|max:20',
    'buyer_email' => 'required|max:50|email',
    'phone' => 'required|number|max:20',
    'city' => 'required|max:20',
    'entry_by' => 'required|max:10',
    'note' => 'required|maxWord:30',
]);
if ($response) {
    header("Location: $_SERVER[HTTP_REFERER]");
} else {
    $request = new Request();
    DB::table('reports')->where('id', $request->id)->update([
        'amount' => $request->amount,
        'buyer' => $request->buyer,
        'receipt_id' => $request->receipt_id,
        'items' => $request->items,
        'buyer_email' => $request->buyer_email,
        'buyer_ip' => ipAddress(),
        'note' => $request->note,
        'city' => $request->city,
        'phone' => $request->phone,
        'entry_at' => date("Y-m-d"),
        'entry_by' => $request->entry_by
    ]);
    session_start();
    $_SESSION['status'] = true;
    header("Location: $_SERVER[HTTP_REFERER]");
}

