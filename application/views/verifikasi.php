<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AR Kacamata</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?= base_url("assets/bootstrap/css/bootstrap.min.css")?>">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="<?= base_url("assets/plugins/datatables/dataTables.bootstrap.css")?>">
	<link rel="stylesheet" href="<?= base_url("assets/dist/css/AdminLTE.min.css")?>">
	<link rel="stylesheet" href="<?= base_url("assets/dist/css/skins/_all-skins.min.css")?>">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script src="<?= base_url("assets/plugins/jQuery/jQuery-2.1.4.min.js")?>"></script>
	<script src="<?= base_url("assets/plugins/jQueryUI/jquery-ui.min.js")?>"></script>
	<script src="<?= base_url('assets/plugins/jquery-validation-1.15.0/dist/jquery.validate.js')?>" type="text/javascript"></script>
	<script src="<?= base_url("assets/bootstrap/js/bootstrap.min.js")?>"></script>
	<script src="<?= base_url("assets/plugins/datatables/jquery.dataTables.min.js")?>"></script>
	<script src="<?= base_url("assets/plugins/datatables/dataTables.bootstrap.min.js")?>"></script>

	<script src="<?= base_url("assets/plugins/slimScroll/jquery.slimscroll.min.js")?>"></script>
	<script src="<?= base_url("assets/plugins/fastclick/fastclick.min.js")?>"></script>
	<script src="<?= base_url("assets/dist/js/app.min.js")?>"></script>
	<script src="<?= base_url("assets/dist/js/demo.js")?>"></script>
</head>
<body class="hold-transition skin-green layout-top-nav">
<div class="wrapper">
	<header class="main-header">
		<nav class="navbar navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<a href="<?= base_url(); ?>">
						<div class="navbar-brand">
							<b>AR Kacamata</b>
						</div>
					</a>
				</div>
		</nav>
	</header>
	<div class="content-wrapper">
		<section class="content connectedSortable">
			<div class="row">
				<div class="col-sm-12 col-md-4 col-md-offset-4">
					<?php echo $this->session->flashdata('info');?>
				</div>
			</div>
		</section>
	</div>
	<footer class="main-footer">
		<div class="pull-right hidden-xs">
			<b>Version</b> 1.0
		</div>
		<strong>Copyright &copy; 2020 <a href="<?= base_url();?>">AR Kacamata </a>.</strong> All rights reserved.
	</footer>
</div>
</body>
</html>
