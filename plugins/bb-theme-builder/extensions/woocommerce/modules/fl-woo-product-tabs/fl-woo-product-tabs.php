<?php

/**
 * @since 1.0
 * @class FLWooProductTabsModule
 */
class FLWooProductTabsModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'          	=> __( 'Product Tabs', 'fl-theme-builder' ),
			'description'   	=> __( 'Displays the data tabs for the current product.', 'fl-theme-builder' ),
			'category'      	=> __( 'WooCommerce Modules', 'fl-theme-builder' ),
			'partial_refresh'	=> true,
			'dir'               => FL_THEME_BUILDER_DIR . 'extensions/woocommerce/modules/fl-woo-product-tabs/',
			'url'               => FL_THEME_BUILDER_URL . 'extensions/woocommerce/modules/fl-woo-product-tabs/',
			'enabled'           => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLWooProductTabsModule', array() );
