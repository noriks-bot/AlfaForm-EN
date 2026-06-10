<div class="xoo-lic-cont xoo-lic-inline">

	<?php if( $license_active ): ?>

		<?php $this->get_active_license_text() ?>
		
	<?php endif; ?>


	<?php if( $license_expired ): ?>
		<span class="xoo-toggle-license-form">Enter License Key</span>
	<?php endif; ?>

	<div class="xoo-license-form-container">
		<?php include __DIR__.'/xoo-license-form.php'; ?>
	</div>

</div>
