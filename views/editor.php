<?php include('partials/editor_logic.php'); ?>


<!--HTML INCLUDES-->

<?php include('partials/editor_header.php'); ?>

<?php include('partials/nav.php'); ?>
    
    <!-- from nav - original save <button type="button" class="btn btn-success navbar-btn submit-btn">Save</button>-->

<?php include('partials/editor_html.php'); ?>


<!--BOTTOM-->

<?php include('partials/commonjs.php'); ?>

<input type='hidden' id="listnoun" value=" ">
<script src="../assets/js/marian.js"></script>

<script>
    $(function() {
        var checkExist = setInterval(function() {
            if ($('.mce-notification-warning').length) {
                $(".mce-notification-warning").hide();
                clearInterval(checkExist);
            }
        }, 100);


        $(".submit-btn").click(function() {
            document.getElementById("content-form").submit();
        });

        //I need a tinymce solution for this so the style aren't getting saved to db
        $('table.table, .table tr, .table td, .table th').removeAttr('style');
    })

</script>

<?php include('partials/ender.php'); ?>