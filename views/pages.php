<?php

    //PAGES CONFIG
    $listtitle="pages";
    $listnoun="page";

    //printing the panel
    $itemtitleurl = $baseurl."?mode=list&pid=";
    $terminalnode = false;

    //queries
    $dbtable = "pages";
    $createtable = "$dbtable (uid BIGSERIAL PRIMARY KEY, pos INTEGER, title TEXT, description TEXT)";
    $insertarray = array();
    $insertprep = "$dbtable (pos, title, description) VALUES (?, ?, ?)";
    $dbgetdata = $dbtable;

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