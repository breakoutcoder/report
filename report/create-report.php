<?php
include 'vendor/autoload.php';
session_start()
?>
<?php include "header.php";?>
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background-color:#a291fb;color:white;font-weight: 700">Create Report
                    <a href="<?php echo url('index.php')?>" class="btn btn-info float-right">View
                        Reports</a>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['status'])):
                        unset($_SESSION['status']);
                        ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Your report has been successfully added!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php
                    endif;
                    ?>
                    <form action="<?php echo url('store-report.php')?>" method="post" id="report">
                        <div class="form-group">
                            <label for="buyer">Buyer <span class="required">*</span></label>
                            <input type="text" id="buyer" name="buyer" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="items">Items<span class="required">*</span></label>
                            <input type="text" id="items" name="items" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount<span class="required">*</span></label>
                            <input type="text" id="amount" name="amount" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="receipt_id">Receipt Id<span class="required">*</span></label>
                            <input type="text" id="receipt_id" name="receipt_id" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="buyer_email">Buyer Email<span class="required">*</span></label>
                            <input type="text" id="buyer_email" name="buyer_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone<span class="required">*</span></label>
                            <input type="text" id="phone" name="phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="city">City<span class="required">*</span></label>
                            <input type="text" id="city" name="city" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="entry_by">Entry By<span class="required">*</span></label>
                            <input type="text" id="entry_by" name="entry_by" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="note">Note<span class="required">*</span></label>
                            <textarea id="note" name="note" class="form-control" rows="4"></textarea>
                        </div>
                        <button type="submit" class="button">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'?>