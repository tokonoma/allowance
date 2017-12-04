<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
            <ul id="item-list" class="list-unstyled">

                <?php foreach($budget as $budgetinfo): ?>
                <li class="budget-table table-parent" data-uid="<?php echo $budget['uid']?>">
                    <?php echo $budgetinfo['name']?><br>
                    <?php echo $budgetinfo['refillfrequency']?><br>
                    <?php echo $budgetinfo['refillamount']?><br>
                </li>
                <?php endforeach; ?>

            </ul>
        </div> <!-- /col -->
    </div> <!-- /row -->
</div> <!-- /container -->


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">

            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Transaction History</div>
                <!-- Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Balance</th>
                            <th>User</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($budgettable as $budgettransaction): ?>
                        <tr>
                            <td><?php echo $budgettransaction['balance']?></td>
                            <td><?php echo $budgettransaction['user']?></td>
                            <td><?php echo $budgettransaction['name']?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div> <!-- /col -->
    </div> <!-- /row -->
</div> <!-- /container -->



