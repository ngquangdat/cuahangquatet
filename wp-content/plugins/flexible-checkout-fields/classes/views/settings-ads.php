<?php if ( ! is_flexible_checkout_fields_pro_active() ): ?>

    <div class="stuffbox">
        <h3><?php _e( 'Enjoying the free version? Rate it!', 'flexible-checkout-fields' ); ?></h3>
        <div class="inside">
            <div class="main">
                <p class="rate">
					<a href="<?php echo esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-widget-review-stars' ) ); ?>"
					   target="_blank">
						<span class="dashicons dashicons-star-filled"></span>
						<span class="dashicons dashicons-star-filled"></span>
						<span class="dashicons dashicons-star-filled"></span>
						<span class="dashicons dashicons-star-filled"></span>
						<span class="dashicons dashicons-star-filled"></span>
					</a>
				</p>
                <p style="padding: 0 10px;">
					<?php echo sprintf(
						__( 'If you want to continue using Flexible Checkout Fields for free, %splease add a review%s. You will help us support the free version. Thank you.', 'flexible-checkout-fields' ),
						'<a href="' . esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-widget-review-link' ) ) . '" target="_blank">',
						'</a>'
					); ?>
				</p>
            </div>
        </div>
    </div>

<?php endif; ?>
