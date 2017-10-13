<div class="container">
    <div class="row">

        <?php
            if (!empty($statusMessage)){
                echo "<div id='' class='alert alert-" . $statusType . " notif-alert' role='alert'>";
                echo $statusMessage;
                echo "</div>";
            }
        ?>

        <div class="col-sm-4 text-center hidden-xs">
            <i class="fa fa-user-circle-o profile-icon" aria-hidden="true"></i>
        </div>

        <div class="col-sm-8">

            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <span class="navbar-brand">User Settings</span>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <button type="button" class="btn btn-success navbar-btn save-settings-btn">Save Changes</button>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>

            <form id="settings-form" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">

                <?php foreach($results as $user): ?>

                    <div class="form-group">
                        <label for="titleinput">Email</label>
                        <input type="text" class="form-control" id="user-email" name="user-email" placeholder="email" autocomplete='off' value="<?php echo $user['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="titleinput">First Name</label>
                        <input type="text" class="form-control" id="first-name" name="first-name" placeholder="title" autocomplete='off' value="<?php echo $user['fname']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="titleinput">Last Name</label>
                        <input type="text" class="form-control" id="last-name" name="last-name" placeholder="title" autocomplete='off' value="<?php echo $user['lname']; ?>">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="titleinput">Change Password</label>
                        <input type="password" class="form-control" id="password-one" name="password-one" placeholder="Enter new password" autocomplete='off' value="">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password-two" name="password-two" placeholder="Confirm new password" autocomplete='off'>
                    </div>

                <?php endforeach; ?>

            </form>
            
        </div>

    </div> <!--/row-->
</div> <!--/container-->