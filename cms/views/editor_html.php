<div class="container">
    <div class="row">
        <div class="col-md-12">
           
            <?php
                if (!empty($statusMessage)){
                    echo "<div id='' class='alert alert-" . $statusType . " notif-alert' role='alert'>". $statusMessage . "</div>";
                }
            ?>

            <!--BREADCRUMB-->
            <ol class="breadcrumb">
                <li><a href='<?php echo $baseurl ?>'>Pages</a></li>
                <li><a href='<?php echo "$baseurl?mode=list&pid=$pid"; ?>'><?php echo $thispgtitle; ?></a></li>
                <li><a href='<?php echo "$baseurl?mode=list&pid=$pid&sid=$sid"; ?>'><?php echo $thissectitle; ?></a></li>
                <li class="active"><?php echo $pageheader ?></li>
            </ol>

            <!-- HEADER BAR -->
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header pull-left">
                        <span class="navbar-brand"><?php echo $pageheader; ?></span>
                    </div>
                    <div class="navbar-header pull-right">
                        <ul class="nav navbar-nav navbar-right navbar-right-button-end">
                            <li>
                                <button type="button" class="btn btn-success navbar-btn submit-btn">Save</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!--PAGE CONTENT-->
            <!-- <h3 class="header-margin"></h3> -->
            <form id="content-form" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
                <div class="form-group">
                    <label for="title-input" class="sr-only">Section Header</label>
                    <input type="text" class="form-control" id="title-input" name="title-input" placeholder="Section Header" autocomplete="off" value="<?php echo $title ?>">
                </div>
                <div class="form-group">
                    <label for="body-input" class="sr-only">Body Content</label>
                    <textarea id="body-input" name="body-input" autocomplete="off"><?php echo $body ?></textarea>
                </div>
            </form>
        </div> <!-- /col -->
    </div> <!-- /row -->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading preview-header clickable">
                    Preview
                    <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
                    <span class="glyphicon glyphicon-chevron-up pull-right hidden" aria-hidden="true"></span>
                </div>
                <div class="panel-body preview-body hidden">
                    <h3><?php echo $title ?></h3>
                    <?php echo $body ?>
                </div>
            </div>
        </div> <!-- /col -->
    </div> <!-- /row -->

</div> <!-- /container -->