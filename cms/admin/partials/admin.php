<?php include('partials/admin_header.php'); ?>


<!--HTML INCLUDES-->

<?php include('../partials/nav.php'); ?>

<div class=container>
	<div class="row">
		<div class="col-md-12 header-margin">

			<ul class="nav nav-tabs">
			    <li role="presentation" class="active"><a href="#"><i class="fa fa-sitemap" aria-hidden="true"></i></i>&nbsp;&nbsp;Pages</a></li>
			    <li role="presentation"><a href="#"><i class="fa fa-pie-chart" aria-hidden="true"></i>&nbsp;&nbsp;Dashboard</a></li>
			    <li role="presentation"><a href="#"><i class="fa fa-sliders" aria-hidden="true"></i>&nbsp;&nbsp;Site Settings</a></li>
			    <li role="presentation"><a href="#"><i class="fa fa-user-circle-o" aria-hidden="true"></i>&nbsp;&nbsp;Users</a></li>
			</ul>

		</div> <!--/col-->
	</div> <!--/row-->
</div> <!--/container-->



<!--BOTTOM-->

<?php include('../partials/commonjs.php'); ?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="../../assets/js/sortable.js"></script>

<input type='hidden' id="listnoun" value="<?php echo $listnoun ?>">
<script src="../../assets/js/marian.js"></script>


<?php include('partials/ender.php'); ?>