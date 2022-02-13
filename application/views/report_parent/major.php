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
				<a href="<?= site_url('report_parent/major?major_id='.$major->major_id) ?>">สาขาวิชา<?= $major->major_name ?></a>
			</h4>
		</header>

		<div class="w3-row-padding w3-margin-bottom">
			<div class="w3-quarter">
				<div class="w3-container w3-red w3-padding-16">
					<div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
					<div class="w3-right">
						<h3><?= countParentAll($major->stats) ?></h3>
					</div>
					<div class="w3-clear"></div>
					<h4>จำนวนผู้ปกครองทั้งหมด</h4>
				</div>
			</div>
			<div class="w3-quarter">
				<div class="w3-container w3-blue w3-padding-16">
					<div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
					<div class="w3-right">
						<h3><?= $major->stats->inject . '(' . percent($major->stats->inject, countParentAll($major->stats)) . '%)' ?></h3>
					</div>
					<div class="w3-clear"></div>
					<h4>จำนวนผู้ปกครองที่ฉีดวัคซีนแล้ว</h4>
				</div>
			</div>
			<div class="w3-quarter">
				<div class="w3-container w3-teal w3-padding-16">
					<div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
					<div class="w3-right">
						<h3><?= $major->stats->not_inject . '(' . percent($major->stats->not_inject, countParentAll($major->stats)) . '%)' ?></h3>
					</div>
					<div class="w3-clear"></div>
					<h4>จำนวนผู้ปกครองที่ยังไม่ได้ฉีดวัคซีน</h4>
				</div>
			</div>
			<div class="w3-quarter">
				<div class="w3-container w3-orange w3-text-white w3-padding-16">
					<div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
					<div class="w3-right">
						<h3><?= $major->stats->no_data . '(' . percent($major->stats->no_data, countParentAll($major->stats)) . '%)' ?></h3>
					</div>
					<div class="w3-clear"></div>
					<h4>จำนวนผู้ปกครองที่ยังไม่กรอกข้อมูล</h4>
				</div>
			</div>
		</div>

		<div class="w3-panel">
			<div class="w3-row-padding" style="margin:0 -16px">
				<div class="">
					<br>
					<table class="w3-table w3-striped w3-white">
						<tr>
							<th colspan="2" style="text-align: center;">สาขางาน</th>
							<th>ฉีดวัคซีนแล้ว</th>
							<th>ยังไม่ได้ฉีดวัคซีน</th>
							<th>ยังไม่กรอกข้อมูล</th>
							<th>ทั้งหมด</th>
						</tr>
						<?php
						foreach ($major->items as $item) {
							
						?>
						<tr>
							<td><a href="<?= site_url('report_parent/minor?major_id='.$major->major_id.'&minor_id='.$item->minor_id) ?>"><i class="fa fa-eye w3-text-yellow w3-large"></i></a></td>
							<td><a href="<?= site_url('report_parent/minor?major_id='.$major->major_id.'&minor_id='.$item->minor_id) ?>"><?= $item->minor_name ?></a></td>
							<td><i><?= $item->stats->inject . ' คน (' . percent($item->stats->inject,countParentAll($item->stats)) . '%)' ?></i></td>
							<td><i><?= $item->stats->not_inject . ' คน (' . percent($item->stats->not_inject,countParentAll($item->stats)) . '%)' ?></i></td>
							<td><i><?= $item->stats->no_data . ' คน (' . percent($item->stats->no_data,countParentAll($item->stats)) . '%)' ?></i></td>
							<td><i><?= countParentAll($item->stats) . ' คน' ?></i></td>
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
