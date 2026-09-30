<?php

add_action('woocommerce_admin_field_kovatz_dimensions', 'kovatz_dimensions');

function kovatz_dimensions($value) {

    wp_enqueue_script('kovatz-admin-settings');
    wp_enqueue_style('kovatz-admin-settings');

	$html_id = $value['html_id'];
	$id = $value['id'];
	$values = $value['value'];
    $default = $value['default'];

	?>
	<tr valign="top">
		<th scope="row" class="titledesc">
			<label><?php echo esc_html($value['title']); ?> </label>
		</th>
		<td class="forminp forminp-number">
            <div class="kovatz-control-type-dimensions">
                <ul class="kovatz-control-dimensions">
                    <li class="kovatz-control-dimension">
                        <input id="kovatz-control-top-<?php echo esc_attr($id); ?>" type="number"
                               data-setting="top" placeholder=""
                               name="<?php echo esc_attr($id); ?>[top]"
                               value="<?php echo esc_attr($values['top']) ?? esc_attr($default['top'] ?? 0); ?>"
                               class="first-child kovatz-input-number kovatz-input-<?php echo esc_attr($html_id); ?>"
                               data-group="kovatz-input-<?php echo esc_attr($html_id); ?>"
                        >
                        <label for="kovatz-control-top-<?php echo esc_attr($id); ?>" class="kovatz-control-dimension-label">Top</label>
                    </li>
                    <li class="kovatz-control-dimension">
                        <input id="kovatz-control-right-<?php echo esc_attr($id); ?>" type="number"
                               data-setting="right" placeholder=""
                               name="<?php echo esc_attr($id); ?>[right]"
                               value="<?php echo esc_attr($values['right']) ?? esc_attr($default['right'] ?? 0); ?>"
                               class="kovatz-input-number kovatz-input-<?php echo esc_attr($html_id); ?>"
                               data-group="kovatz-input-<?php echo esc_attr($html_id); ?>"
                        >
                        <label for="kovatz-control-right-<?php echo esc_attr($id); ?>" class="kovatz-control-dimension-label">Right</label>
                    </li>
                    <li class="kovatz-control-dimension">
                        <input id="kovatz-control-bottom-<?php echo esc_attr($id); ?>" type="number"
                               data-setting="bottom" placeholder=""
                               name="<?php echo esc_attr($id); ?>[bottom]"
                               value="<?php echo esc_attr($values['bottom']) ?? esc_attr($default['bottom'] ?? 0); ?>"
                               class="kovatz-input-number kovatz-input-<?php echo esc_attr($html_id); ?>"
                               data-group="kovatz-input-<?php echo esc_attr($html_id); ?>"
                        >
                        <label for="kovatz-control-bottom-<?php echo esc_attr($id); ?>" class="kovatz-control-dimension-label">Bottom</label>
                    </li>
                    <li class="kovatz-control-dimension">
                        <input id="kovatz-control-left-<?php echo esc_attr($id); ?>" type="number"
                               data-setting="left" placeholder=""
                               name="<?php echo esc_attr($id); ?>[left]"
                               value="<?php echo esc_attr($values['left']) ?? esc_attr($default['left'] ?? 0); ?>"
                               class="kovatz-input-number kovatz-input-<?php echo esc_attr($html_id); ?>"
                               data-group="kovatz-input-<?php echo esc_attr($html_id); ?>"
                        >
                        <label for="kovatz-control-left-<?php echo esc_attr($id); ?>" class="kovatz-control-dimension-label">Left</label>
                    </li>
                    <li class="kovatz-link">
                        &nbsp;&nbsp;px
                        <input class="kovatz-link-input" type="checkbox"
                               id="kovatz-input-<?php echo esc_attr($html_id); ?>"
                               name="<?php echo esc_attr($id); ?>[link]" value="Yes"
                               data-group="kovatz-input-<?php echo esc_attr($html_id); ?>"
                               <?php if(isset($values['link'])) { echo  esc_attr($values['link']) == 'Yes' ? 'checked': ''; } ?>
                        >
                        <label for="kovatz-input-<?php echo esc_attr($html_id); ?>">Link</label>
                    </li>
                </ul>
            </div>
		</td>
	</tr>
	<?php
}