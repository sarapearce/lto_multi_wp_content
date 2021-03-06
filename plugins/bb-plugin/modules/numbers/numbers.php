<?php

/**
 * @class FLNumbersModule
 */
class FLNumbersModule extends FLBuilderModule {

	/** 
	 * @method __construct
	 */  
	public function __construct()
	{
		parent::__construct(array(
			'name'          => __('Number Counter', 'fl-builder'),
			'description'   => __('Renders an animated number counter.', 'fl-builder'),
			'category'      => __('Advanced Modules', 'fl-builder')
		));

		$this->add_js( 'jquery-waypoints' );
	}

	public function render_number(){

		$number = $this->settings->number ? $this->settings->number : 0;
		$layout = $this->settings->layout ? $this->settings->layout : 'default';
		$type   = $this->settings->number_type ? $this->settings->number_type : 'percent';
		$prefix = $type == 'percent' ? '' : $this->settings->number_prefix;
		$suffix = $type == 'percent' ? '%' : $this->settings->number_suffix;
		$start  = '<script>jQuery( ".fl-node-' . $this->node . ' .fl-number-int" ).html( "0" );</script>';
		$noJs   = '<noscript>' . number_format( $number ) . '</noscript>';
		
		echo '<div class="fl-number-string">' . $prefix . '<span class="fl-number-int">' . $start . $noJs . '</span>' . $suffix . '</div>';
	}

