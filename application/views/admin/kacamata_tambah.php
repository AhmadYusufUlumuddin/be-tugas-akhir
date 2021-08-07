<section class="content-header">
	<h1>
		Dashboard
		<small>Kacamata Tambah</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?= base_url('Admin/kacamata'); ?>"><i class="fa fa-users"></i> Kacamata</a></li>
		<li class="active">Tambah</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->session->flashdata('info');?>
			<div class="box">
				<form id="formValidate" class="formValidate" action="<?= base_url('Admin/kacamata_tambah_execute');?>" method="post" enctype="multipart/form-data">
					<div class="box-header">
						<h3 class="box-title">Tambah Kacamata</h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label for="username">Foto</label>
							<input type="file" class="form-control" id="foto" name="foto" placeholder="Masukan foto" accept=".png, .jpg, .jpeg">
						</div>
						<div class="form-group">
							<label for="username">File 3D</label>
							<input type="file" class="form-control" id="file" name="file" placeholder="Masukan File 3D" accept=".sfb">
						</div>
						<div class="form-group">
							<label for="nama_kacamata">Nama Kacamata</label>
							<input type="text" class="form-control" id="nama_kacamata" name="nama_kacamata" placeholder="Masukan Nama Kacamata">
						</div>
						<div class="form-group">
							<label for="kategori_kacamata">Kategori Kacamata</label>
							<select class="form-control" id="kategori_kacamata" name="kategori_kacamata">
								<?php foreach ($kategori as $item):?>
								<option value="<?= $item->id_tb_kategori; ?>"><?= $item->nama_kategori; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label for="harga_kacamata">Harga Kacamata</label>
							<input type="text" class="form-control" id="harga_kacamata" name="harga_kacamata" placeholder="Masukan Harga Kacamata">
						</div>
						<div class="form-group">
							<label for="deskripsi_kacamata">Deskripsi Kacamata</label>
							<textarea type="text" class="form-control" id="deskripsi_kacamata" name="deskripsi_kacamata" placeholder="Masukan Deskripsi Kacamata" rows="5"></textarea>
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
                foto: { required: true, },
                file: { required: true, },
                nama_kacamata: { required: true, },
                kategori_kacamata: { required: true, },
                harga_kacamata: { required: true, digits: true, },
                deskripsi_kacamata: { required: true, },
            },
            messages: {
                foto: { required: "Silahkan diisi...", },
                file: { required: "Silahkan diisi...", },
                nama_kacamata: { required: "Silahkan diisi...", },
                kategori_kacamata: { required: "Silahkan diisi...", },
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
