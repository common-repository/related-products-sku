<?php

 	add_filter('woocommerce_product_data_tabs', 'wcrp_product_custom_data');
	function wcrp_product_custom_data($product_data_tabs)
	{
		$product_data_tabs['wcrp_custom-tab'] = array(
			'label' => __('Related Product', 'woocommerce'),
			'target' => 'wcrp_product_data',
			'class' => array('show_if_simple'),
		);
		return $product_data_tabs;
	}

 	function wcpp_custom_style()
	{ ?>
		<style>
			#woocommerce-product-data ul.wc-tabs li.wcrp_custom-tab_options a:before {
				font-family: WooCommerce;
				content: '\e006';
			}
		</style>
		<?php
	}

	add_action('admin_head', 'wcpp_custom_style');

 	add_action('woocommerce_product_data_panels', 'woocom_custom_product_data_fields');
	function woocom_custom_product_data_fields()
	{
		global $post;
		// Note the 'id' attribute needs to match the 'target' parameter set above
		?>
		<div id='wcrp_product_data'
		     class='panel woocommerce_options_panel'> <?php
		?>
		<div class="options_group"> <?php
				// Text Field
				woocommerce_wp_text_input(
					array(
						'id' => '_wcrp-products_ids',
						'label' => __('Related product', 'woocommerce'),
						'wrapper_class' => 'show_if_simple', //show_if_simple or show_if_variable
						'placeholder' => 'SKU codes',
						'desc_tip' => 'true',
						'description' => __('Type Sku codes comma separeted, no spaces', 'woocommerce')
					)
				);
				// Number Field
				/*woocommerce_wp_text_input(
					array(
						'id' => '_number_field',
						'label' => __('Custom Number Field', 'woocommerce'),
						'placeholder' => '',
						'description' => __('Enter the custom value here.', 'woocommerce'),
						'type' => 'number',
						'custom_attributes' => array(
							'step' => 'any',
							'min' => '15'
						)
					)
				);
				// Checkbox
				woocommerce_wp_checkbox(
					array(
						'id' => '_checkbox',
						'label' => __('Custom Checkbox Field', 'woocommerce'),
						'description' => __('Check me!', 'woocommerce')
					)
				);
				// Select
				woocommerce_wp_select(
					array(
						'id' => '_select',
						'label' => __('Custom Select Field', 'woocommerce'),
						'options' => array(
							'one' => __('Custom Option 1', 'woocommerce'),
							'two' => __('Custom Option 2', 'woocommerce'),
							'three' => __('Custom Option 3', 'woocommerce')
						)
					)
				);
				// Textarea
				woocommerce_wp_textarea_input(
					array(
						'id' => '_textarea',
						'label' => __('Custom Textarea', 'woocommerce'),
						'placeholder' => '',
						'description' => __('Enter the value here.', 'woocommerce')
					)
				);*/
			?> </div>
		</div><?php
	}

	/** Hook callback function to save custom fields information */
	function woocom_save_proddata_custom_fields($post_id)
	{
		// Save Text Field
		$text_field = $_POST['_wcrp-products_ids'];
		if (!empty($text_field)) {
			update_post_meta($post_id, '_wcrp-products_ids', sanitize_text_field($text_field));
		}
		// Save Number Field
		/*$number_field = $_POST['_number_field'];
		if (!empty($number_field)) {
			update_post_meta($post_id, '_number_field', esc_attr($number_field));
		}
		// Save Textarea
		$textarea = $_POST['_textarea'];
		if (!empty($textarea)) {
			update_post_meta($post_id, '_textarea', esc_html($textarea));
		}
		// Save Select
		$select = $_POST['_select'];
		if (!empty($select)) {
			update_post_meta($post_id, '_select', esc_attr($select));
		}
		// Save Checkbox
		$checkbox = isset($_POST['_checkbox']) ? 'yes' : 'no';
		update_post_meta($post_id, '_checkbox', $checkbox);*/
		// Save Hidden field
		/*$hidden = $_POST['_hidden_field'];
		if (!empty($hidden)) {
			update_post_meta($post_id, '_hidden_field', esc_attr($hidden));
		}*/
	}

	add_action('woocommerce_process_product_meta_simple', 'woocom_save_proddata_custom_fields');
// You can uncomment the following line if you wish to use those fields for "Variable Product Type"
//add_action( 'woocommerce_process_product_meta_variable', 'woocom_save_proddata_custom_fields'  );


	function woocom_custom_product_data_tab($original_prodata_tabs)
	{
		$new_custom_tab['wcrp_custom-tab'] = array(
			'label' => __('My Custom Tab', 'woocommerce'),
			'target' => 'wcrp_product_data_tab',
			'class' => array('show_if_simple', 'show_if_variable'),
		);
		$insert_at_position = 2; // Change this for desire position
		$tabs = array_slice($original_prodata_tabs, 0, $insert_at_position, true); // First part of original tabs
		$tabs = array_merge($tabs, $new_custom_tab); // Add new
		$tabs = array_merge($tabs, array_slice($original_prodata_tabs, $insert_at_position, null, true)); // Glue the second part of original
		return $tabs;
	}


	add_filter('woocommerce_related_products', 'wcrp_related_product', 10, 3);
	function wcrp_related_product($related_posts, $product_id, $args)
	{

		$allSku = get_post_meta(get_the_ID(), '_wcrp-products_ids', true);
		$arraySku = preg_split("/\,/", $allSku);
		$prodottiIds = array();
		foreach ($arraySku as $sku) {
			$prodottiIds[] = wc_get_product_id_by_sku($sku);
		}
		if ($allSku) {
			$related_posts = $prodottiIds;
		}

		return $related_posts;
	}