<section class="content-header">
	<h1>
		Dashboard
		<small>Kacamata Detail</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?= base_url('Admin/kacamata'); ?>"><i class="fa fa-users"></i> Kacamata</a></li>
		<li class="active">Edit</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->session->flashdata('info');?>
			<div class="box">
				<form id="formValidate" class="formValidate" method="post" action="<?= base_url('Admin/kacamata_edit_execute');?>" enctype="multipart/form-data">
					<div class="box-header">
						<h3 class="box-title">Edit Kacamata</h3>
					</div>
					<div class="box-body">
						<center>
							<img src="<?= base_url('assets/upload/kacamata/'.$dt->foto_kacamata);?>" class="img-responsive img-rounded" style="width:250px;"/>
						</center>
						<div class="form-group">
							<label for="username">Foto</label>
							<input type="file" class="form-control" id="foto" name="foto" placeholder="Masukan foto" accept=".png, .jpg, .jpeg">
							<input type="hidden" class="form-control" id="foto_lama" name="foto_lama" value="<?= $dt->foto_kacamata; ?>">
							<code>*) Silahkan pilih foto jika ingin merubah foto</code>
						</div>
						<div class="form-group">
							<label for="username">File 3D</label>
							<input type="file" class="form-control" id="file" name="file" placeholder="Masukan File 3D" accept=".sfb">
							<input type="hidden" class="form-control" id="file_lama" name="file_lama" value="<?= $dt->file_3d; ?>">
							<code>*) Silahkan pilih foto jika ingin merubah file 3D</code>
						</div>
						<div class="form-group">
							<label for="nama">Nama Kacamata</label>
							<input type="hidden" id="id" name="id" value="<?= $dt->id_tb_kacamata; ?>">
							<input type="text" class="form-control" id="nama_kacamata" name="nama_kacamata" placeholder="Masukan Nama Kacamata" value="<?= $dt->nama_kacamata; ?>">
						</div>
						<div class="form-group">
							<label for="nama_kategori">Nama Kategori</label>
							<select class="form-control" id="nama_kategori" name="nama_kategori">
								<option value="<?= $dt->id_tb_kategori; ?>"><?= $dt->nama_kategori; ?></option>
								<?php foreach ($kategori as $item):?>
									<option value="<?= $item->id_tb_kategori; ?>"><?= $item->nama_kategori; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label for="harga_kacamata">Harga Kacamata</label>
							<input type="text" class="form-control" id="harga_kacamata" name="harga_kacamata" placeholder="Masukan Harga Kacamata" value="<?= $dt->harga_kacamata; ?>">
						</div>
						<div class="form-group">
							<label for="deskripsi_kacamata">Deskripsi Kacamata</label>
							<textarea class="form-control" id="deskripsi_kacamata" name="deskripsi_kacamata" placeholder="Masukan Deskripsi Kacamata" rows="5"><?= $dt->deskripsi_kacamata; ?></textarea>
						</div>
					</div>
					<div class="box-footer">
						<button type="button" class="btn btn-danger">Batal</button>
						<button type="submit" class="btn btn-primary" onclick="return confirm('apakah anda yakin?')">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script>
    $(function () {
        $("#formValidate").validate({
            rules: {
                nama_kacamata: { required: true, },
                nama_kategori: { required: true, },
                harga_kacamata: { required: true, digits: true, },
                deskripsi_kacamata: { required: true, },
            },
            messages: {
                nama_kacamata: { required: "Silahkan diisi...", },
                nama_kategori: { required: "Silahkan diisi...", },
                harga_kacamata: { required: "Silahkan diisi...", digits: "Hanya boleh angka...", },
                deskripsi_kacamata: { required: "Silahkan diisi...", },
            },
            errorElement: 'div',
            errorPlacement: function (error, element) {
                var placement = $(element).data('error');
                if (placement) { $(placement).append(error) }
                else { error.insertAfter(element); }
            }
        });
    });
</script>
