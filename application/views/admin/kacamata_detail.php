<section class="content-header">
	<h1>
		Dashboard
		<small>Kacamata Detail</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?= base_url('Admin/kacamata'); ?>"><i class="fa fa-users"></i> Kacamata</a></li>
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
						<h3 class="box-title">Detail Kacamata</h3>
					</div>
					<div class="box-body">
						<center>
							<img src="<?= base_url('assets/upload/kacamata/'.$dt->foto_kacamata);?>" class="img-responsive img-rounded" style="width:250px;"/>
						</center>
						<div class="form-group">
							<label for="nama_kacamata">Nama Kacamata</label>
							<input type="text" class="form-control" id="nama_kacamata" name="nama_kacamata" placeholder="Masukan Nama  Kacamata" value="<?= $dt->nama_kacamata; ?>" disabled>
						</div>
						<div class="form-group">
							<label for="nama_kategori">Nama Kategori</label>
							<input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Masukan Nama Kategori" value="<?= $dt->nama_kategori; ?>" disabled>
						</div>
						<div class="form-group">
							<label for="harga_kacamata">Harga Kacamata</label>
							<input type="text" class="form-control" id="harga_kacamata" name="harga_kacamata" placeholder="Masukan Harga  Kacamata" value="Rp <?= number_format($dt->harga_kacamata); ?>" disabled>
						</div>
						<div class="form-group">
							<label for="deskripsi_kacamata">Deskripsi Kacamata</label>
							<textarea class="form-control" id="deskripsi_kacamata" name="deskripsi_kacamata" rows="5 " disabled><?= $dt->deskripsi_kacamata; ?></textarea>
						</div>
					</div>
					<div class="box-footer">
						<a href="<?= base_url('Admin/kacamata_edit/'.$dt->id_tb_kacamata); ?>" class="btn btn-primary pull-right" style="margin: 1px;">Edit Profil</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
