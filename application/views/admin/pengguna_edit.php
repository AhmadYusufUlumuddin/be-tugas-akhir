<section class="content-header">
	<h1>
		Dashboard
		<small>Pengguna Detail</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?= base_url('Admin/pengguna'); ?>"><i class="fa fa-users"></i> Pengguna</a></li>
		<li class="active">Edit</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->session->flashdata('info');?>
			<div class="box">
				<form id="formValidate" class="formValidate" method="post" action="<?= base_url('Admin/pengguna_edit_execute');?>">
					<div class="box-header">
						<h3 class="box-title">Edit Pengguna</h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label for="nama">Nama</label>
							<input type="hidden" id="id" name="id" value="<?= $dt->id_tb_pengguna; ?>">
							<input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama" value="<?= $dt->nama; ?>">
						</div>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="Masukan Username" value="<?= $dt->username; ?>">
						</div>
						<div class="form-group">
							<label for="jenis_kelamin">Jenis Kelamin</label>
							<select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
								<option value="<?= $dt->jenis_kelamin; ?>"><?= $dt->jenis_kelamin; ?></option>
								<option value="Laki-Laki">Laki-Laki</option>
								<option value="Perempuan">Perempuan</option>
							</select>
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
                username: { required: true, },
            },
            messages: {
                nama: { required: "Silahkan diisi...", },
                username: { required: "Silahkan diisi...", },
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
