<?php

    try{

        //postgres for prod
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //delete tool
        //$deleteid = [val];
        //$db->exec("DELETE FROM [table] WHERE [col] = [val]");

        //add row tool
        // $input_email = "jlatimer@bna.com";
        // $input_password = "temp4jared";
        // $password_store = password_hash($input_password, PASSWORD_BCRYPT);
        // $input_fname = "Jared";
        // $input_lname = "Latimer";
        // $input_cms = 1;
        // $input_admin = 0;

        //FYI $checkpass = password_verify($inputpass, $storedpass) yields t or f for pw check

        // $insert = $db->prepare("INSERT INTO [table] (email, password, fname, lname, cms, admin) VALUES (?, ?, ?, ?, ?, ?)");
        // $insertarray = array($input_email, $password_store, $input_fname, $input_lname, $input_cms, $input_admin);
        // $insert->execute($insertarray); 

        //update row tool
        // $update = $db->prepare("UPDATE [table] SET title = :titleinput, body = :bodyinput WHERE uid = $uid");
        // $update->bindParam(':titleinput', $titleinput, PDO::PARAM_STR);
        // $update->bindParam(':bodyinput', $bodyinput, PDO::PARAM_STR);
        // $update->execute();

        //row delete tool
        //$db->exec("DELETE FROM [table] WHERE lname = [val]");

        $users = $db->query("SELECT * FROM users");

        // close the database connection
        $db = NULL;
    }
    catch(PDOException $e){
        $statusMessage = $e->getMessage();
        $statusType = "danger";
    }

?>

<!--HTML INCLUDES-->

<?php include('partials/cms_header.php'); ?>

<!-- modals -->
<div class="modal fade" id="new-edit-item-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title edit-new-title"></h4>
            </div>
            <div class="modal-body">
                <p>modal title</p>
                <form id="new-edit-item-form" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
                    <div class="form-group">
                        <label for="titleinput"><?php echo ucfirst($listnoun); ?> Title</label>
                        <input type="text" class="form-control" id="item-title-input" name="item-title-input" placeholder="title" autocomplete='off' autofocus>
                    </div>
                    <div class="form-group">
                        <label for="descinput"><?php echo ucfirst($listnoun); ?> Description</label>
                        <textarea class="form-control" id="item-desc-input" name="item-desc-input" placeholder="description"></textarea>
                        <input type="hidden" name="new-item-pos" value="">
                        <input type="hidden" name="edit-item-uid" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary submit-new-edit"></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--delete item modal-->
<div class="modal fade" id="delete-item-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">modal title</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>&quot;<span class="delete-title"></span>&quot;</strong></p>
                <form id="delete-item-form" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
                    <input type="hidden" name="delete-item-uid" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger submit-delete">Delete It!</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php include('partials/nav.php'); ?>

<!-- page body -->
<div class="container">
    <div class="row">
        <?php
            if (!empty($statusMessage)){
                echo "<div id='' class='alert alert-" . $statusType . " notif-alert' role='alert'>". $statusMessage . "</div>";
            }
        ?>

        <div class="col-md-6">

                <? foreach ($users as $user): ?>
                    <div class="panel panel-default">
                        <div class="panel-body">

                            <?php echo $user['email']; ?>
                            <br>
                            <?php echo $user['fname']; ?>
                        
                        </div>
                    </div>
                <? endforeach; ?>

            </div>

        </div>
    </div>
</div>


<!--BOTTOM-->

<?php include('partials/commonjs.php'); ?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="../assets/js/sortable.js"></script>

<input type='hidden' id="listnoun" value="<?php echo $listnoun ?>">
<script src="../assets/js/marian.js"></script>


<?php include('partials/ender.php'); ?>