<!-- alert -->
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
	}
	?>
