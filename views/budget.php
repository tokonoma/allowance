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
                            <th>
                                <span class="hidden-sm hidden-xs">Date</span>
                                <span class="hidden-md hidden-lg"><i class="fa fa-camera-retro"></i></span>
                            </th>
                            <th>
                                <span class="hidden-sm hidden-xs">Description</span>
                                <span class="hidden-md hidden-lg"><i class="fa fa-commenting"></i></span>
                            </th>
                            <th>
                                <span class="hidden-sm hidden-xs">Withdraw/Deposit</span>
                                <span class="hidden-md hidden-lg"><i class="fa fa-minus"></i>/<i class="fa fa-plus"></i></span>
                            </th>
                            <th>
                                <span class="hidden-sm hidden-xs">User</span>
                                <span class="hidden-md hidden-lg"><i class="fa fa-user"></i></span>
                            </th>
                            <th class="text-right" align="right">
                                <span class="hidden-sm hidden-xs">Balance</span>
                                <span class="hidden-md hidden-lg"><i class="fa fa-money"></i></span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($budgettable as $budgettransaction): ?>
                        <tr>
                            <td><?php echo date("m/d/y", strtotime($budgettransaction['transactiondate']))?></td>
                            <td>
                                <span class="hidden-xs">
                                    <?php echo $budgettransaction['name']?>
                                </span>
                                <span class="hidden-sm hidden-md hidden-lg">
                                    <div class="btn-group tool-tip-btn">
                                        <button type="button" class="btn btn-link btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li class="no-a-tag"><?php echo $budgettransaction['name']?></li>
                                        </ul>
                                    </div>
                                </span>
                            </td>
                            <td>
                                <?php
                                    $depositamount = $budgettransaction['deposit'];
                                    $withdrawamount = $budgettransaction['withdraw'];
                                    if($depositamount == 0 && $withdrawamount > 0){
                                        echo "<span class='withdraw-span'>-$".number_format(($withdrawamount/100), 2, '.', ',')."</span>";
                                    }
                                    elseif($depositamount > 0 && $withdrawamount == 0){
                                         echo "<span class='deposit-span'>+$".number_format(($depositamount/100), 2, '.', ',')."</span>";;
                                    }
                                    else{
                                        echo "-";
                                    }
                                ?>
                            </td>
                            <td>
                                <span class="hidden-xs">
                                    <?php echo $budgettransaction['user']?>
                                </span>
                                <span class="hidden-sm hidden-md hidden-lg">
                                    <div class="btn-group tool-tip-btn">
                                        <button type="button" class="btn btn-link btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li class="no-a-tag"><?php echo $budgettransaction['user']?></li>
                                        </ul>
                                    </div>
                                </span>
                            </td>
                            <td align="right"><?php echo "$".number_format(($budgettransaction['balance']/100), 2, '.', ',')?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div> <!-- /col -->
    </div> <!-- /row -->
</div> <!-- /container -->



