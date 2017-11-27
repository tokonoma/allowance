<?php

    //SECTIONS CONFIG
    $pid = $_GET['pid'];
    $listtitle="section";
    $listnoun="section";

    //printing the panel
    $itemtitleurl = $baseurl."?mode=list&pid=$pid&sid=";
    $terminalnode = false;
    
    //queries
    $dbtable = "sections";
    $createtable = "$dbtable (uid BIGSERIAL PRIMARY KEY, pid INTEGER, pos INTEGER, title TEXT, description TEXT)";
    $insertarray = array($pid);
    $insertprep = "$dbtable (pid, pos, title, description) VALUES (?, ?, ?, ?)";
    $dbgetdata = "$dbtable WHERE pid = $pid";

    //needs to be included in top because of the header location func
    include('partials/listbuilder_logic.php');
    
?>


<!--HTML INCLUDES-->

<?php include('partials/cms_header.php'); ?>

<?php include('partials/modals_list.php'); ?>

<?php include('partials/nav.php'); ?>

<?php include('partials/listbuilder_html.php'); ?>


<!--BOTTOM-->

<?php include('partials/commonjs.php'); ?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="../assets/js/sortable.js"></script>

<input type='hidden' id="listnoun" value="<?php echo $listnoun ?>">
<script src="../assets/js/marian.js"></script>

<?php include('partials/ender.php'); ?>