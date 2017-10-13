<!--NAV BAR HEADER-->
<header class="bs-docs-nav navbar navbar-static-top" id=top>
    <div class=container>
        <div class=navbar-header>
            <button aria-controls=bs-navbar aria-expanded=false class="collapsed navbar-toggle" data-target=#bs-navbar data-toggle=collapse type=button>
                <span class=sr-only>Toggle navigation</span>
                <span class=icon-bar></span> 
                <span class=icon-bar></span>
                <span class=icon-bar></span>
            </button>
            
            <a href="<?php echo $baseurl; ?>" class="navbar-brand custom">BNA UI Kit</a>
        </div>
        <nav class="collapse navbar-collapse" id=bs-navbar>
            <ul class="nav navbar-nav custom">

                <?php
                    foreach($pages as $page){
                        $pageurl = $baseurl."?pid=".$page['uid'];
                        $pagetitle = $page['title'];
                        $pageuid = $page['uid'];
                        
                        if(($pageuid == $pid) && ((!isset($_GET['mode'])) && ($_GET['mode']!="settings"))){
                            echo "<li class='active'><a href='#'>$pagetitle</a></li>";
                        }
                        else{
                            echo "<li><a href='$pageurl'>$pagetitle</a></li>";
                        }
                    }

                    //temp code for components section

                    $compurl = $baseurl."?goto=components";
                    echo "<li><a href='$compurl'>Components</a></li>";
                    
                    //end temp code for components section
                ?>

            </ul>
            <ul class="nav navbar-nav navbar-right custom navbar-right-button-end">
                <li>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle navbar-btn link-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hi <?php if(!empty($_SESSION['username'])): ?> <?php echo $_SESSION['username'] ?> <?php else: ?> There <?php endif ?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="?mode=settings">Settings</a></li>
                            <?php if (!empty($_SESSION['cmsacc'])): ?>
                                <li><a href="cms/">Go to CMS</a></li>
                            <?php endif; ?>
                            <?php if (!empty($_SESSION['ipauth'])): ?>
                                <li><a href="?session=login">Login as Individual</a></li>
                            <?php endif; ?>
                            <li role="separator" class="divider"></li>
                            <li><a href="?session=logout">Logout</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</header>