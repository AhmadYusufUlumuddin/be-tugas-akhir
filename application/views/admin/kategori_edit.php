<section class="content-header">
	<h1>
		Dashboard
		<small>Kategori Detail</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?= base_url('Admin/kategori'); ?>"><i class="fa fa-users"></i> Kategori</a></li>
		<li class="active">Edit</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->session->flashdata('info');?>
			<div class="box">
				<form id="formValidate" class="formValidate" method="post" action="<?= base_url('Admin/kategori_edit_execute');?>" enctype="multipart/form-data">
					<div class="box-header">
						<h3 class="box-title">Edit Kategori</h3>
					</div>
					<div class="box-body">
						<center>
							<img src="<?= base_url('assets/upload/kategori/'.$dt->foto_kategori);?>" class="img-responsive img-rounded" style="width:250px;"/>
						</center>
						<div class="form-group">
							<label for="username">Foto</label>
							<input type="file" class="form-control" id="foto" name="foto" placeholder="Masukan foto" accept=".png, .jpg, .jpeg">
							<input type="hidden" class="form-control" id="foto_lama" name="foto_lama" value="<?= $dt->foto_kategori; ?>">
							<code>*) Silahkan pilih foto jika ingin merubah foto</code>
						</div>
						<div class="form-group">
							<label for="nama">Nama</label>
							<input type="hidden" id="id" name="id" value="<?= $dt->id_tb_kategori; ?>">
							<input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Masukan Kategori" value="<?= $dt->nama_kategori; ?>">
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
                nama: { required: true, },
            },
            messages: {
                nama: { required: "Silahkan diisi...", },
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
