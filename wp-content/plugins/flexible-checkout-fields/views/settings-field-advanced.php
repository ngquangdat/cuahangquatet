<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div class="field-settings-tab-container field-settings-advanced" style="display:none;">
    <div>
        <?php
 		    echo sprintf(
				__( '%sGo PRO &rarr;%s to add conditional logic based on products/categories, fields and shipping method.' , 'flexible-checkout-fields' ),
				'<a href="' . esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-field-tab-advanced-upgrade' ) ) . '" target="_blank">',
				'</a>'
			);
		?>
    </div>
</div>
