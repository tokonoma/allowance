<?php include('partials/settings_logic.php'); ?>


<!--HTML INCLUDES-->

<?php include('partials/cms_header.php'); ?>

<?php include('partials/nav.php'); ?>

<?php include('partials/settings_html.php'); ?>


<!--BOTTOM-->

<?php include('partials/commonjs.php'); ?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<input type='hidden' id="listnoun" value="<?php echo $listnoun ?>">
<script src="../assets/js/marian.js"></script>

<script>
    $(function() {
        $(".save-settings-btn").click(function(){
            document.getElementById("settings-form").submit();
        });
    })
</script>

<?php include('partials/ender.php'); ?>