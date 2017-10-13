<?php

	if(isset($_GET['tab'])){
		$activetab = $_GET['tab'];
	}
	else{
		$activetab = "pages";
	}

	$admintabs = array(
		"pages"=>array(
			"label"=>"Pages",
			"icon"=>"sitemap"),
		"dashboard"=>array(
			"label"=>"Dashboard",
			"icon"=>"pie-chart"), 
		"siteconfig"=>array(
			"label"=>"Site Settings",
			"icon"=>"sliders"), 
		"useradmin"=>array(
			"label"=>"Users",
			"icon"=>"user-circle-o")
	);

?>


<div class=container>
	<div class="row">
		<div class="col-md-12 header-margin">

			<ul class="nav nav-tabs">

				<?php foreach ($admintabs as $param => $paramarray): ?>

					<?php 
						if($activetab == $param){
							$activeclass = "active";
							$taburl = "#";
						}
						else{
							$activeclass = "";
							$taburl = $baseurl."?tab=".$param;
						}
					?>

					<li role="presentation" class="<?php echo $activeclass; ?> hidden-xs">
					 	<a href="<?php echo $taburl; ?>">
					 		<i class="fa fa-<?php echo $paramarray['icon']; ?>" aria-hidden="true"></i>
					 		&nbsp;&nbsp;<?php echo $paramarray['label']; ?>
					 	</a>
					</li>

				<?php endforeach; ?>

				<li role="presentation" class="dropdown visible-xs-block">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						Admin Tools <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">

						<?php foreach ($admintabs as $param => $paramarray): ?>

							<?php 
								if($activetab == $param){
									$activeclass = "active";
									$taburl = "#";
								}
								else{
									$activeclass = "";
									$taburl = $baseurl."?tab=".$param;
								}
							?>

							<li role="presentation" class="<?php echo $activeclass; ?>">
							 	<a href="<?php echo $taburl; ?>">
							 		<i class="fa fa-<?php echo $paramarray['icon']; ?>" aria-hidden="true"></i>
							 		&nbsp;&nbsp;<?php echo $paramarray['label']; ?>
							 	</a>
							</li>

						<?php endforeach; ?>

					</ul>
				</li>

			</ul>

		</div> <!--/col-->
	</div> <!--/row-->
</div> <!--/container-->