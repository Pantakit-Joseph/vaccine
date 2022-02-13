<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>แก้ไข ข้อมูลการรับวัคซีนของผู้ปกครอง</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-fzff82+8pzHnwA1mQ0dzz9/E0B+ZRizq08yZfya66INZBz86qKTCt9MLU0NCNIgaMJCgeyhujhasnFUsYMsi0Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
	<?php
	$submit = $this->session->flashdata('submit');
	if (isset($submit)) {
		if ($submit->status === 1) {
	?>
			<script>
				Swal.fire({
					icon: 'success',
					title: 'Success',
					html: "<?= $submit->message ?>",
				})
			</script>
		<?php
		} else if ($submit->status === 0) {
		?>
			<script>
				Swal.fire({
					icon: 'error',
					title: 'Failed',
					html: "<?= $submit->message ?>",
				})
			</script>
	<?php
		}
		$this->session->unset_userdata('submit');
	}
	?>
	<script>
		function logoutConfirm() {
			Swal.fire({
				icon: 'warning',
				title: 'Logout',
				text: 'คุณต้องออกจากระบบหรือไม่',
				showCancelButton: true,
				confirmButtonText: 'ตกลง',
				cancelButtonText: 'ยกเลิก',
			}).then((result) => {
				if (result.isConfirmed) {
					window.location.replace("<?= site_url('auth/login') ?>");
				}
			})
		}
	</script>
	<div class="container">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" href="<?= site_url('vaccine_parent/edit'); ?>">แก้ไขประวัติการฉีดวัคซีนผู้ปกครอง</a>
			</li>

			<li class="nav-item ms-auto">
				<a class="nav-link disabled"><?= $users_std->firstname . ' ' . $users_std->lastname ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-danger" onclick="logoutConfirm()">Logout</a>
			</li>
		</ul>
		<form method="post" action="<?= site_url('vaccine_parent/editsubmit') ?>" enctype="multipart/form-data" class="was-validated">
			<div class="card">
				<div class="card-header">
					<h4><span style="color:red">(แก้ไข)</span> ข้อมูลการรับวัคซีนของผู้ปกครอง</h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<label for="name_parent" class="form-label">คำนำหน้า:</label>
							<select class="form-select" name="title" required>
								<option selected><?= $parent->title_parent ?></option>
								<option>นาย</option>
								<option>นาง</option>
								<option>นางสาว</option>
							</select>
							<div class="invalid-feedback">กรุณากรอกชื่อ</div>
						</div>
						<div class="col-md-4">
							<label for="name_parent" class="form-label">ชื่อ:</label>
							<input type="text" class="form-control" id="name_parent" value="<?= $parent->name_parent ?>" placeholder="ชื่อ" name="name_parent" required>
							<div class="invalid-feedback">กรุณากรอกชื่อ</div>
						</div>
						<div class="col-md-4">
							<label for="surname_parent" class="form-label">นามสกุล:</label>
							<input type="text" class="form-control" id="surname_parent" value="<?= $parent->surname_parent ?>" placeholder="นามสกุล" name="surname_parent" required>
							<div class="invalid-feedback">กรุณากรอกนามสกุล</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-floating">
								<select class="form-select" name="relation">
									<option selected><?= $parent->relation ?></option>
									<option value="บิดา">บิดา</option>
									<option value="มารดา">มารดา</option>
									<option value="อื่น ๆ">อื่น ๆ</option>
								</select>
								<label for="sel1" class="form-label">เกี่ยวข้องกับ (นักเรียน/นักศึกษา):</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-floating">
								<select class="form-select" id="getvacine" name="parent_vacine" required>
									<option value="<?= $parent->parent_vacine ?>" selected>
									<?php
									if ($parent->parent_vacine === '1') {
										echo 'ได้รับวัคซีนแล้ว';
									} elseif ($parent->parent_vacine === '0') {
										echo 'ยังไม่ได้รับวัคซีน';
									}
									?>
									</option>
									<option value="1">ได้รับวัคซีนแล้ว</option>
									<option value="0">ยังไม่ได้รับวัคซีน</option>
								</select>
								<label for="sel1" class="form-label">การรับวัคซีน(ผู้ปกครอง):</label>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-floating">
								<select class="form-select" id="num_vac" name="number_vacine">
									<option selected><?= $parent->number_vacine ?></option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>
								<label for="sel1" class="form-label">จำนวนวัคซีนที่ได้รับ (ผู้ปกครอง):</label>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="d-flex align-items-center justify-content-center">
							<div class="card img-fluid" style="width:300px;">
								<img class="card-img-top" src="<?= base_url('storages/parent_vac/'.$parent->parent_vac_img) ?>" style="width:100%">
								<!-- <div class="card-img-overlay">
									<a href="#" class="btn btn-primary">หลักฐานการฉีดวัคซีน</a>
								</div> -->
							</div>
						</div>
						<div class="col-md-12">
							<label for="parent_vac_img" class="form-label">รูปภาพหลักฐานการฉีดวัคซีน:</label>
							<input class="form-control" type="file" name="parent_vac_img" id="vac_img" accept=".jpg, .jpeg, .png">
						</div>
					</div>

					<br>
					<div class="row">
						<div class="col-md-12">
							<label for="name_parent" class="form-label">สาเหตุที่ไม่รับวัคซีน (กรอกเฉพาะกรณีที่ไม่ได้รับวัคซีน):</label>
							<input type="text" class="form-control" name="post_text" id="text" value="<?= $parent->reason_not_vac ?>" placeholder="สาเหตุที่ไม่รับวัคซีน ">
						</div>
					</div>

				</div>
				<div class="card-footer text-end shadow ">
					<button type="submit" class="btn btn-warning" name="post_btn">แก้ไข </button>
					<a href="<?= site_url('vaccine_parent') ?>" class="btn btn-success">ยกเลิก </a>
				</div>
			</div>

		</form>

		<script>
			$("#getvacine")
				.change(() => {
					let value = $("#getvacine").val();
					console.log(value);

					if (value === "0") {

						$("#vac_img").prop("disabled", true);
						$("#num_vac").prop("disabled", true);
						$("#text").prop("disabled", false);

					} else if (value === "1") {
						$("#vac_img").prop("disabled", false);
						$("#num_vac").prop("disabled", false);
						$("#text").prop("disabled", true);
					}
				});
		</script>
</body>

</html>
