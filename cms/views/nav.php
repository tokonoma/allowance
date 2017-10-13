<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $baseurl; ?>">MARIAN CMS</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <!--<li class="active"><a href="#">Home</a></li>
                <li><a href="#">About</a></li>-->
            </ul>
            <ul class="nav navbar-nav navbar-right navbar-right-button-end">
                <li>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle navbar-btn link-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hi <?php if(!empty($_SESSION['username'])): ?> <?php echo $_SESSION['username'] ?> <?php else: ?> There <?php endif ?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="?mode=settings">Settings</a></li>
                            <li><a href="../">Back to Library</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="?session=logout">Logout</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<?php if(!empty($_SESSION['adminacc']) && $_GET['mode']!= "settings"): ?> 
    <?php include('partials/admin_tabs.php'); ?>
<?php endif ?>