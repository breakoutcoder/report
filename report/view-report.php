<?php
include 'vendor/autoload.php';

use App\Request;
use App\Database\DB;

$request = new Request();
if (!$request->has('id')):
    include '500.php';
elseif (DB::table('reports')->where('id', $request->id)->exists() == false):
    include '500.php';
else:
    $report = DB::table('reports')->where('id', $request->id)->first();
    ?>
    <?php include 'header.php'?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header" style="background-color:#a291fb;color:white;font-weight: 700">View Report
                        <div style="float: right">
                            <a href="<?php echo url("edit-report.php?id=$report->id") ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?php echo url('index.php')?>" class="btn btn-info btn-sm">View Report Lists</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td style="font-weight: 700">Buyer :-</td>
                                <td><?php echo $report->buyer ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700">Items :-</td>
                                <td><?php echo $report->items ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700">Amount :-</td>
                                <td><?php echo $report->amount ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700">Receipt Id :-</td>
                                <td><?php echo $report->receipt_id ?></td>
                            </tr>

                            <tr>
                                <td style="font-weight: 700">Entry By :-</td>
                                <td><?php echo $report->entry_by ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700">Buyer Email :-</td>
                                <td><?php echo $report->buyer_email ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700">Phone :-</td>
                                <td><?php echo $report->phone ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700">City :-</td>
                                <td><?php echo $report->city ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700">Note :-</td>
                                <td><?php echo $report->note ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700">Buyer Ip Address :-</td>
                                <td><?php echo $report->buyer_ip ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700">Entry At :-</td>
                                <td><?php echo $report->entry_at ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php";?>
<?php
endif;