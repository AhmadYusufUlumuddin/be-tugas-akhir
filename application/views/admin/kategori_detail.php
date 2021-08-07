<section class="content-header">
	<h1>
		Dashboard
		<small>Kategori Detail</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?= base_url('Admin/kategori'); ?>"><i class="fa fa-users"></i> Kategori</a></li>
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
						<h3 class="box-title">Detail Kategori</h3>
					</div>
					<div class="box-body">
						<center>
							<img src="<?= base_url('assets/upload/kategori/'.$dt->foto_kategori);?>" class="img-responsive img-rounded" style="width:250px;"/>
						</center>
						<div class="form-group">
							<label for="nama">Nama Kategori</label>
							<input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Masukan Nama" value="<?= $dt->nama_kategori; ?>" disabled>
						</div>
					</div>
					<div class="box-footer">
						<a href="<?= base_url('Admin/kategori_edit/'.$dt->id_tb_kategori); ?>" class="btn btn-primary pull-right" style="margin: 1px;">Edit Kategori</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
