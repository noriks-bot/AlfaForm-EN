<div class="xoo-license-popup" data-slug="<?php echo $plugin_slug; ?>">
	<span class="xoo-lic-opac"></span>
	<div class="xoo-lic-popup-form">
		<span class="xoo-lic-popup-close">X</span>

		<div class="xoo-lic-pop-content xoo-lic-cont">
			<?php if( $license_active && $show_info ): ?>

				<?php $this->get_active_license_text() ?>
				
			<?php endif; ?>

			<?php if( !$license_active || $license_expired ): ?>

				<?php include __DIR__.'/xoo-license-form.php'; ?>

			<?php endif; ?>
		</div>
	</div>
</div>