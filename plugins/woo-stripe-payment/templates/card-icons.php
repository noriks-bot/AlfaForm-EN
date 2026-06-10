<?php
/**
 * @version 3.2.15
 */
?>
<span class="wc-stripe-card-icons-container">
	<?php foreach ( $icons as $icon => $url ): ?>
        <img class="wc-stripe-card-icon <?php echo esc_attr( $icon ) ?>" alt="<?php echo esc_attr( implode( ' ', array_map( 'ucfirst', explode( '_', $icon ) ) ) ) ?>"
             src="<?php echo esc_url( $url ) ?>"/>
	<?php endforeach; ?>
</span>