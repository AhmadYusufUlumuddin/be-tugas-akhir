<section class="content-header">
	<h1>
		Dashboard
		<small>Kategori Tambah</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?= base_url('Admin/kategori'); ?>"><i class="fa fa-users"></i> Kategori</a></li>
		<li class="active">Tambah</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->session->flashdata('info');?>
			<div class="box">
				<form id="formValidate" class="formValidate" action="<?= base_url('Admin/kategori_tambah_execute');?>" method="post" enctype="multipart/form-data">
					<div class="box-header">
						<h3 class="box-title">Tambah Kategori</h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label for="username">Foto</label>
							<input type="file" class="form-control" id="foto" name="foto" placeholder="Masukan foto" accept=".png, .jpg, .jpeg">
						</div>
						<div class="form-group">
							<label for="nama_kategori">Nama Kategori</label>
							<input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Masukan Nama Kategori">
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
                nama_kategori: { required: true, },
                password: { required: true, },
            },
            messages: {
                foto: { required: "Silahkan diisi...", },
                nama_kategori: { required: "Silahkan diisi...", },
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
