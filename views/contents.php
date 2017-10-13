<div class="bs-docs-header custom" id=content tabindex=-1>
    <div class=container>

        <?php foreach($getthispage as $thispage): ?>

            <h1><?php echo $thispage['title']; ?></h1>
            <p class='custom'><?php echo $thispage['description']; ?></p>

        <?php endforeach; ?>

    </div>
</div>

<!--MAIN CONTENT-->
<div class="container bs-docs-container">
    <?php
        if (!empty($statusMessage)){
            echo "<div id='' class='alert alert-" . $statusType . " notif-alert' role='alert'>";
            echo $statusMessage;
            echo "</div>";
        }
    ?>
    <div class=row>
        <!--CONTENT-->
        <div class=col-md-9 role=main>
        
            
            <?php foreach($sectionsarr as $section): ?>

                <div class=bs-docs-section>
                    <h1 class=page-header id="sec<?php echo $section['sid']; ?>"><?php echo $section['title']; ?></h1>
                    <p class=lead><?php echo $section['desc']; ?></p>

                    <?php $sid = $section['sid']; ?>
                    <?php
                        foreach(${"subsections".$sid} as $subsection){
                            echo "<h2 id='sub".$subsection['uid']."'>".$subsection['title']."</h2>";
                            echo base64_decode($subsection['body']);
                        }
                    ?>
                
                </div>

            <?php endforeach; ?>
              
        </div><!-- /col -->        


        <!--TOC-->
        <div class=col-md-3 role=complementary>
            <nav class="bs-docs-sidebar hidden-print hidden-sm hidden-xs">
                <ul class="nav bs-docs-sidenav">
                <?php foreach($sectionsarr as $section): ?>

                    <li><a href="#sec<?php echo $section['sid']; ?>"><?php echo $section['title']; ?></a>
                        <ul class=nav>
                        
                            <?php $sid = $section['sid']; ?>
                            <?php foreach(${"subsections".$sid} as $subsection): ?>

                                <li>
                                    <a href="#sub<?php echo $subsection['uid'] ?>"><?php echo $subsection['title']; ?></a>
                                </li>

                            <?php endforeach; ?>
                        </ul>
                    </li>

                <?php endforeach; ?>

                </ul> <a href=#top class=back-to-top> Back to top </a> </nav>
        </div> <!--toc end-->

    </div> <!--main row end-->
</div> <!--main container end-->

<!--FOOTER-->
<footer class=bs-docs-footer>
    <div class=container>
        <ul class=bs-docs-footer-links>
            <!--<li><a href="#">Link</a>
            </li>
            <li><a href="#">Link</a>
            </li>-->
        </ul>
        <p>Designed and built by Tim</p>
    </div>
</footer>