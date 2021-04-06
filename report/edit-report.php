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
    <?php session_start() ?>
    <?php include 'header.php'?>
    <div class="container mt-4 mb-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="background-color:#a291fb;color:white;font-weight: 700">Edit Report
                        <div style="float: right">
                            <a href="<?php echo url("view-report.php?id=$report->id")?>" class="btn btn-dark btn-sm">View</a>
                            <a href="<?php echo url('index.php')?>" class="btn btn-info btn-sm">View Report Lists</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION['status'])):
                            unset($_SESSION['status']);
                            ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Your report has been successfully updated!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php
                        endif;
                        ?>
                        <form action="<?php echo url('update-report.php')?>" method="post" id="report">
                            <input type="hidden" name="id" value="<?php echo $report->id?>">
                            <div class="form-group">
                                <label for="buyer">Buyer <span class="required">*</span></label>
                                <input type="text" id="buyer" name="buyer" class="form-control"
                                       value="<?php echo $report->buyer ?>">
                            </div>
                            <div class="form-group">
                                <label for="items">Items<span class="required">*</span></label>
                                <input type="text" id="items" name="items" class="form-control"
                                       value="<?php echo $report->items ?>">
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount<span class="required">*</span></label>
                                <input type="text" id="amount" name="amount" class="form-control"
                                       value="<?php echo $report->amount ?>">
                            </div>
                            <div class="form-group">
                                <label for="receipt_id">Receipt Id<span class="required">*</span></label>
                                <input type="text" id="receipt_id" name="receipt_id" class="form-control"
                                       value="<?php echo $report->receipt_id ?>">
                            </div>
                            <div class="form-group">
                                <label for="buyer_email">Buyer Email<span class="required">*</span></label>
                                <input type="text" id="buyer_email" name="buyer_email" class="form-control"
                                       value="<?php echo $report->buyer_email ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone<span class="required">*</span></label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                       value="<?php echo $report->phone ?>">
                            </div>
                            <div class="form-group">
                                <label for="city">City<span class="required">*</span></label>
                                <input type="text" id="city" name="city" class="form-control"
                                       value="<?php echo $report->city ?>">
                            </div>
                            <div class="form-group">
                                <label for="entry_by">Entry By<span class="required">*</span></label>
                                <input type="text" id="entry_by" name="entry_by" class="form-control"
                                       value="<?php echo $report->entry_by ?>">
                            </div>
                            <div class="form-group">
                                <label for="note">Note<span class="required">*</span></label>
                                <textarea id="note" name="note" class="form-control"
                                          rows="4"><?php echo $report->note ?></textarea>
                            </div>
                            <button type="submit" class="button">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'?>
<?php
endif;