	public function render_circle_bar(){

		$width = !empty( $this->settings->circle_width ) ? $this->settings->circle_width : 100;
		$pos = ( $width / 2 );
		$radius = $pos - 10;
		$dash = number_format( ( ( M_PI * 2 ) * $radius ), 2, '.', '');

		$html = '<div class="svg-container">';
		$html .= '<svg class="svg" viewBox="0 0 '. $width .' '. $width .'" version="1.1" preserveAspectRatio="xMinYMin meet">
			<circle class="fl-bar-bg" r="'. $radius .'" cx="'. $pos .'" cy="'. $pos .'" fill="transparent" stroke-dasharray="'. $dash .'" stroke-dashoffset="0"></circle>
			<circle class="fl-bar" r="'. $radius .'" cx="'. $pos .'" cy="'. $pos .'" fill="transparent" stroke-dasharray="'. $dash .'" stroke-dashoffset="'. $dash .'" transform="rotate(-90 '. $pos .' '. $pos .')"></circle>
		</svg>';
		$html .= '</div>'; 

		echo $html;
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLNumbersModule', array(
	'general'       => array( // Tab
		'title'         => __('General', 'fl-builder'), // Tab title
		'sections'      => array( // Tab Sections
			'general'       => array( // Section
				'title'         => '', // Section Title
				'fields'        => array( // Section Fields
					'layout' => array(
					    'type'          => 'select',
					    'label'         => __( 'Layout', 'fl-builder' ),
					    'default'       => 'default',
					    'options'       => array(
					    	'default'		=> __( 'Only Numbers', 'fl-builder' ),
					    	'circle'		=> __( 'Circle Counter', 'fl-builder' ),
					    	'bars'			=> __( 'Bars Counter', 'fl-builder' ),
					    ),
					    'toggle'		=> array(
					    	'circle'		=> array(
					    		'sections'		=> array( 'circle_bar_style' )
					    	),
					    	'bars'			=> array(
					    		'sections'		=> array( 'bar_style' ),
					    		'fields'		=> array( 'number_position' ),
					    	),
					    ),
					),
					'number_type' => array(
					    'type'          => 'select',
					    'label'         => __( 'Number Type', 'fl-builder' ),
					    'default'       => 'percent',
					    'options'       => array(
					    	'percent'		=> __( 'Percent', 'fl-builder' ),
					    	'standard'		=> __( 'Standard', 'fl-builder' ),
					    ),
					    'toggle'		=> array(
					    	'standard'		=> array(
					    		'fields'		=> array( 'number_prefix', 'number_suffix' )
					    	),
					    ),
					),
					'number' => array(
						'type'          => 'unit',
						'label'         => __('Number', 'fl-builder'),
						'size'          => '5',
						'default'		=> '100',
						'placeholder'	=> '100',
						'connections'   => array( 'custom_field' )
					),
					'max_number' => array(
						'type'          => 'text',
						'label'         => __('Total', 'fl-builder'),
						'size'          => '5',
						'help'			=> __( 'The total number of units for this counter. For example, if the Number is set to 250 and the Total is set to 500, the counter will animate to 50%.', 'fl-builder' ),
					),
					'number_position'	=> array(
						'type'          => 'select',
						'label'         => __('Number Position', 'fl-builder'),
						'size'          => '5',
						'help'			=> __( 'Where to display the number in relation to the bar.', 'fl-builder' ),
						 'options'       => array(
					    	'default'	=> __( 'Inside Bar', 'fl-builder' ),
					    	'above'		=> __( 'Above Bar', 'fl-builder' ),
					    	'below'		=> __( 'Below Bar', 'fl-builder' ),
					    ),
					),
					'before_number_text' => array(
						'type'          => 'text',
						'label'         => __('Text Before Number', 'fl-builder'),
						'size'          => '20',
						'help'			=> __( 'Text to appear above the number. Leave it empty for none.', 'fl-builder' ),
						'connections'   => array( 'custom_field' )
					),
					'after_number_text' => array(
						'type'          => 'text',
						'label'         => __('Text After Number', 'fl-builder'),
						'size'          => '20',
						'help'			=> __( 'Text to appear after the number. Leave it empty for none.', 'fl-builder' ),
						'connections'   => array( 'custom_field' )
					),
					'number_prefix' => array(
						'type'          => 'text',
						'label'         => __('Number Prefix', 'fl-builder'),
						'size'          => '10',
						'help'			=> __( 'For example, if your number is US$ 10, your prefix would be "US$ ".', 'fl-builder' )
					),
					'number_suffix' => array(
						'type'          => 'text',
						'label'         => __('Number Suffix', 'fl-builder'),
						'size'          => '10',
						'help'			=> __( 'For example, if your number is 10%, your suffix would be "%".', 'fl-builder' )
					),
					'animation_speed' => array(
						'type'          => 'text',
						'label'         => __('Animation Speed', 'fl-builder'),
						'size'          => '5',
						'default'		=> '1',
						'placeholder'	=> '1',
						'description'	=> __( 'second(s)', 'fl-builder' ),
						'help'			=> __( 'Number of seconds to complete the animation.', 'fl-builder' )
					),
					'delay' 		 => array(
						'type'          => 'text',
						'label'         => __('Animation Delay', 'fl-builder'),
						'size'          => '5',
						'default'		=> '1',
						'placeholder'	=> '1',
						'description'	=> __( 'second(s)', 'fl-builder' )
					),
				)
			)
		)
	),
	'style'         => array( // Tab
		'title'         => __('Style', 'fl-builder'), // Tab title
		'sections'      => array( // Tab Sections
			'text_style'    => array(
				'title'         => __('Colors', 'fl-builder'),
				'fields'        => array(
					'text_color' => array(
						'type'          => 'color',
						'label'         => __('Text Color', 'fl-builder'),
						'show_reset'    => true,
					    'preview'      => array(
					        'type'         => 'css',
					        'selector'     => '.fl-number-before-text, .fl-number-after-text',
					        'property'     => 'color'
					    )						
					),
					'number_color' => array(
						'type'          => 'color',
						'label'         => __('Number Color', 'fl-builder'),
						'show_reset'    => true,
					    'preview'      => array(
					        'type'         => 'css',
					        'selector'     => '.fl-number-string',
					        'property'     => 'color'
					    )						
					),
					'number_size' => array(
						'type'          => 'text',
						'label'         => __('Number Size', 'fl-builder'),
						'default'       => '32',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					    'preview'      => array(
					        'type'         => 'css',
					        'selector'     => '.fl-number-string',
					        'property'     => 'font-size',
					        'unit'		   => 'px'
					    )
					),
				)
			),
			'circle_bar_style'    => array(
				'title'         => __('Circle Bar Styles', 'fl-builder'),
				'fields'        => array(
					'circle_width' => array(
						'type'          => 'text',
						'label'         => __('Circle Size', 'fl-builder'),
						'default'       => '200',
						'maxlength'     => '4',
						'size'          => '4',
						'description'   => 'px',
					    'preview'      => array(
					        'type'         => 'css',
					        'rules'		   => array(
					        	array(
							        'selector'     => '.fl-number-circle-container',
							        'property'     => 'max-width',
					        		'unit'		   => 'px'
					        	),
					        	array(
							        'selector'     => '.fl-number-circle-container',
							        'property'     => 'max-height',
					        		'unit'		   => 'px'
					        	),
					        )
					    )

					),
					'circle_dash_width' => array(
						'type'          => 'text',
						'label'         => __('Circle Stroke Size', 'fl-builder'),
						'default'       => '10',
						'maxlength'     => '2',
						'size'          => '4',
						'description'   => 'px',
					    'preview'      => array(
					        'type'         => 'css',
					        'selector'     => '.svg circle',
					        'property'     => 'stroke-width',
					        'unit'		   => 'px'
					    )
					),
					'circle_color' => array(
						'type'          => 'color',
						'label'         => __('Circle Foreground Color', 'fl-builder'),
						'default'		=> 'f7951e',
						'show_reset'    => true,
					    'preview'      => array(
					        'type'         => 'css',
					        'selector'     => '.svg .fl-bar',
					        'property'     => 'stroke'
					    )
					),
					'circle_bg_color' => array(
						'type'          => 'color',
						'label'         => __('Circle Background Color', 'fl-builder'),
						'default'		=> 'eaeaea',
						'show_reset'    => true,
					    'preview'      => array(
					        'type'         => 'css',
					        'selector'     => '.svg .fl-bar-bg',
					        'property'     => 'stroke'
					    )
					),
				)
			),
			'bar_style'    => array(
				'title'         => __('Bar Styles', 'fl-builder'),
				'fields'        => array(
					'bar_color' => array(
						'type'          => 'color',
						'label'         => __('Bar Foreground Color', 'fl-builder'),
						'default'		=> 'f7951e',
						'show_reset'    => true,
					    'preview'      => array(
					        'type'         => 'css',
					        'selector'     => '.fl-number-bar',
					        'property'     => 'background-color'
					    )
					),
					'bar_bg_color' => array(
						'type'          => 'color',
						'label'         => __('Bar Background Color', 'fl-builder'),
						'default'		=> 'eaeaea',
						'show_reset'    => true,
					    'preview'      => array(
					        'type'         => 'css',
					        'selector'     => '.fl-number-bars-container',
					        'property'     => 'background-color'
					    )
					),
				)
			),
		)
	),
));