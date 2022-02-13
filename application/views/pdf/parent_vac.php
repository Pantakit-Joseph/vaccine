<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
	<title>รายงานการฉีดวัคซีน</title>

	<link rel="stylesheet" href="<?= base_url('assets/font/font.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/reset.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/parent_print.css') ?>">

	<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/print.js') ?>"></script>
</head>

<body>
	<div class="pagebreak">
		<div class="logo">
			<img src="<?= base_url('assets/images/ctc.png') ?>" alt="">
		</div>
		<div class="header">
			<p>
				สำรวจการฉีดวัคซีนของผู้ปกครองนักเรียน นักศึกษา
				<br>ประกอบการขออนุญาตเปิดเรียนแบบ ON-SITE
			</p>
			<p style="margin-top: 1rem;">
				แผนกวิชา <?= $major_name ?>
				ระดับชั้น
				<?php $class = strtoupper($group_name)[0]; ?>
				<?= $class == 'D' || $class == 'E' ? 'ปวส.' : 'ปวช.'  ?>
				กลุ่ม <?= $group_name; ?>
			</p>
		</div>

		<table class="table-content">
			<thead>
				<tr>
					<th>ลำดับ</th>
					<th>ชื่อ นร. นศ.</th>
					<th>ชื่อผู้ปกครอง</th>
					<th>เข้ารับการ<br>ฉีดวัคซีน</th>
					<th>ยังไม่เข้ารับ<br>การฉีดวัคซีน</th>
					<th>หมายเหตุ</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 0;
				$sum = [0, 0, 0];
				foreach ($students as $std) {
					if ($std->parent_vacine === '1') {
						$sum[1]++;
					} elseif ($std->parent_vacine === '0') {
						$sum[0]++;
					} else {
						$sum[2]++;
					}

				?>
					<tr>
						<td style="text-align: center;"><?= ++$i ?></td>
						<td><?= $std->firstname . ' ' . $std->lastname ?></td>
						<td><?= $std->title_parent . $std->name_parent . ' ' . $std->surname_parent ?></td>
						<td style="text-align: center;">
							<?= $std->parent_vacine === '1' ? '&check;' : '' ?>
						</td>
						<td style="text-align: center;">
							<?= $std->parent_vacine === '0' ? '&check;' : '' ?>
						</td>
						<td>
							<?= $std->parent_vacine === null ? 'ยังไม่กรอกข้อมูล' : '' ?>
							<?= $std->parent_vacine === '0' ? $std->reason_not_vac : '' ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>

		<div class="" style="margin-top: 0.5rem;">
			<p>
				<b>
					ผู้ปกครองทั้งหมด <?= $i ?> คน
					เข้ารับการฉีวัคซีน <?= $sum[1] ?>
					<span style="color: blue;">(<?= round($sum[1] / $i * 100) ?>%)</span> คน
					ยังไม่เข้ารับการฉีดวัคซีน <?= $sum[0] ?>
					<span style="color: blue;">(<?= round($sum[0] / $i * 100) ?>%)</span> คน
					ยังไม่กรอกข้อมูล <?= $sum[2] ?>
					<span style="color: blue;">(<?= round($sum[2] / $i * 100) ?>%)</span> คน
				</b>
			</p>
		</div>

		<div class="sign">
			<div class="signature">
				<img src="http://activity64-2.itchaiyaphum.com/<?= $signature ?>" alt="">
			</div>
			ลงชื่อ ............................................ครูที่ปรึกษา
			<span class="sign-name">(<?= $firstname . ' ' . $lastname  ?>)
			<br>ผู้สำรวจข้อมูล
			</span>
		</div>

		<div class="note">
			<b>หมายเหตุ</b> ขอส่งเอกสาร ภายในอังคารที่ ๑ กุมภาพันธ์ ๒๕๖๕
			<br>ได้ที่งานครูที่ปรึกษา ฝ่ายพัฒนากิจการนักเรียน นักศึกษา
		</div>
	</div>
</body>

</html>
