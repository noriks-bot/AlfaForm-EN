<div class="xoo-lic-cont">

	<?php if( $license_active ): ?>

		<div class="xoo-lic-active">
			<?php if( $license_expired ): ?>
				<b style="color: #ff0000">Your license has expired.</b><br><br>
				Your license was active till <?php echo $license_expiry; ?><br><br>
				Please renew your license to get the latest updates
			<?php else: ?>
				Your license is active till <?php echo $license_expiry; ?>
			<?php endif; ?>
		</div>

	<?php else: ?>

		<div class="xoo-lic-head">
			<span class="xoo-lich-title">Your License</span>
		</div>

		<div class="xoo-lic-notices"></div>

		<form class="xoo-license-form" method="POST">

			<div class="xoo-lic-grp">
				<label>License Key</label>
				<input type="text" name="xoo-license-key" required>
			</div>


			<input type="hidden" name="xoo-plugin-slug" value="<?php echo $plugin_slug ?>">

			<input type="hidden" name="xoo-license-website" value="<?php echo $site_url ?>">

			<?php wp_nonce_field( 'xoo_license_nonce', 'xoo_license_nonce_value' ); ?>

			<button type="submit" class="button-primary button">Register</button>

		</form>

	<?php endif; ?>

</div>