<div class="container">
    <div class="row">
        <div class="col-md-12">

            <?php
                if (!empty($statusMessage)){
                    echo "<div id='' class='alert alert-" . $statusType . " notif-alert' role='alert'>";
                    echo $statusMessage;
                    echo "</div>";
                }
            ?>

            <?php if(isset($_GET['pid'])): ?>
                <ol class="breadcrumb">
                    <li><a href='<?php echo $baseurl."?mode=list" ?>'>Pages</a></li>
                    <?php echo $breadcrumb ?>
                </ol>
            <?php endif ?>

            <!-- HEADER BAR -->
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header pull-left">
                        <span class="navbar-brand">
                            <?php echo $pageheader; ?> <span class="badge reorder-badge">saving</span>
                        </span>
                    </div>
                    <div class="navbar-header pull-right">
                        <ul class="nav navbar-nav navbar-right navbar-right-button-end">
                            <li>
                                <?php if(isset($_GET['sid'])): ?>
                                    <p class="navbar-btn"><a href='<?php echo "$baseurl?mode=editor&pid=$pid&sid=$sid" ?>' class="btn btn-success launch-builder">New <?php echo ucfirst($listnoun); ?></a></p>
                                <?php else: ?>
                                    <button type="button" class="btn btn-success navbar-btn new-item-btn" data-toggle="modal" data-target="#new-edit-item-modal">New <?php echo ucfirst($listnoun); ?></button>
                                <?php endif ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="row">
                <div class="col-md-6">
                    <ul id="item-list" class="list-unstyled">
                        <?php foreach($results as $row): ?>
                            <li class='panel panel-default' data-uid="<?php echo $row['uid'] ?>" data-pos="<?php echo $row['pos'] ?>">
                                <div class='panel-heading'>
                                    <h3 class='panel-title'>
                                        <?php 
                                            if($terminalnode){
                                                echo $row['title'];
                                            }
                                            else{
                                                echo "<a href='".$itemtitleurl.$row['uid']."'>";
                                                echo $row['title'];
                                                echo " <span class='glyphicon glyphicon-menu-right' aria-hidden='true'>";
                                                echo "</a>";
                                            }
                                        ?>
                                        <span class='pull-right item-functions'>
                                            <?php 
                                                if($terminalnode){
                                                    echo "<a href='".$baseurl."?mode=editor&uid=".$row['uid']."'><span class='glyphicon glyphicon-pencil panel-btn launch-builder-btn' aria-hidden='true'></span></a>";
                                                }
                                                else{
                                                    echo "<span class='glyphicon glyphicon-pencil panel-btn edit-item-btn' aria-hidden='true' data-toggle='modal' data-target='#new-edit-item-modal'></span>";
                                                }
                                            ?>
                                            <span class='glyphicon glyphicon-trash panel-btn delete-item-btn' aria-hidden='true' data-toggle='modal' data-target='#delete-item-modal'></span>
                                            <span class='glyphicon glyphicon-menu-hamburger panel-btn move-btn' aria-hidden='true'></span>
                                        </span>
                                    </h3>
                                </div>
                                <div class='panel-body'>
                                    <?php echo $row['description']; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div> <!-- /nested col -->
            </div> <!-- /nested row -->
        </div> <!-- /col -->
    </div> <!-- /row -->

</div> <!-- /container -->