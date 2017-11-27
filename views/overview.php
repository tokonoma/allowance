<?php include('views/header.php');?>

<?php include('views/nav.php'); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">

		<?php include('views/alerts.php');?>

		<?php include('views/wireframe.php'); ?>

		</div> <!-- /col -->
	</div> <!-- /row -->
</div> <!-- /container -->


<!-- temporary -->
<div class="container">
	<div class="row">
		<div class="col-md-12">
			
		<form id="serialize-form" method="POST" action="<?php echo $baseurl; ?>">
			<div class="form-group">
				<label for="title">Title</label>
				<input type="text" name="title" class="form-control" id="title" placeholder="Title">
			</div>
			<div class="form-group">
				<label for="contents">Contents</label>
				<textarea name="contents" class="form-control" rows="3" id="contents" placeholder="Contents"></textarea>
			</div>
			<div class="checkbox">
				<label>
					<input name="checkworked" type="checkbox"> Checkbox Test
				</label>
			</div>
			<button id="serialize-this" type="button" class="btn btn-primary ">Submit</button>
		</form>

		<form id="js-submit-form" method="POST" action="<?php echo $baseurl; ?>">
			<input id="serialuid" type="hidden" name="serialuid" value="">
			<input id="serialdata" type="hidden" name="serialdata" value="">
		</form>

		</div> <!-- /col -->
	</div> <!-- /row -->
</div> <!-- /container -->
<!-- temporary -->


<!--BOTTOM-->

<?php include('views/commonjs.php'); ?>

<script>
    $(function() {
        $('#serialize-this').click(function() {
            var serialdata = $('form#serialize-form').serialize();
            $('input#serialdata').val(serialdata);
            submitJSForm();
        });
    });
</script>

<?php include('views/ender.php'); ?>