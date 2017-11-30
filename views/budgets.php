<?php

    $dashboarduser = $_SESSION['email'];
    
   try{
        //postgres for prod
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //new or edited item save
        /*
        if(isset($_POST['item-title-input']) && isset($_POST['item-desc-input'])){
                
            $itemtitle = $_POST['item-title-input'];
            $itemdesc = $_POST['item-desc-input'];
            $newitempos = $_POST['new-item-pos'];
            $edituid = $_POST['edit-item-uid'];

            // if new pos has value and edit uid is empty, add a NEW item to the db
            if(!empty($newitempos) && empty($edituid)){
                $insert = $db->prepare("INSERT INTO $insertprep");
                array_push($insertarray, $newitempos, $itemtitle, $itemdesc);
                $insert->execute($insertarray);
                $_SESSION['sessionalert'] = "itemcreated";
            }
            // if new pos is empty and edit uid has a value, UPDATE the item based on its UID
            elseif(!empty($edituid) && empty($newitempos)){
                $update = $db->prepare("UPDATE $dbtable SET title = :itemtitle, description = :itemdesc WHERE uid = $edituid");
                $update->bindParam(':itemtitle', $itemtitle, PDO::PARAM_STR);
                $update->bindParam(':itemdesc', $itemdesc, PDO::PARAM_STR);
                $update->execute();
                $_SESSION['sessionalert'] = "itemedited";
            }
            else{
                $statusMessage = "Error saving item";
                $statusType = "danger";
            }

            header("Location: ".$_SERVER['REQUEST_URI']);
            exit();

        }
        */

        //delete item
        /*
        if(isset($_POST['delete-item-uid'])){
            
            //always delete the central item
            $deleteUID = $_POST['delete-item-uid'];
            $db->exec("DELETE FROM $dbtable WHERE uid = $deleteUID;");

            if(isset($_GET['pid']) && !isset($_GET['sid'])){
                // PID with NO SID means it's a section
                $db->exec("DELETE FROM content WHERE sid = $deleteUID;");
            }
            elseif(!isset($_GET['pid']) && !isset($_GET['sid'])){
                // NO PID with NO SID means it's a page
                $db->exec("DELETE FROM content WHERE pid = $deleteUID;");
                $db->exec("DELETE FROM sections WHERE pid = $deleteUID;");
            }

            $_SESSION['sessionalert'] = "itemdeleted";

            header("Location: ".$_SERVER['REQUEST_URI']);
            exit();

        }
        */

        //generate content from query db
        $budgets = $db->query("SELECT * FROM budgets WHERE user = '$dashboarduser' ORDER BY uid ASC");

        //determine page header and breadcrumb
        /*
        if(isset($_GET['pid'])){
            $thispg = $db->query("SELECT title FROM pages WHERE uid = $pid");
            foreach($thispg as $row){
                $thispgtitle = $row['title'];
            }
            if(isset($_GET['sid'])){
                $thissec = $db->query("SELECT title FROM sections WHERE uid = $sid");
                foreach($thissec as $row){
                    $thissectitle = $row['title'];
                }
                $pageheader = "$thissectitle &nbsp; <small>SECTION</small>";
                $breadcrumb = "<li><a href='".$baseurl."?mode=list&pid=$pid'>$thispgtitle</a></li> <li class='active'>$thissectitle</li>";
            }
            else{
                $pageheader = "$thispgtitle &nbsp; <small>PAGE</small>";
                $breadcrumb = "<li class='active'>$thispgtitle</li>";
            }
        }
        else{
            $pageheader = "PAGES";
        }
        */

        //reordering save - called via ajax
        /*
        if(isset($_POST['moveuid']) && isset($_POST['movepos'])){
            $moveuid = $_POST['moveuid'];
            $movepos = $_POST['movepos'];

            $posupdate = $db->prepare("UPDATE $dbtable SET pos = :movepos WHERE uid = $moveuid");
            $posupdate->bindParam(':movepos', $movepos, PDO::PARAM_STR);
            $posupdate->execute();
        }
        */

        // close the database connection
        $db = NULL;
    }
    catch(PDOException $e){
        $statusMessage = $e->getMessage();
        $statusType = "danger";
    }

    // remove alert variable
    unset($_SESSION['sessionalert']);

?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- I stopped here -->

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

