<!DOCTYPE html>
<html>
<title>สรปข้อมูล</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
	html,
	body,
	h1,
	h2,
	h3,
	h4,
	h5 {
		font-family: "Raleway", sans-serif
	}
</style>

<body class="w3-light-grey">

	<!-- Top container -->
	<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
		<button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
		<span class="w3-bar-item w3-right">งานกิจกรรม</span>
	</div>

	<!-- Sidebar/menu -->
	<?php echo $menu; ?>


	<!-- Overlay effect when opening sidebar on small screens -->
	<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

	<!-- !PAGE CONTENT! -->
	<div class="w3-main" style="margin-left:300px;margin-top:43px;">

		<!-- Header -->
		<header class="w3-container" style="padding-top:22px">
			<h5><b><i class="fa fa-dashboard"></i> ข้อมูลการฉีดวัคซีนของผู้ปกครอง นักเรียน/นักศึกษา วิทยาลัยเทคนิคชัยภูมิ</b></h5>
			<h4>
				<a href="<?= site_url('report_parent/majors') ?>">สรุปข้อมูล</a>/
				<a href="<?= site_url('report_parent/major?major_id=' . $group->major_id) ?>">สาขาวิชา<?= $group->major_name ?></a>/
				<a href="<?= site_url('report_parent/minor?major_id=' . $group->major_id . '&minor_id=' . $group->minor_id) ?>">สาขางาน<?= $group->minor_name ?></a>/
				<a href="<?= site_url('report_parent/group?major_id=' . $group->major_id . '&group_id=' . $group->group_id) ?>">กลุ่ม<?= $group->group_name ?></a>
			</h4>
		</header>

		<div class="w3-row-padding w3-margin-bottom">
			<div class="w3-quarter">
				<div class="w3-container w3-red w3-padding-16">
					<div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
					<div class="w3-right">
						<h3><?= countParentAll($group->stats) ?></h3>
					</div>
					<div class="w3-clear"></div>
					<h4>จำนวนผู้ปกครองทั้งหมด</h4>
				</div>
			</div>
			<div class="w3-quarter">
				<div class="w3-container w3-blue w3-padding-16">
					<div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
					<div class="w3-right">
						<h3><?= $group->stats->inject . '(' . percent($group->stats->inject, countParentAll($group->stats)) . '%)' ?></h3>
					</div>
					<div class="w3-clear"></div>
					<h4>จำนวนผู้ปกครองที่ฉีดวัคซีนแล้ว</h4>
				</div>
			</div>
			<div class="w3-quarter">
				<div class="w3-container w3-teal w3-padding-16">
					<div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
					<div class="w3-right">
						<h3><?= $group->stats->not_inject . '(' . percent($group->stats->not_inject, countParentAll($group->stats)) . '%)' ?></h3>
					</div>
					<div class="w3-clear"></div>
					<h4>จำนวนผู้ปกครองที่ยังไม่ได้ฉีดวัคซีน</h4>
				</div>
			</div>
			<div class="w3-quarter">
				<div class="w3-container w3-orange w3-text-white w3-padding-16">
					<div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
					<div class="w3-right">
						<h3><?= $group->stats->no_data . '(' . percent($group->stats->no_data, countParentAll($group->stats)) . '%)' ?></h3>
					</div>
					<div class="w3-clear"></div>
					<h4>จำนวนผู้ปกครองที่ยังไม่กรอกข้อมูล</h4>
				</div>
			</div>
		</div>

		<div class="w3-panel">
			<div class="w3-row-padding" style="margin:0 -16px">
				<!-- <div class="w3-third">
					<h5>Regions</h5>
					<img src="<?= base_url('assets/images/covid.jpg') ?>" style="width:100%" alt="">
				</div> -->
				<div class="">
					<!-- <h5>กลุ่ม</h5> -->
					<br>
					<table class="w3-table w3-striped w3-white">
						<tr>
							<th>รหัสนักศึกษา</th>
							<th>ชือ-สกุล</th>
							<th>ชื่อผู้ปกครอง</th>
							<th>การรับวัคซีน</th>
							<th>จำนวนที่รับวัคซีน</th>
							<th>หลักฐานการรับวัคซีน</th>
							<th>สาเหตุที่ไม่รับวัคซีน</th>
						</tr>
						<?php
						foreach ($group->students as $item) {

						?>
							<tr>
								<td><?= $item->student_id ?></td>
								<td><?= $item->firstname . ' ' . $item->lastname ?></td>
								<?php if ($item->parent_status === -1) { ?>
									<td colspan="5" style="text-align: center; color: darkred;">ยังไม่กรอกข้อมูล</td>
								<?php 
								} else { 
									$status = null;
									if ($item->parent_status === 1) {
										$status = '<span class="w3-text-green">ได้รับวัคซีนแล้ว</span>';
									} elseif ($item->parent_status === 0) {
										$status = '<span class="w3-text-orange">ยังไม่ได้รับวัคซีน</span>';
									}
								?>
									<td>
										<?=
										$item->parent_items->title_parent
										.$item->parent_items->name_parent
										.' '.$item->parent_items->surname_parent
										?>
									</td>
									<td><?= $status ?></td>
									<td><?= empty($item->parent_items->number_vacine) ? '-' : $item->parent_items->number_vacine.' เข็ม' ?></td>
									<td>
										<?php if (!empty($item->parent_items->parent_vac_img)) { ?>
										<img src="<?= base_url('storages/parent_vac/'.$item->parent_items->parent_vac_img) ?>" alt="" style="width: 100px; height: 100px; object-fit: cover;">
										<?php } ?>
									</td>
									<td><?= $item->parent_items->reason_not_vac ?></td>
								<?php } ?>
							</tr>
						<?php
						}
						?>
						<!-- <tr>
							<td><i class="fa fa-user w3-text-blue w3-large"></i></td>
							<td>เทคนิคเครื่องกล</td>
							<td><i>10 คน (20%)</i></td>
						</tr>
						<tr>
							<td><i class="fa fa-bell w3-text-red w3-large"></i></td>
							<td>Database error.</td>
							<td><i>15 mins</i></td>
						</tr>
						<tr>
							<td><i class="fa fa-users w3-text-yellow w3-large"></i></td>
							<td>New record, over 40 users.</td>
							<td><i>17 mins</i></td>
						</tr>
						<tr>
							<td><i class="fa fa-comment w3-text-red w3-large"></i></td>
							<td>New comments.</td>
							<td><i>25 mins</i></td>
						</tr>
						<tr>
							<td><i class="fa fa-bookmark w3-text-blue w3-large"></i></td>
							<td>Check transactions.</td>
							<td><i>28 mins</i></td>
						</tr>
						<tr>
							<td><i class="fa fa-laptop w3-text-red w3-large"></i></td>
							<td>CPU overload.</td>
							<td><i>35 mins</i></td>
						</tr>
						<tr>
							<td><i class="fa fa-share-alt w3-text-green w3-large"></i></td>
							<td>New shares.</td>
							<td><i>39 mins</i></td>
						</tr> -->
					</table>
				</div>
			</div>
		</div>
		<hr>

		<!-- End page content -->
	</div>

	<script>
		// Get the Sidebar
		var mySidebar = document.getElementById("mySidebar");

		// Get the DIV with overlay effect
		var overlayBg = document.getElementById("myOverlay");

		// Toggle between showing and hiding the sidebar, and add overlay effect
		function w3_open() {
			if (mySidebar.style.display === 'block') {
				mySidebar.style.display = 'none';
				overlayBg.style.display = "none";
			} else {
				mySidebar.style.display = 'block';
				overlayBg.style.display = "block";
			}
		}

		// Close the sidebar with the close button
		function w3_close() {
			mySidebar.style.display = "none";
			overlayBg.style.display = "none";
		}
	</script>

</body>

</html>
