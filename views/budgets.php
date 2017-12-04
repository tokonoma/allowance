<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">

            <?php include('views/alerts.php');?>

            <!-- HEADER BAR -->
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header pull-left">
                        <span class="navbar-brand">
                            BUDGETS <span class="badge reorder-badge">saving</span>
                        </span>
                    </div>
                    <div class="navbar-header pull-right">
                        <ul class="nav navbar-nav navbar-right navbar-right-button-end">
                            <li>
                                <button type="button" class="btn allw-success navbar-btn new-item-btn" data-toggle="modal" data-target="#new-budget-modal">
                                    New Budget
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
            <ul id="item-list" class="list-unstyled">

                <?php foreach($budgets as $budget): ?>
                <li class="budget-table table-parent" data-uid="<?php echo $budget['uid']?>" data-name="<?php echo $budget['name']?>">
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
                                    <?php if($budget['refillamount'] > 0): ?>
                                        <div class="half-badge half-badge-left refill-badge">
                                            <i class="fa fa-repeat" aria-hidden="true"></i>
                                        </div><div class="half-badge half-badge-right refill-badge">
                                            <?php
                                                $refillamount = $budget['refillamount'];
                                                echo "$".number_format(($refillamount/100), 2, '.', ',')."/".$budget['refillfrequency'];
                                            ?>
                                        </div>
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
                                }
                        </div>
                    </a>
                    <div class="budget-spacing-column table-cell"></div>
                    <div class="budget-deduct-btn table-cell table-cell-vcenter text-center">
                        <a href="">
                            <i class="fa fa-chevron-circle-down fa-4x" aria-hidden="true"></i>
                        </a>
                    </div>
                </li>
                <?php endforeach; ?>

            </ul>
        </div> <!-- /col -->
    </div> <!-- /row -->

</div> <!-- /container -->

