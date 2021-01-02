<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div class="field-settings-tab-container field-settings-pricing" style="display:none;">
    <div>
        <?php
		    echo sprintf(
		    	__( '%sGo PRO &rarr;%s In this tab it is possible to add a fixed or percentage price to the field and set the tax on this price.' , 'flexible-checkout-fields' ),
				'<a href="' . esc_url( apply_filters( 'flexible_checkout_fields/short_url', '#', 'fcf-settings-field-tab-pricing-upgrade' ) ) . '" target="_blank">',
				'</a>'
			);
		?>
    </div>
</div>
