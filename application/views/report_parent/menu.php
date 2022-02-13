<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="<?= base_url('assets/images/ctc.png') ?>" class="w3-circle w3-margin-right" style="width:76px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>งานกิจกรรม <strong>วิทยาลัยเทคนิคชัยภูมิ</strong></span><br>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>ข้อมูลการฉีดวัคซีนของผู้ปกครอง</h5>
  </div>
  <div class="w3-bar-block ">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="<?= site_url('report_parent') ?>" class="w3-bar-item w3-button w3-padding <?= empty($major_id) ? 'w3-blue' : '' ?>"><i class="fa fa-users fa-fw"></i>  สรุปข้อมูล</a>
		<?php
			foreach ($majors as $major) {
				?>
					<a 
					href="<?= site_url('report_parent/major') ?>?major_id=<?= $major->id ?>" 
					class="w3-bar-item w3-button w3-padding <?= getActiveMenu($major_id, $major) ?>">
						<i class="fa fa-cog fa-fw"></i>  
						<?= $major->major_name ?>
					</a>
				<?php
			}
		?>
		<br><br>
  </div>
</nav>
