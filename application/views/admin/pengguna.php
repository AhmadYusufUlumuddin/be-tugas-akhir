<section class="content-header">
	<h1>
		Dashboard
		<small>Pengguna</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li class="active">Pengguna</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $this->session->flashdata('info');?>
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Daftar Pengguna</h3>
					<a href="<?= base_url('Admin/pengguna_tambah'); ?>" class="btn btn-primary pull-right">Tambah</a>
				</div>
				<div class="box-body">
					<table id="dt_table" class="table table-bordered table-striped">
						<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Jenis Kelamin</th>
							<th>Tanggal</th>
							<th>Aksi</th>
						</tr>
						</thead>
						<tbody>
						<?php $no=0; foreach ($dt as $itm): $no++;?>
							<tr>
								<td><?= $no; ?>.</td>
								<td><a href="<?= base_url('Admin/penggua_detail/'.$itm->id_tb_pengguna) ?>"><?= $itm->nama; ?></a></td>
								<td><?= $itm->jenis_kelamin; ?></td>
								<td><?= $itm->create_date; ?></td>
								<td>
									<a href="<?= base_url('Admin/pengguna_edit/'.$itm->id_tb_pengguna) ?>" class="btn btn-primary btn-block">Edit</a>
									<a href="<?= base_url('Admin/pengguna_hapus_execute/'.$itm->id_tb_pengguna) ?>" class="btn btn-danger btn-block" onclick="return confirm('apakah anda yakin?')">Hapus</a>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
    $(function () {
        $('#dt_table').DataTable();
    });
</script>
