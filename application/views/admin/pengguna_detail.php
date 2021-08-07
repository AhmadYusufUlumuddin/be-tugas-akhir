<section class="content-header">
	<h1>
		Dashboard
		<small>Pengguna Detail</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?= base_url('Admin/pengguna'); ?>"><i class="fa fa-users"></i> Pengguna</a></li>
		<li class="active">Detail</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->session->flashdata('info');?>
			<div class="box">
				<form id="formValidate" class="formValidate">
					<div class="box-header">
						<h3 class="box-title">Detail Pengguna</h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label for="nama">Nama</label>
							<input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama" value="<?= $dt->nama; ?>" disabled>
						</div>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="Masukan Username" value="<?= $dt->username; ?>" disabled>
						</div>
						<div class="form-group">
							<label for="jenis_kelamin">Jenis Kelamin</label>
							<input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" placeholder="Masukan Jenis Kelamin" value="<?= $dt->jenis_kelamin; ?>" disabled>
						</div>
					</div>
					<div class="box-footer">
						<a href="<?= base_url('Admin/pengguna_edit/'.$dt->id_tb_pengguna); ?>" class="btn btn-primary pull-right" style="margin: 1px;">Edit Profil</a>
						<a href="<?= base_url('Admin/pengguna_reset_execute/'.$dt->id_tb_pengguna); ?>" class="btn btn-default pull-right" style="margin: 1px;" onclick="return confirm('Apakah anda yakin?')">Reset Password</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
