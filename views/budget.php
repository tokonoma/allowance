<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12">

            <?php include('views/alerts.php');?>
            
            <ul id="item-list" class="list-unstyled">
                <?php foreach($thisbudget as $budget): ?>
                <li class="budget-table table-parent" id="budget<?php echo $budget['uid']?>">
                    <a href="<?php echo $baseurl.'?budget='.$budget['uid']?>" class="budget-data table-cell">
                        <div class="budget-data-padding">
                            <div class="budget-details table-cell">
                                <div class="budget-name">
                                    <?php echo $budget['name']; ?>
                                </div>
                                <div class="budget-balance tiny-balance">
                                    <?php
                                        $balance = $budget['balance'];
                                        echo "$".number_format(($balance/100), 2, '.', ',');
                                    ?>
                                </div>
                                <div class="budget-properties">
                                    <?php $refillamount = $budget['refillamount']; ?>
                                    <?php if($budget['autorefill'] == 1): ?>
                                        <div class="half-badge half-badge-left refill-badge">
                                            <i class="fa fa-repeat" aria-hidden="true"></i>
                                        </div><div class="half-badge half-badge-right refill-badge">
                                            <?php
                                                echo "$".number_format(($refillamount/100), 2, '.', ',')."/".$budget['refillfrequency'];
                                            ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge initial-badge">
                                            <?php
                                                echo "Started with $".number_format(($refillamount/100), 2, '.', ',');
                                            ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if($budget['shares'] > 0): ?>
                                        <span class="badge shares-badge">
                                            <i class="fa fa-user-plus" aria-hidden="true"></i><?php echo $budget['shares']?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="budget-balance table-cell table-cell-vcenter">
                                <?php
                                    echo "$".number_format(($balance/100), 2, '.', ',');
                                ?>
                            </div>
                        </div>
                        <div class="balance-health-bar-container">
                            <?php
                                $balancehealth = $balance/$refillamount*100;
                                if($balancehealth >= 66){
                                    $balancehealthhex = "#09A387";
                                }
                                elseif($balancehealth < 66 && $balancehealth > 33){
                                    $balancehealthhex = "#C6B40B";
                                }
                                else{
                                    $balancehealthhex = "#C6500B";
                                }
                            ?>
                            <?php if($balance < $refillamount): ?>
                                <div class="balance-health-bar" style="background: <?php echo $balancehealthhex?>; width: <?php echo $balancehealth."%"?>;"></div>
                            <?php else: ?>
                                <div class="balance-health-bar"></div>
                            <?php endif; ?>
                        </div>
                    </a>
                    <div class="budget-spacing-column table-cell"></div>
                    <div class="budget-deduct-btn-cell table-cell table-cell-vcenter text-center">
                        <button type="button" class="btn deduct-btn" data-toggle="modal" data-target="#budget-deduct-modal" data-uid="<?php echo $budget['uid']?>" data-name="<?php echo $budget['name']?>" data-balance="<?php echo $budget['balance']?>">
                            <i class="fa fa-chevron-circle-down fa-4x" aria-hidden="true"></i>
                        </button>
                    </div>
                </li>
                <?php endforeach; ?>

            </ul>
        </div> <!-- /col -->
    </div> <!-- /row -->
</div> <!-- /container -->


<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12">

            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Budget History</div>
                <!-- Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Withdraw/Deposit</th>
                            <th>User</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($budgettable as $budgettransaction): ?>
                        <tr>
                            <td><?php echo date("m/d/y", strtotime($budgettransaction['transactiondate']))?></td>
                            <td><?php echo $budgettransaction['name']?></td>
                            <td>
                                <?php echo "$".number_format(($budgettransaction['modifyamount']/100), 2, '.', ',')?>
                                
                            </td>
                            <td><?php echo $budgettransaction['user']?></td>
                            <td><?php echo "$".number_format(($budgettransaction['balance']/100), 2, '.', ',')?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div> <!-- /col -->
    </div> <!-- /row -->
</div> <!-- /container -->



