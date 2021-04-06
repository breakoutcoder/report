<?php
require 'vendor/autoload.php';

use App\Database\DB;
use App\Request;

session_start();

$request = new Request();
$search = $request->has('search') ? strlen($request->search) > 0 : false;
$page = $request->has('page') ? (is_numeric($request->page) ? $request->page : 1) : 1;
$limit = 10;
$start = ($page - 1) * $limit;
if ($search == true) {
    $sql = DB::table('reports')
        ->orWhere('buyer', 'LIKE', "%$request->search%")
        ->orWhere('items', 'LIKE', "%$request->search%")
        ->orWhere('amount', 'LIKE', "%$request->search%")
        ->orWhere('receipt_id', 'LIKE', "%$request->search%")
        ->orWhere('buyer_email', 'LIKE', "%$request->search%")
        ->orWhere('phone', 'LIKE', "%$request->search%")
        ->orWhere('city', 'LIKE', "%$request->search%")
        ->orWhere('entry_by', 'LIKE', "%$request->search%")
        ->orWhere('note', 'LIKE', "%$request->search%")
        ->query();
    $reports = DB::run()->limit(10, $start)->order('id', 'desc')->get($sql);
    $total = DB::run()->count($sql);
} else {
    $reports = DB::table('reports')->limit(10, $start)->order('id', 'desc')->get();
    $total = DB::table('reports')->count();
}
$pages = ceil($total / $limit);
$previous = $page - 1;
$next = $page + 1;
$lastSecond = $pages - 1
?>
<?php include 'header.php'?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color:#a291fb;color:white;font-weight: 700">
                    Report List
                    <a href="<?php echo url('create-report.php') ?>" class="btn btn-info float-right">Create Report</a>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['status'])):
                        unset($_SESSION['status']);
                        ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Your report has been successfully delete!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php
                    endif;
                    ?>
                    <div class="searchbody">
                        <form action="" method="get">
                            <input class="searchbody-input" type="text" placeholder="Search..." name="search"
                                   value="<?php echo $request->search ?>" autofocus>
                            <i class="fas fa-search icon" style="cursor: pointer"
                               onclick="this.closest('form').submit()"></i>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Buyer</th>
                                <th>Items</th>
                                <th>Buyer Email</th>
                                <th>Phone</th>
                                <th>Entry at</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($request->has('page')) {
                                $i = is_numeric($request->page) ? (($page * 10) - 9) : 1;
                            } else {
                                $i = 1;
                            }
                            ?>
                            <?php foreach ($reports as $report): ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td><?php echo $report->buyer ?></td>
                                    <td><?php echo $report->items ?></td>
                                    <td><?php echo $report->buyer_email ?></td>
                                    <td><?php echo $report->phone ?></td>
                                    <td><?php echo $report->entry_at ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo url("view-report.php?id=$report->id") ?>"
                                               class="btn btn-sm btn-info">View</a>
                                            <form action="<?php echo url('destroy-report.php') ?>" method="post"
                                                  onsubmit="return confirm('Are You Sure?')">
                                                <input type="hidden" name="id" value="<?php echo $report->id ?>">
                                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!--                        pagination-->
                    <div style="display: flex; overflow-x: auto">
                        <nav aria-label="Page navigation example" style="margin-left: auto">
                            <ul class="pagination">
                                <li class="page-item <?php echo $page == 1 ? 'disabled' : '' ?>"><a class="page-link"
                                                                                                    href="<?php echo url("index.php?page=$previous") ?>">Previous</a>
                                </li>
                                <!--                                condition one start-->
                                <?php if ($pages <= 9): ?>
                                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                                        <li class="page-item <?php echo $page == $i ? 'active' : '' ?>">
                                            <a class="page-link"
                                               href="<?php echo url("index.php?page=$i&search=$request->search") ?>"><?php echo $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <!--                                condition one end-->
                                    <!--                                condition two start-->
                                <?php elseif ($page <= 4): ?>
                                    <?php for ($i = 1; $i <= 7; $i++): ?>
                                        <li class="page-item <?php echo $page == $i ? 'active' : '' ?>">
                                            <a class="page-link"
                                               href="<?php echo url("index.php?page=$i&search=$request->search") ?>"><?php echo $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item"><a class="page-link">...</a></li>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?php echo url("index.php?page=$lastSecond&search=$request->search") ?>"><?php echo $lastSecond ?></a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?php echo url("index.php?page=$pages&search=$request->search") ?>"><?php echo $pages ?></a>
                                    </li>
                                    <!--                                condition two end-->
                                    <!--                                condition three start-->
                                <?php elseif ($page > 4 && $page < $pages - 4): ?>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?php echo url("index.php?page=1&search=$request->search") ?>">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?php echo url("index.php?page=1&search=$request->search") ?>">2</a>
                                    </li>
                                    <li class="page-item"><a class="page-link">...</a></li>
                                    <?php for ($i = $page - 2; $i <= $page + 2; $i++): ?>
                                        <li class="page-item <?php echo $page == $i ? 'active' : '' ?>">
                                            <a class="page-link"
                                               href="<?php echo url("index.php?page=$i&search=$request->search") ?>"><?php echo $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item"><a class="page-link">...</a></li>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?php echo url("index.php?page=$lastSecond&search=$request->search") ?>"><?php echo $lastSecond ?></a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?php echo url("index.php?page=$pages&search=$request->search") ?>"><?php echo $pages ?></a>
                                    </li>
                                    <!--                                condition three end-->
                                    <!--                                default condition start-->
                                <?php else: ?>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?php echo url("index.php?page=1&search=$request->search") ?>">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?php echo url("index.php?page=1&search=$request->search") ?>">2</a>
                                    </li>
                                    <li class="page-item"><a class="page-link">...</a></li>
                                    <?php for ($i = $pages - 6; $i <= $pages; $i++): ?>
                                        <li class="page-item <?php echo $page == $i ? 'active' : '' ?>">
                                            <a class="page-link"
                                               href="<?php echo url("index.php?page=$i&search=$request->search") ?>"><?php echo $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                <?php endif; ?>
                                <!--                                default condition end-->
                                <li class="page-item <?php echo $page == $pages ? 'disabled' : '' ?>"><a
                                            class="page-link"
                                            href="<?php echo url("index.php?page=$next&search=$request->search") ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!--                        pagination-->
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'?>