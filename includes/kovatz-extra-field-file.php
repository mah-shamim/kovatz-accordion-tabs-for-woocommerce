<?php

add_action('woocommerce_admin_field_kovatz_file', 'kovatz_file');

function kovatz_file($value) {

	$html_id = $value['html_id'];
	$id = $value['id'];
	$values = $value['value'] ?? '';
    $default = $value['default'];
    $suffix = $value['suffix'] ?? '';

	wp_enqueue_media();

	?>
	<tr valign="top">
		<th scope="row" class="titledesc">
			<label><?php echo esc_html($value['title']); ?> </label>
		</th>
		<td class="forminp forminp-number">
            <div class="kovatz-file">
                <input id="<?php echo esc_attr($html_id); ?>" type="text"
                       value="<?php echo esc_url($values); ?>"
                       placeholder="<?php echo esc_attr($value['placeholder']) ?? ''?>"
                       aria-label="<?php echo esc_attr($value['title']) ?? ''?>"
                       name="<?php echo esc_attr($id); ?>"
                />
                <input id="<?php echo esc_attr($html_id) ?>-button" type="button" class="button kovatz-file-selector" value="Upload Image"
                       data-id="<?php echo esc_attr($html_id) ?>"
                />
            </div>
		</td>
	</tr>
	<?php
}