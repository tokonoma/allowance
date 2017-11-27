<?php

    //SUBSECTIONS CONFIG
    $pid = $_GET['pid'];
    $sid = $_GET['sid'];
    $listtitle="subsections";
    $listnoun="subsection";

    //printing the panel
    $terminalnode = true;
    
    //queries
    $dbtable = "content";
    $createtable = "$dbtable (uid BIGSERIAL PRIMARY KEY, pid INTEGER, sid INTEGER, pos INTEGER, title TEXT, body TEXT)";
    $insertarray = array($pid, $sid);
    $insertprep = "$dbtable (pid, sid, pos, title, description) VALUES (?, ?, ?, ?, ?)";
    $dbgetdata = "$dbtable WHERE sid = $sid";

    //needs to be included in top because of the header location func
    include('partials/listbuilder_logic.php');
    
?>


<!--HTML INCLUDES-->

<?php include('partials/cms_header.php'); ?>

<?php include('partials/modals_list.php'); ?>

<?php include('partials/nav.php'); ?>

<?php include('partials/listbuilder_html.php'); ?>


<!--BOTTOM-->

<!--make PHP variables accessible to JS-->

<?php include('partials/commonjs.php'); ?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="../assets/js/sortable.js"></script>

<input type='hidden' id="listnoun" value="<?php echo $listnoun ?>">
<script src="../assets/js/marian.js"></script>

<?php include('partials/ender.php'); ?>