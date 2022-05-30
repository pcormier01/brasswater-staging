<?php


/*
 * Range Slider with Breakpoints
 *
 * since 4.6
 * version 1.0
 */

if ( ! class_exists( 'UT_BreakPoint_RangeSlider_Param' ) ) {

	class UT_BreakPoint_RangeSlider_Param {

		/**
		 * @var array
		 */
		protected $settings = array();

		/**
		 * @var string
		 */
		protected $value = '';

		/**
		 * @var array
		 */
		protected $default_values = array();

		/**
		 * @var array
		 */
		protected $global_values = array();

		/**
		 * @var string
		 */
		protected $responsive_attribute = '';


		/**
		 * @var string
		 */
		protected $value_unit = '';


		function __construct( $settings, $value ) {

			$this->settings = $this->settings( $settings );
			$this->value    = $this->value( $value );

		}

		/**
		 * Settings
		 *
		 * @param null $settings
		 *
		 * @return array
		 */
		function settings( $settings = null ) {

			if ( is_array( $settings ) ) {
				$this->settings = $settings;
			}

			return $this->settings;

		}

		/**
		 * @param null $value
		 *
		 * @return string
		 */
		function value( $value = null ) {

			if ( is_string( $value ) ) {

			    if( strpos( $value, 'px' ) === false ) {

			        $this->value_unit = 'px';

                }

			    // @todo causes bug!!
				// maybe the field value was stored with a unit such as px
				// $value = str_replace("px", "", $value );
				// $value = str_replace("em", "", $value );
				// $value = str_replace("%", "", $value );

				$this->value = $value;

			}

			return $this->value;

		}

		public function set_responsive_attribute() {

		    $param_name = str_replace('_', '-', $this->settings['param_name'] );

		    foreach( ut_font_responsive_attributes() as $valid_attribute ) {

		        if( strpos($param_name, $valid_attribute ) !== false ) {

		            $this->responsive_attribute = $valid_attribute;

                }

            }

        }

		public function global_values( $param ) {

            $this->default_values = array(
                'desktop_large' => 'inherit',
                'desktop_small' => 'inherit',
                'tablet'        => 'inherit',
                'mobile'        => 'inherit'
            );

            foreach( ut_font_responsive_attributes() as $valid_attribute ) {

                $this->default_values[$valid_attribute . '-unit'] = ut_font_responsive_attribute_values( $valid_attribute );

            }

		    if( isset( $param ) && !is_array( $param ) && array_key_exists( $param, ut_font_responsive_settings() ) ) {

			    $param_name = str_replace('_', '-', $this->settings['param_name'] );

                foreach( ut_font_responsive_attributes() as $valid_attribute ) {

                    if( array_key_exists( $valid_attribute, ut_font_responsive_settings()[$param] ) ) {

                        if( strpos($param_name, $valid_attribute ) !== false ) {

                            $this->global_values = ut_font_responsive_settings()[$param][$valid_attribute];

                            if( !empty( ut_font_responsive_settings()[$param]['base-' . $valid_attribute] ) ) {

                                $this->global_values['desktop_large'] = ut_font_responsive_settings()[$param]['base-' . $valid_attribute];

                            } else {

                                $this->global_values['desktop_large'] = 'inherit';

                            }

                            if( !empty( ut_font_responsive_settings()[$param][$valid_attribute . '-unit'] ) ) {

                                $this->global_values[$valid_attribute . '-unit'] = ut_font_responsive_settings()[$param][$valid_attribute . '-unit'];

                            } else {

                                $this->global_values[$valid_attribute . '-unit'] = ut_font_responsive_attribute_values( $valid_attribute );

                            }

                        }

                    }

                }

            }

            $this->global_values = array_merge( $this->default_values, $this->global_values );

        }


		function render() {

		    if( !function_exists('ut_font_responsive_attributes') ) {

		        return '';

            }

		    // the attribute we work with
		    $this->set_responsive_attribute();

			// do not allow values lower than min
			if( $this->value < $this->settings['value']['min'] ) {
				if( is_array( $this->value ) && !empty( $this->value ) ) {
					$this->value = $this->value["default"];
				}
			}

			// do not allows values larger than max
			if( $this->value > $this->settings['value']['max'] ) {
				if( is_array( $this->value ) && !empty( $this->value ) ) {
					$this->value = $this->value["default"];
				}
			}

			$slider_values = array();

			if( is_numeric( $this->value ) ) {

				$slider_values['desktop_large'] = $this->value;

				// stored value is not equal default value indicates user had a custom value before
				if( isset( $this->settings['value']['default'] ) && $this->settings['value']['default'] != $this->value && isset( $this->settings['value']['fallback_unit'] ) ) {

                    $slider_values[$this->responsive_attribute . '-unit'] = $this->settings['value']['fallback_unit'];

                } else {

                    if (isset($this->settings['value']['unit'])) {

                        $slider_values[$this->responsive_attribute . '-unit'] = $this->settings['value']['unit'];

                    }

                }

            } else {

				parse_str($this->value, $slider_values);

            }

			// global values
            $this->global_values( $this->settings['param_responsive'] );

			$slider_class = array(
                'ut-range-slider', 'ut-breakpoint-range-slider'
            );

			$dynamic_slider_data_attributes = '';

			// has multiple global relations
			if( is_array( $this->settings['param_responsive'] ) ) {

                $slider_class[]                 = 'ut-breakpoint-range-slider-dynamic';
                $dynamic_slider_data_attributes = 'data-dynamic-values="' . htmlentities( json_encode( $this->settings['param_responsive'] ), ENT_QUOTES, 'utf-8' ) . '"';

            }

			// has no global relations
			if( $this->settings['param_responsive'] === false ) {

			    $slider_class[] = 'ut-breakpoint-range-slider-static';

                $this->global_values = array(
                    'desktop_large' => 'inherit',
                    'desktop_small' => 'inherit',
                    'tablet'        => 'inherit',
                    'mobile'        => 'inherit'
                );

            }

			$slider_values = array_merge($this->global_values, $slider_values );

			ob_start(); ?>

            <?php if( !empty( $this->settings['kb_link'] ) ) : ?>

                <a class="ut-knowledgebase-link" target="_blank" href="<?php echo esc_url( $this->settings['kb_link'] ); ?>">
                    <span class="dashicons dashicons-editor-help"></span>
                </a>

            <?php endif; ?>

			<div>

                <ul class="ut-responsive-slider-tabs">

                    <?php if( $dynamic_slider_data_attributes ) : ?>

                        <li><span class="ut-dynamic-tag"></span></li>

                    <?php endif; ?>

                    <?php foreach( ot_recognized_breakpoints() as $key => $breakpoint ) : ?>

                        <li><a data-breakpoint="<?php echo $breakpoint; ?>" data-tooltip="<?php echo $breakpoint; ?> : <?php echo ot_recognized_breakpoints_values( $key ); ?>" href="#<?php echo esc_attr( $this->settings['param_name'] ); ?>_tab_<?php echo esc_attr( $key ); ?>" class="<?php echo $key == 'desktop_large' ? 'active' : '' ;  ?>"><?php echo ot_get_breakpoint_icon( $key ); ?></a></li>

                    <?php endforeach; ?>

                </ul>

                <section id="<?php echo esc_attr( $this->settings['param_name'] ); ?>_group" class="ut-responsive-slider-tabgroup <?php echo $this->responsive_attribute == 'letter-spacing' ? 'global' : '' ; ?>">

				<?php foreach( ot_recognized_breakpoints() as $key => $breakpoint ) : ?>

                    <?php

                    // data min
                    if( $this->settings['param_responsive'] !== false ) {

                        if( $this->responsive_attribute == 'letter-spacing' ) {

                            $data_min = $this->settings['value']['min'] - $this->settings['value']['step'];

                        } else {

                            $data_min = ( $key == 'desktop_large' ) ? $this->settings['value']['min'] : $this->settings['value']['min'] - $this->settings['value']['step'];

                        }

                    } else {

                        $data_min = $this->settings['value']['min'];

                    }

                    // field value
                    $slider_value = !empty( $slider_values[$key] ) && $slider_values[$key] != 'inherit' ? $slider_values[$key] : '';
                    $slider_value = $slider_value == 'global' ? $this->global_values[$key] : $slider_value;

                    // field value fallback for options without global parameter relation
                    if( $key == 'desktop_large' && $this->settings['param_responsive'] === false ) {

                        $slider_value = $slider_value == $data_min ? '' : $slider_value;

                    }

                    // fallback
                    $slider_value = $slider_values[$key] == 'global' && $slider_value == 'inherit' ? '' : $slider_value;

                    $input_value = !empty( $slider_values[$key] ) && $slider_values[$key] == 'inherit' ? 'inherit' : $slider_value;
                    $input_value = $input_value == 'global' ? $this->global_values[$key] : $input_value;

                    $span_value   = !empty( $slider_values[$key] ) ? $slider_values[$key] : 'inherit'; ?>

                    <div id="<?php echo esc_attr( $this->settings['param_name'] ); ?>_tab_<?php echo esc_attr( $key ); ?>" class="ut-responsive-slider-tab clearfix">

                        <div class="wpb_element_label"><?php echo $this->settings['heading']; ?></div>

                        <div class="ut-range-slider-block">

                            <div class="ut-range-slider-wrap <?php echo ( isset( $this->settings['unit_support'] ) && $this->settings['unit_support'] ? 'ut-range-unit-support' : ''  ); ?>">

                                <div data-breakpoint="<?php echo esc_attr( $key ); ?>"
                                     data-attribute="<?php echo esc_attr( $this->responsive_attribute ); ?>"
                                     data-group-value="#<?php echo esc_attr( $this->settings['param_name'] ); ?>_value"
                                     data-min="<?php echo esc_attr( $data_min ); ?>"
                                     data-max="<?php echo esc_attr( $this->settings['value']['max'] ); ?>"
                                     data-step="<?php echo esc_attr( $this->settings['value']['step'] ); ?>"
                                     data-value="<?php echo esc_attr( $slider_value ); ?>"
                                     data-global="<?php echo esc_attr( $this->global_values[$key] ); ?>"
                                     <?php echo $dynamic_slider_data_attributes; ?>
                                     class="<?php echo implode( ' ', $slider_class ); ?>"></div>

                                <div class="ut-range-value-wrap">

                                    <input value="<?php echo !empty( $span_value ) ? $span_value : 'auto'; ?>" data-unit="<?php echo esc_attr( $this->settings['value']['unit'] ); ?>" class="ut-range-value">
                                    <span class="ut-range-slider-unit-info">global</span>

                                </div>

                                <?php if( isset( $this->settings['unit_support'] ) && $this->settings['unit_support'] ) : ?>

                                <?php

                                // set global unit
                                $unit_func = 'ot_recognized_' . str_replace("-", "_", $this->responsive_attribute) . '_units';

                                if( !is_array( $this->settings['param_responsive'] ) ) {

                                    $global_unit = ut_font_responsive_settings()[$this->settings['param_responsive']][$this->responsive_attribute . '-unit'] ?? 'px';

                                } else {

                                    $global_unit = 'px';

                                }

                                // select field only for desktop
                                if( $key == 'desktop_large' ) :

                                    $field_unit = str_replace("-", "_", $this->responsive_attribute );
                                    $min_max_step_func = "ot_recognized_{$field_unit}_dynamic";

                                    $select            = array_merge( array( '' => esc_html__('global ', 'ut_shortcodes' ) . "($global_unit)" ), $unit_func( 'section_title_module' ) );
                                    $select_unit_value = $slider_values[$this->responsive_attribute. '-unit'] ?? ''; ?>

                                    <div class="ut-range-slider-unit-wrap">

                                    <select data-global-unit="<?php echo esc_attr( $global_unit ); ?>" data-relation-field="<?php echo esc_attr( $this->settings['param_name'] ); ?>_group" data-group-value="#<?php echo esc_attr( $this->settings['param_name'] ); ?>_value" name="<?php echo $this->responsive_attribute; ?>-unit" class="wpb-input wpb-select dropdown default ut-range-slider-unit">

                                        <?php foreach( $select as $_key => $value ) :

                                            if( empty( $_key ) ) {

                                                $data_value = $global_unit;
                                                $min_max_step = $min_max_step_func( $this->settings['in_module'] . '_' . $this->settings['param_name'], $global_unit);

                                            } else {

                                                $data_value = $_key;
                                                $min_max_step = $min_max_step_func( $this->settings['in_module'] . '_' . $this->settings['param_name'], $_key);

                                            } ?>

                                            <option data-relation-value="<?php echo implode(",", $min_max_step ); ?>" data-value="<?php echo esc_attr( $data_value ); ?>" value="<?php echo esc_attr( $_key ); ?>" <?php selected( $_key, $select_unit_value ); ?>><?php echo $value; ?></option>

                                        <?php endforeach; ?>

                                    </select>

                                    <span class="ut-range-slider-unit-info">global</span>

                                    </div>

                                <?php else : ?>

                                    <div class="ut-range-slider-unit-wrap">

                                        <div class="ut-range-value-info"><?php echo $global_unit; ?></div>
                                        <span class="ut-range-slider-unit-info">global</span>

                                    </div>

                                <?php endif; ?>

                                <?php else : ?>

                                <div class="ut-range-slider-unit-wrap">

                                    <div class="ut-range-value-info global">em</div>
                                    <span class="ut-range-slider-unit-info">default</span>

                                </div>

                                <?php endif; ?>

                                <div class="ut-range-slider-actions">

                                    <?php if( ( $key != 'desktop_large' && $this->settings['param_responsive'] !== false ) || $this->responsive_attribute == 'letter-spacing' ) : ?>

                                        <?php if( $key == 'desktop_large' && $this->responsive_attribute == 'letter-spacing' ) : ?>

                                            <!-- <button data-tooltip="<?php echo esc_attr__('set default', 'ut_shortcodes' ); ?>" class="vc_btn vc_btn-sm ut-set-inherit"><span class="dashicons dashicons-editor-break"></span></button> -->

                                        <?php else : ?>

                                            <button data-tooltip="<?php echo esc_attr__('inherit from larger', 'ut_shortcodes' ); ?>" class="vc_btn vc_btn-sm ut-set-inherit"><span class="dashicons dashicons-editor-break"></span></button>

                                        <?php endif; ?>

                                    <?php endif; ?>

                                    <button data-tooltip="<?php echo sprintf( esc_attr__('Reset to Global Value: ', 'ut_shortcodes' ), esc_attr( $this->global_values[$key] ) ); ?>" class="vc_btn vc_btn-sm ut-restore-global" data-global="<?php echo $this->global_values[$key]; ?>" data-global-unit="<?php echo $this->global_values[$this->responsive_attribute. '-unit']; ?>"><span class="dashicons dashicons-image-rotate"></span></button>

                                </div>

                                <!-- hidden field for value parsing -->
                                <input name="<?php echo esc_attr( $key ); ?>" type="hidden" value="<?php echo $input_value; ?>" autocomplete="off">

                            </div>

                        </div>

                    </div>

				<?php endforeach; ?>

                </section>

				<input id="<?php echo esc_attr( $this->settings['param_name'] ); ?>_value" name="<?php echo esc_attr( $this->settings['param_name'] ); ?>" class="wpb_vc_param_value wpb-textinput <?php echo esc_attr( $this->settings['param_name'] ); ?> <?php echo esc_attr( $this->settings['type'] ); ?>_field" type="hidden" value="<?php echo esc_attr( $this->value ); ?>" autocomplete="off" />


			</div>

			<?php return ob_get_clean();


		}

	}

}

/**
 * Range Slider with Breakpoints
 *
 * @param $settings
 * @param $value
 *
 * @return mixed|void
 */
function ut_add_vc_breakpoint_range_slider_param_type( $settings, $value ) {

	$slider = new UT_BreakPoint_RangeSlider_Param( $settings, $value );
	return $slider->render();

}

if( defined( 'WPB_VC_VERSION' ) ) {

	vc_add_shortcode_param(
		'breakpoint_range_slider',
		'ut_add_vc_breakpoint_range_slider_param_type',
		UT_SHORTCODES_URL . '/vc/admin/assets/vc_extend/breakpoint.js'
	);

}



/*
 * Datepicker Param
 *
 * since 4.6
 * version 1.0
 */

if ( ! class_exists( 'UT_Datepicker_Param' ) ) {
    
    class UT_Datepicker_Param {
        
        /**
         * @var array
         */
        protected $settings = array();
        
        
        /**
         * @var string
         */
        protected $value = '';
        
        
        function __construct( $settings, $value ) {
            
            $this->settings = $this->settings( $settings );            
            $this->value    = $this->value( $value );
            
        }
        
        /**
         * Settings
         *
         * @param null $settings
         *
         * @return array
         */
        function settings( $settings = null ) {
            
            if ( is_array( $settings ) ) {
                $this->settings = $settings;
            }

            return $this->settings;
            
        }
        
        /**
         * @param null $value
         *
         * @return string
         */
        function value( $value = null ) {
            
            if ( is_string( $value ) ) {
                $this->value = $value;
            }

            return $this->value;
            
        }
        
        
        function render() {
            
            $out = '<div class="ut-datetimepicker-wrap">';
            
                $out .= '<input name="' . esc_attr( $this->settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ut-datetimepicker ' . esc_attr( $this->settings['param_name'] ) . ' ' . esc_attr( $this->settings['type'] ) . '_field" type="text" value="' . esc_attr( $this->value ) . '" />';
                
            $out .= '</div>';
            
            return $out;                        
        
        }        
        
    }

}

/**
 * Datepicker
 *
 * @param $settings
 * @param $value
 *
 * @return mixed|void
 */
function ut_add_vc_datepicker_param_type( $settings, $value ) {
    
    $section_anchor = new UT_Datepicker_Param( $settings, $value );
    return $section_anchor->render();

}

if( defined( 'WPB_VC_VERSION' ) ) {

    vc_add_shortcode_param( 
        'datepicker', 
        'ut_add_vc_datepicker_param_type', 
        UT_SHORTCODES_URL . '/vc/admin/assets/vc_extend/datepicker.js' 
    );

}



/*
 * IFrame Textarea with URL extraction
 *
 * since 4.5
 * version 1.0
 */

if ( ! class_exists( 'UT_Iframe_Param' ) ) {
    
    class UT_Iframe_Param {
        
        /**
         * @var array
         */
        protected $settings = array();
        
        
        /**
         * @var string
         */
        protected $value = '';
        
        
        function __construct( $settings, $value ) {
            
            $this->settings = $this->settings( $settings );            
            $this->value    = $this->value( $value );
            
        }
        
        /**
         * Settings
         *
         * @param null $settings
         *
         * @return array
         */
        function settings( $settings = null ) {
            
            if ( is_array( $settings ) ) {
                $this->settings = $settings;
            }

            return $this->settings;
            
        }
        
        /**
         * @param null $value
         *
         * @return string
         */
        function value( $value = null ) {
            
            if ( is_string( $value ) ) {
                $this->value = $value;
            }

            return $this->value;
            
        }
        
        function render() {
            
            $out = '<div class="ut-iframe">';
                
                $out .= '<textarea name="' . esc_attr( $this->settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textarea textarea ut-iframe-input ' . esc_attr( $this->settings['param_name'] ) . ' ' . esc_attr( $this->settings['type'] ) . '_field" value="' . esc_attr( $this->value ) . '">' . esc_attr( $this->value ) . '</textarea>';               
            
            $out .= '</div>';
            
            return $out;
                        
        
        }
        
            
    }

}


/**
 * @param $settings
 * @param $value
 *
 * @return mixed|void
 */
function ut_add_vc_iframe_param_type( $settings, $value ) {
    
    $section_anchor = new UT_Iframe_Param( $settings, $value );
    return $section_anchor->render();

}

if( defined( 'WPB_VC_VERSION' ) ) {

    vc_add_shortcode_param( 
        'iframe', 
        'ut_add_vc_iframe_param_type', 
        UT_SHORTCODES_URL . '/vc/admin/assets/vc_extend/utifroption.js' 
    );

}


/*
 * Gradfent Color Picker
 *
 * since 4.5.4
 * version 1.0
 */

if ( ! class_exists( 'UT_Gradient_Picker' ) ) {

    class UT_Gradient_Picker {
        
        /**
         * @var array
         */
        protected $settings = array();
        
        /**
         * @var string
         */
        protected $value = '';
        
        function __construct( $settings, $value ) {
            
            $this->settings = $this->settings( $settings );            
            $this->value    = $this->value( $value );
            
        }
        
        /**
         * Settings
         *
         * @param null $settings
         *
         * @return array
         */
        function settings( $settings = null ) {
            
            if ( is_array( $settings ) ) {
                $this->settings = $settings;
            }

            return $this->settings;
            
        }
        
        /**
         * @param null $value
         *
         * @return string
         */
        function value( $value = null ) {
            
            if ( is_string( $value ) ) {
                $this->value = $value;
            }

            return $this->value;
            
        }
        
        
        function render() {
        
            $out = '<input name="' . esc_attr( $this->settings['param_name'] ) . '" data-mode="gradient" class="wpb_vc_param_value wpb-textinput ut-gradient-picker ' . esc_attr( $this->settings['param_name'] ) . ' ' . esc_attr( $this->settings['type'] ) . '_field" type="text" value="' . esc_attr( $this->value ) . '" />';           
        
            return $out;
            
        }
        
    }

}

/**
 * @param $settings
 * @param $value
 *
 * @return mixed|void
 */
function ut_add_vc_gradient_picker_param_type( $settings, $value ) {
    
    $gradient_picker = new UT_Gradient_Picker( $settings, $value );
    return $gradient_picker->render();

}

vc_add_shortcode_param( 
    'gradient_picker', 
    'ut_add_vc_gradient_picker_param_type', 
    UT_SHORTCODES_URL . '/vc/admin/assets/vc_extend/gradient-picker.js' 
);


/*
 * Section Anchor Creator
 *
 * since 4.2.3
 * version 1.0
 */

if ( ! class_exists( 'UT_Section_Anchor_Param' ) ) {

    class UT_Section_Anchor_Param {
        
        /**
         * @var array
         */
        protected $settings = array();
        
        /**
         * @var string
         */
        protected $value = '';
        
        function __construct( $settings, $value ) {
            
            $this->settings = $this->settings( $settings );            
            $this->value    = $this->value( $value );
            
        }
        
        /**
         * Settings
         *
         * @param null $settings
         *
         * @return array
         */
        function settings( $settings = null ) {
            
            if ( is_array( $settings ) ) {
                $this->settings = $settings;
            }

            return $this->settings;
            
        }
        
        /**
         * @param null $value
         *
         * @return string
         */
        function value( $value = null ) {
            
            if ( is_string( $value ) ) {
                $this->value = $value;
            }

            return $this->value;
            
        }
        
        function render() {
            
            $out = '<div class="ut-section-anchor-wrap">';
                    
                $out .= '<input name="' . esc_attr( $this->settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ut-section-anchor-input ' . esc_attr( $this->settings['param_name'] ) . ' ' . esc_attr( $this->settings['type'] ) . '_field" type="text" value="' . esc_attr( $this->value ) . '" />';           
                
                $out .= '<span class="vc_description vc_description_top vc_clearfix">' . esc_html__( 'This is your final custom link. ', 'ut_shortcodes' ) . '</span>';
                
                $out .= '<div class="clear"></div>';
                
                $out .= '<code class="ut-url-code"><span class="ut-url"></span><span class="ut-section-id"></span></code>';
                
                $out .= '<span class="vc_description vc_clearfix">' . sprintf( esc_html__( 'You can copy this URL and manually add it as a custom link to the themes primary navigation or a custom link such as a button or any other element which supports links. By using the button below, the system will add the menu item program automatically to the themes primary navigation. Afterwards you simply need to re order the item. If you are using the custom link on a button, please copy the link, add it to the desired element and additionally add the following CSS class to it: %s', 'ut_shortcodes' ), '<strong>ut-scroll-to-section</strong>' ) . '</span>';
                
                $out .= '<div class="clear"></div>';
                
                $out .= '<button class="ut-add-anchor-section ut-ui-button" rel="" title="' . __( 'Add to menu', 'ut_shortcodes' ) . '">' . __( 'Add to menu', 'ut_shortcodes' ) . '</button>';
                                
            $out .= '</div>';
            
            return $out;
       
        }               
            
    }

}

/**
 * @param $settings
 * @param $value
 *
 * @return mixed|void
 */
function ut_add_vc_section_anchor_param_type( $settings, $value ) {
    
    $section_anchor = new UT_Section_Anchor_Param( $settings, $value );
    return $section_anchor->render();

}

vc_add_shortcode_param( 
    'section_anchor', 
    'ut_add_vc_section_anchor_param_type', 
    UT_SHORTCODES_URL . '/vc/admin/assets/vc_extend/section-anchor.js' 
);

/*
 * Ajax Request for Section Anchor
 *
 * since 4.2.3
 * version 1.0
 */

function ut_save_anchor_to_menu() {
            
    if( !current_user_can('edit_posts') ) {
        return;    
    }
    
    $menu_locations = get_nav_menu_locations();
    
    if( !empty( $menu_locations['primary'] ) ) {
        
        $title  = $_POST['title'];
        $url    = esc_url( $_POST['url'] );
        
        if( !empty( $title ) && !empty( $url ) ) {
        
            wp_update_nav_menu_item( 
                $menu_locations['primary'], 0, 
                array(
                    'menu-item-title'   =>  $title,
                    'menu-item-url'     =>  $url, 
                    'menu-item-status'  => 'publish'
                )
            );
            
            echo 'item_added';
            
        } else {
            
            echo 'error';
            
        }
        
    } else {
        
        echo 'no_menu';        
    
    }
                    
    exit;

}

add_action( 'wp_ajax_save_section_anchor', 'ut_save_anchor_to_menu' );


/*
 * Range Slider 
 *
 * since 4.0
 * version 1.0
 */

if( !function_exists('ut_add_vc_range_slider_param_type') ) :

    function ut_add_vc_range_slider_param_type( $settings, $value ) {
		
		// mabye the field value was stored with a unit such as px
        $value = str_replace("px", "", $value );
		$value = str_replace("em", "", $value );
		$value = str_replace("%", "", $value );
		
        $value = empty( $value ) && $value != 0 ? 0 : $value;
        $range_global_class = $data_glob = '';
		
        if( is_array( $value ) && !empty( $value ) ) {            
            $value = $value["default"];
        }
		
		// option has global support
		if( isset( $settings['value']['global'] ) ) {
			
			$data_glob = 'data-global="' . $settings['value']['global'] . '"';
			
			if( empty( $value) || $value == $settings['value']['global'] ) {
				
				$value = $settings['value']['global'];
				$range_global_class = 'ut-range-value-global';
				$unit_field = 'global';
				
			}
			
		} 
		
		// do not allow values lower than min
		if( $value < $settings['value']['min'] ) {
            if( is_array( $value ) && !empty( $value ) ) {
                $value = $value["default"];
            }
		}
		
		// do not allows values larger than max
		if( $value > $settings['value']['max'] ) {
            if( is_array( $value ) && !empty( $value ) ) {
                $value = $value["default"];
            }
		}
		
		if( empty( $unit_field ) ) {			
			 $unit_field = $value;			
		}		
		
        $out = '<div class="ut-range-slider-block">';
			
            $out .= '<div class="ut-range-slider-wrap">';
                
                $out .= '<div ' . $data_glob . ' data-value="' . $value . '" data-min="' . esc_attr( $settings['value']['min'] ) . '" data-max="' . esc_attr( $settings['value']['max'] ) . '" data-step="' . esc_attr( $settings['value']['step'] ) . '" data-for="ut_range_slider_' . esc_attr( $settings['param_name'] ) . '" class="ut-range-slider"></div>';
                $out .= '<span data-unit="' . esc_attr( $settings['value']['unit'] ) . '" class="ut-range-value ' . $range_global_class . '">' . esc_attr( $unit_field ) . '</span>';
                $out .= '<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" />';
            
            $out .= '</div>'; 
                
        $out .= '</div>'; 
        
        return $out; 
        
    }    
    
    vc_add_shortcode_param( 'range_slider', 'ut_add_vc_range_slider_param_type', UT_SHORTCODES_URL . '/vc/admin/assets/vc_extend/range-slider.js' );

endif;


/*
 * United Themes CSS Editor
 *
 * since 4.2
 * version 1.0
 */


if ( ! class_exists( 'UT_CSS_Editor' ) ) {

    class UT_CSS_Editor {
        
        /**
         * @var array
         */
        protected $settings = array();
        
        /**
         * @var string
         */
        protected $value = '';
        
        /**
         * @var array
         */
        protected $layers = array( 'margin', 'padding', 'content' );
        
        /**
         * @var array
         */
        protected $positions = array( 'top', 'right', 'bottom', 'left' );
        
        /**
         *
         */
        function __construct() {
        
        
        }

        /**
         * Setters/Getters {{
         *
         * @param null $settings
         *
         * @return array
         */
        function settings( $settings = null ) {
            
            if ( is_array( $settings ) ) {
                $this->settings = $settings;
            }

            return $this->settings;
            
        }
        
        /**
         * @param $key
         *
         * @return string
         */
        function setting( $key ) {
            
            return isset( $this->settings[ $key ] ) ? $this->settings[ $key ] : '';
            
        }

        /**
         * @param null $value
         *
         * @return string
         */
        function value( $value = null ) {
            
            if ( is_string( $value ) ) {
                $this->value = $value;
            }

            return $this->value;
            
        }

        /**
         * @param null $values
         *
         * @return array
         */
        function params( $values = null ) {
            
            if ( is_array( $values ) ) {
                $this->params = $values;
            }

            return $this->params;
            
        }
        
        /**
         * 
         * @return mixed|void
         */
        function render() {
            
            $out  = '<div class="vc_css-editor vc_row vc_ui-flex-row ut-css-editor">';
                
                $out .= '<input id="ut-css-editor" name="' . esc_attr( $this->settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' . esc_attr( $this->settings['param_name'] ) . ' ' . esc_attr( $this->settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $this->value ) . '" />';
                
                $out .= '<div class="vc_layout-onion vc_col-xs-7">';
                    
                    $out .= '<div class="vc_margin">' . $this->layerControls( 'margin' );
                        
                        $out .= '<div class="vc_padding">' . $this->layerControls( 'padding' );
                        
                            $out .= '<div class="vc_content"></div>';
                        
                        $out .= '</div>';
                    
                    $out .= '</div>';
                    
                $out .= '</div>';
        
            $out .= '</div>';
            
            return $out;
        
        }
        
        /**
         * @param $name
         * @param string $prefix
         *
         * @return string
         */
        protected function layerControls( $name, $prefix = '' ) {

            $output = '<label>' . $name . '</label>';

            foreach ( $this->positions as $pos ) {
                
                $output .= '<input type="text" name="' . $name . '_' . $pos . ( '' !== $prefix ? '_' . $prefix : '' ) . '" data-name="' . $name . ( '' !== $prefix ? '-' . $prefix : '' ) . '-' . $pos . '" class="vc_' . $pos . ' ut-css-editor-field" placeholder="-" data-attribute="' . $name . '-' . $pos . '" value="">';
                
            }

            return $output;
            
        }

    }

}
             

/**
 * @param $settings
 * @param $value
 *
 * @return mixed|void
 */
function ut_vc_css_editor_form_field( $settings, $value ) {
    
    $css_editor = new UT_CSS_Editor();
    $css_editor->settings( $settings );
    $css_editor->value( $value );

    return $css_editor->render();

}

vc_add_shortcode_param( 
    'ut_css_editor', 
    'ut_vc_css_editor_form_field',
    UT_SHORTCODES_URL . '/vc/admin/assets/vc_extend/spacing.js'
);







/*
 * Array of available Showcases
 *
 * since 4.4.6
 * version 1.0
 *
 */

if ( !function_exists( 'ut_get_mailchimp_forms' ) ) {
    
    function ut_get_mailchimp_forms() {
        
        if( function_exists('mc4wp_get_forms') ) {
            
            $forms = mc4wp_get_forms();
            $vc    = array();
            
            if( $forms ) {
                
                $vc[esc_html__('Select MailChimp Form', 'ut_shortcodes')] = '';
                
                foreach( $forms as $form ) {
                    
                    $vc[$form->name] = $form->ID;
                        
                }
            
            }
            
            return $vc;
        
        } else {
            
            return array( esc_html__( 'Requires: Mailchimp for WordPress Plugin', 'ut_shortcodes' )  => '' );
            
        }
                
    }

}

/*
 * Array of available Showcases
 *
 * since 4.4.6
 * version 1.0
 */

if ( !function_exists( 'ut_get_showcases' ) ) {
    
    function ut_get_showcases() {
        
        $showcases = get_posts( array(
            'posts_per_page'   => -1,
            'post_type'        => 'portfolio-manager',
            'orderby'          => 'title',
            'order'            => 'ASC',
            'post_status'      => 'publish',
        ) );
        
        $showcases_array = array(
            esc_html__( 'Select Showcase', 'ut_shortcodes' )  => ''
        );
        
        foreach( $showcases as $key => $showcase ) {
            
            $showcases_array[$showcase->post_title] = $showcase->ID;
        
        }
        
        return $showcases_array;
                
    }

}


/*
 * Array of available Menu Cards
 *
 * since 4.4.7
 * version 1.0
 */

if ( !function_exists( 'ut_get_menu_cards' ) ) {
    
    function ut_get_menu_cards() {
        
        $menu_cards = get_posts( array(
            'posts_per_page'   => -1,
            'post_type'        => 'ut-menu-manager',
            'post_status'      => 'publish',
        ) );
        
        $menu_card_array = array(
            esc_html__( 'Select Menu Card', 'ut_shortcodes' )  => ''
        );
        
        foreach( $menu_cards as $key => $menu_card ) {
            
            $menu_card_array[$menu_card->post_title] = $menu_card->ID;
        
        }
        
        return $menu_card_array;
                
    }

}

/*
 * Get Default Font Settings
 *
 * since 4.4.5
 * version 1.0
 */

if ( !function_exists( 'ut_get_theme_options_font_setting' ) ) {
    
    function ut_get_theme_options_font_setting( $element, $attribute, $fallback = NULL ) {
        
        if( function_exists( 'ot_get_option' ) ) {
            
            $settings = array(
                
                'h2'                => array(
                    'font-setting'         => ot_get_option('ut_h2_font_setting' ),
                ),
                
                'h3'                => array(
                    'font-setting'         => ot_get_option('ut_h3_font_setting' ),
                ),
                
                'header_title'      => array(
                    'font-setting'         => ot_get_option('ut_global_headline_font_setting' ),
                ),            
                
                'header_lead'       => array(
                    'font-setting'         => ot_get_option('ut_global_lead_font_setting' ),
                ),
            
            );
        
        } else {
            
            return $fallback;
        
        }
        
        // section title can have different sources
        if( function_exists('ut_responsive_font_settings_support') && $element == 'section_title' ) {
            
            $font_source = ot_get_option( ut_responsive_font_settings_support()['section_title']['type'] );
            $settings['section_title']['font-setting'] = ot_get_option(ut_responsive_font_settings_support()['section_title']['sources'][$font_source] );
            
        }

        // page title can have different sources
        if( function_exists('ut_responsive_font_settings_support') && $element == 'page_title' ) {

            $font_source = ot_get_option( ut_responsive_font_settings_support()['section_title']['type'] );
            $settings['page_title']['font-setting'] = ot_get_option(ut_responsive_font_settings_support()['page_title']['sources'][$font_source] );

        }
        
        // Body Font can have different sources
        if( $element == 'body_font' ) {
            
            $font_source = ot_get_option('ut_body_font_type' );
            
            if( $font_source == 'ut-google' ) {
                
                $settings['body_font']['font-setting'] = ot_get_option('ut_google_body_font_style' );    
                
            } elseif( $font_source == 'ut-websafe' ) {
                
                $settings['body_font']['font-setting'] = ot_get_option('ut_body_websafe_font_style' );
                
            } elseif( $font_source == 'ut-font' ) {
                
                $settings['body_font']['font-setting'] = ot_get_option('ut_body_font_style' );
                
            } elseif( $font_source == 'ut-custom' ) {
                
                $settings['body_font']['font-setting'] = ot_get_option('ut_body_custom_font_style' );
                
            }
            
            
        }
		
		// Body Font can have different sources
        if( $element == 'h3' ) {
            
            $font_source = ot_get_option( 'ut_global_h3_font_type' );
            
            if( $font_source == 'ut-google' ) {
                
                $settings['h3']['font-setting'] = ot_get_option('ut_h3_google_font_style' );    
                
            } elseif( $font_source == 'ut-websafe' ) {
                
                $settings['h3']['font-setting'] = ot_get_option('ut_h3_websafe_font_style' );
                
            } elseif( $font_source == 'ut-font' ) {
                
                $settings['h3']['font-setting'] = ot_get_option('ut_h3_font_style' );
                
            } elseif( $font_source == 'ut-custom' ) {
                
                $settings['h3']['font-setting'] = ot_get_option('ut_h3_custom_font_style' );
                
            }
            
            
        }

	    if( $element == 'site_logo' ) {

		    $font_source = ot_get_option('ut_global_header_text_logo_font_type' );

		    if( $font_source == 'ut-google' ) {

			    $settings['site_logo']['font-setting'] = ot_get_option('ut_global_header_text_google_font_style' );


		    } elseif( $font_source == 'ut-websafe' ) {

			    $settings['site_logo']['font-setting'] = ot_get_option('ut_global_header_text_logo_websafe_font_style' );

		    } elseif( $font_source == 'ut-font' ) {

			    $settings['site_logo']['font-setting'] = ot_get_option('ut_global_header_text_logo_font_style' );

		    } elseif( $font_source == 'ut-custom' ) {

			    $settings['site_logo']['font-setting'] = ot_get_option('ut_global_header_text_logo_custom_font_style' );

		    }

	    }

        if( !empty( $settings[$element]['font-setting'][$attribute] ) ) {
    		
			if( is_numeric( $settings[$element]['font-setting'][$attribute] ) ) {
				
				return $settings[$element]['font-setting'][$attribute];
				
			} else {
				
				return preg_replace("/[^0-9]/","", $settings[$element]['font-setting'][$attribute] );
				
			}
            
        } else {
            
            return $fallback;
            
        }
        
    }

}


/*
 * Array of available Animation Mapping Settings
 *
 * since 4.3
 * version 1.0
 */

if ( !function_exists( '_vc_add_animation_settings' ) ) {
    
    function _vc_add_animation_settings() {
        
        return array(
        
            array(
                'type'              => 'animation_style',
                'heading'           => __( 'Animation Effect', 'ut_shortcodes' ),
                'description'       => __( 'Select image animation effect.', 'ut_shortcodes' ),
                'group'             => 'Animation',
                'param_name'        => 'effect',
                'settings' => array(
                    'type' => array(
                        'in',
                        'out',
                        'other',
                    ),
                )

            ),

            array(
                'type'              => 'textfield',
                'heading'           => esc_html__( 'Animation Duration', 'unitedthemes' ),
                'description'       => esc_html__( 'Animation time in seconds  e.g. 1s', 'unitedthemes' ),
                'param_name'        => 'animation_duration',
                'group'             => 'Animation',
            ), 

            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__( 'Animate Once?', 'unitedthemes' ),
                'description'       => esc_html__( 'Animate only once when reaching the viewport, animate everytime when reaching the viewport or make the animation infinite? By default the animation executes everytime when the element becomes visible in viewport, means when leaving the viewport the animation will be reseted and starts again when reaching the viewport again. By setting this option to yes, the animation executes exactly once. By setting it to infinite, the animation loops all the time, no matter if the element is in viewport or not.', 'unitedthemes' ),
                'param_name'        => 'animate_once',
                'group'             => 'Animation',
                'value'             => array(
                    esc_html__( 'yes', 'unitedthemes' ) => 'yes',
                    esc_html__( 'no' , 'unitedthemes' ) => 'no',
                    esc_html__( 'infinite', 'unitedthemes' ) => 'infinite',
                )
            ),  

            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__( 'Animate Image on Tablet?', 'ut_shortcodes' ),
                'param_name'        => 'animate_tablet',
                'group'             => 'Animation',
                'edit_field_class'  => 'vc_col-sm-6',
                'value'             => array(
                    esc_html__( 'no', 'ut_shortcodes' ) => 'false',
                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true'
                ),
            ),

            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__( 'Animate Image on Mobile?', 'ut_shortcodes' ),
                'param_name'        => 'animate_mobile',
                'group'             => 'Animation',
                'edit_field_class'  => 'vc_col-sm-6',
                'value'             => array(
                    esc_html__( 'no', 'ut_shortcodes' ) => 'false',
                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true'
                ),
            ),                            

            array(
                'type'              => 'dropdown',
                'heading'           => esc_html__( 'Delay Animation?', 'ut_shortcodes' ),
                'description'       => esc_html__( 'Time in milliseconds until the image appears. e.g. 200', 'ut_shortcodes' ),
                'param_name'        => 'delay',
                'group'             => 'Animation',
                'edit_field_class'  => 'vc_col-sm-6',
                'value'             => array(
                    esc_html__( 'no', 'ut_shortcodes' ) => 'false',
                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true'                                                                        
                )
            ),

            array(
                'type'              => 'textfield',
                'heading'           => esc_html__( 'Delay Timer', 'ut_shortcodes' ),
                'description'       => esc_html__( 'Time in milliseconds until the next image appears. e.g. 200', 'ut_shortcodes' ),
                'param_name'        => 'delay_timer',
                'group'             => 'Animation',
                'edit_field_class'  => 'vc_col-sm-6',
                'dependency'        => array(
                    'element' => 'delay',
                    'value'   => 'true',
                )
            ), 
            
        );
                
    }

}


/*
 * Array of available Contact Form 7 Forms
 *
 * since 4.6
 * version 1.0
 */

if ( !function_exists( 'ut_get_c7_forms' ) ) {
    
    function ut_get_c7_forms() {
        
        if( class_exists('WPCF7_ContactForm') ) {
            
            $forms = get_posts( array(
                'posts_per_page'   => -1,
                'post_type'        => 'wpcf7_contact_form',
                'post_status'      => 'publish',
            ) );
            
            $forms_array = array(
                esc_html__( 'Select Contact Form 7', 'ut_shortcodes' )  => ''
            );
            
            foreach( $forms as $key => $form ) {
                
                $forms_array[$form->post_title] = $form->ID;
            
            }
            
            return $forms_array;
        
        } else {
            
            return array( esc_html__( 'Requires: Contact Form 7 Plugin', 'ut_shortcodes' )  => '' );
            
        }
                
    }

}


/*
 * Array of available Custom Fonts
 *
 * since 4.6.3
 * version 1.0
 */

if ( !function_exists( 'ut_get_custom_fonts' ) ) {
    
    function ut_get_custom_fonts() {
            
		$taxonomies = get_terms( array( 'hide_empty' => false, 'taxonomy' => 'unite_custom_fonts' ) );
		
		$fonts_array = array(
			esc_html__( 'Select Custom Font', 'ut_shortcodes' )  => ''
		);
		
		if ( !is_wp_error( $taxonomies ) && $taxonomies ) {
		
			foreach( $taxonomies as $key => $taxonomy ) {
				
				$fonts_array[$taxonomy->name] = $taxonomy->term_id;

			}

		}
		
		return $fonts_array;
                
    }

}

/*
 * Array of available Contact Blocks
 *
 * since 4.6.1
 * version 1.0
 */

if ( !function_exists( 'ut_get_content_blocks' ) ) {
    
    function ut_get_content_blocks() {
            
		$content_blocks = get_posts( array(
			'posts_per_page'   => -1,
			'post_type'        => 'ut-content-block',
			'post_status'      => 'publish',
		) );

		$block_array = array(
			esc_html__( 'Select Content Block', 'ut_shortcodes' )  => ''
		);
		
		if( $content_blocks ) {
		
			foreach( $content_blocks as $key => $block ) {

				$block_array[$block->post_title] = $block->ID;

			}

		}
			
		return $block_array;        
                
    }

}

/*
 * Sort Add Element
 *
 * since 4.6
 * version 1.0
 */

if ( !function_exists( '_ut_sort_vc_add_new_elements_to_box' ) ) {
    
    function _ut_sort_vc_add_new_elements_to_box( $boxes ) {
        
        $sort = array();
        
        if( class_exists('WPBMap') ) {
            $categories = WPBMap::getUserCategories();
        }

        foreach( $categories as $category ) {
        
            foreach( $boxes as $key => $box ) {
                
                if( isset( $box['deprecated'] ) && $box['deprecated'] ) {
                    
                    $sort[$key] = $box;
                    continue;
                    
                }

                if( !isset( $box['category'] ) ) {

                    $boxes[$key]['category'] = '_other_category_';
                    $box['category'] = '_other_category_';

                }

                if( is_array( $box['category'] ) && isset( $box['category'][0] ) && $box['category'][0] == $category ) {

                    $sort[$key] = $box;

                }

                if( $box['category'] == $category ) {
                    
                    $sort[$key] = $box;
                    
                }
                
            }
        
        }
        
        return $sort;
        
    }
    
    add_filter( 'vc_add_new_elements_to_box', '_ut_sort_vc_add_new_elements_to_box' );
    
}  


/*
 * Array of available Button Particle Effects
 *
 * since 4.6.5
 * version 1.0
 */

if ( !function_exists( 'ut_get_button_particle_effects' ) ) {
    
    function ut_get_button_particle_effects() {
        
		$effects = array(
			
			esc_html__( 'Send', 'ut_shortcodes' )  	 	 => 'send',
			esc_html__( 'Upload', 'ut_shortcodes' )  	 => 'upload',
			esc_html__( 'Delete', 'ut_shortcodes' )  	 => 'delete',
			esc_html__( 'Submit', 'ut_shortcodes' )  	 => 'submit',
			esc_html__( 'Refresh', 'ut_shortcodes' ) 	 => 'refresh',
			esc_html__( 'Bookmark', 'ut_shortcodes' )  	 => 'bookmark',
			esc_html__( 'Subscribe', 'ut_shortcodes' )	 => 'subscribe',
			esc_html__( 'Add to Cart', 'ut_shortcodes' ) => 'addtocart',
			esc_html__( 'Logout', 'ut_shortcodes' ) 	 => 'logout',
			esc_html__( 'Pause', 'ut_shortcodes' ) 	 	 => 'pause',
			esc_html__( 'Register', 'ut_shortcodes' ) 	 => 'register',
			esc_html__( 'Export', 'ut_shortcodes' )  	 => 'export',
			
		);	
		
		return apply_filters( 'ut_button_particle_effects', $effects );
                
    }

}

/*
 * File Picker Param
 *
 * since 4.9.1.1
 * version 1.0
 */

class UT_Filepicker_Param
{

    /**
     * @var array
     */
    protected $settings = array();

    /**
     * @var string
     */
    protected $value = '';


    function __construct($settings, $value)
    {

        $this->settings = $this->settings($settings);
        $this->value = $this->value($value);

    }

    /**
     * Settings
     *
     * @param null $settings
     *
     * @return array
     */

    function settings($settings = null)
    {

        if (is_array($settings)) {
            $this->settings = $settings;
        }

        return $this->settings;

    }

    /**
     * @param null $value
     *
     * @return string
     */
    function value($value = null)
    {

        if (is_string($value)) {
            $this->value = $value;
        }

        return $this->value;

    }


    function render()
    {

        // out
        $out = '';

        // button classes
        $select_file_class = '';
        $remove_file_class = ' hidden';

        // get attachment
        $attachment_url = wp_get_attachment_url($this->value);

        if ($attachment_url) {

            $select_file_class = ' hidden';
            $remove_file_class = '';

        }

        $out .= '<div class="ut-file-picker">';

        // Image
        $out .= '<div class="' . esc_attr($this->settings['type']) . '-display">';

        $out .= basename($attachment_url);
        // $out .= $attachment_url;

        $out .= '</div>';

        // Input
        $out .= '<input type="hidden" name="' . esc_attr($this->settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput ' . esc_attr($this->settings['param_name']) . ' ' . esc_attr($this->settings['type']) . '_field" value="' . esc_attr($this->value) . '" />';

        // Buttons
        $out .= '<button class="button ut-file-picker-button' . $select_file_class . '">' . __('Select File', 'ut_shortcodes') . '</button>';
        $out .= '<button class="button ut-file-remove-button' . $remove_file_class . '">' . __('Remove File', 'ut_shortcodes') . '</button>';


        $out .= '</div>';

        return $out;

    }

}


/**
 * File Picker
 *
 * @param $settings
 * @param $value
 *
 * @return mixed
 */

function ut_add_vc_filepicker_param_type($settings, $value) {

    $filepicker = new UT_Filepicker_Param($settings, $value);
    return $filepicker->render();

}

vc_add_shortcode_param(
    'filepicker',
    'ut_add_vc_filepicker_param_type',
    UT_SHORTCODES_URL . '/vc/admin/assets/vc_extend/filepicker.js'
);


/*
 * United Themes Info
 *
 * since 4.9.4.2
 * version 1.0
 */

class UT_Info_Box
{

    /**
     * @var array
     */
    protected $settings = array();

    /**
     * @var string
     */
    protected $value = '';


    function __construct($settings, $value)
    {

        $this->settings = $this->settings($settings);
        $this->value = $this->value($value);

    }

    /**
     * Settings
     *
     * @param null $settings
     *
     * @return array
     */

    function settings($settings = null) {

        if (is_array($settings)) {
            $this->settings = $settings;
        }

        return $this->settings;

    }

    /**
     * @param null $value
     *
     * @return string
     */

    function value($value = null) {

        if (is_string($value)) {
            $this->value = $value;
        }

        return $this->value;

    }

    /**
     *
     * @return mixed
     */

    function render() {

        $out = '<div class="ut-option-field-notification">';

        $out .= $this->settings["info"];
        $out .= '<input type="hidden" name="' . esc_attr($this->settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput ' . esc_attr($this->settings['param_name']) . ' ' . esc_attr($this->settings['type']) . '_field" value="' . esc_attr($this->value) . '" />';

        $out .= '</div>';

        return $out;

    }

}

function ut_vc_info_box_field($settings, $value) {

    $info_box = new UT_Info_Box($settings, $value);
    return $info_box->render();

}

vc_add_shortcode_param(
    'ut_info_box',
    'ut_vc_info_box_field'
);


/*
 * United Themes Option Separator
 *
 * since 4.9.4.2
 * version 1.0
 */

class UT_Option_Separator
{

    /**
     * @var array
     */
    protected $settings = array();

    /**
     * @var string
     */
    protected $value = '';


    function __construct($settings, $value)
    {

        $this->settings = $this->settings($settings);
        $this->value = $this->value($value);

    }

    /**
     * Settings
     *
     * @param null $settings
     *
     * @return array
     */

    function settings($settings = null) {

        if (is_array($settings)) {
            $this->settings = $settings;
        }

        return $this->settings;

    }

    /**
     * @param null $value
     *
     * @return string
     */

    function value( $value = null ) {

        if( is_string( $value ) ) {
            $this->value = $value;
        }

        return $this->value;

    }

    /**
     *
     * @return mixed
     */

    function render() {

        $out = '<div class="ut-option-separator">';

        $out .= '<div class="ut-option-separator-label">' . $this->settings["info"]. '</div>';
        $out .= '<input type="hidden" name="' . esc_attr($this->settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput ' . esc_attr($this->settings['param_name']) . ' ' . esc_attr($this->settings['type']) . '_field" value="' . esc_attr($this->value) . '" />';

        $out .= '</div>';

        return $out;

    }

}

function ut_vc_option_separator_field($settings, $value) {

    $info_box = new UT_Option_Separator($settings, $value);
    return $info_box->render();

}

vc_add_shortcode_param(
    'ut_option_separator',
    'ut_vc_option_separator_field'
);



/*
 * Media Title Param
 *
 * since 4.6
 * version 1.0
 */

if ( ! class_exists( 'UT_Media_Title_Param' ) ) {

	class UT_Media_Title_Param {

		/**
		 * @var array
		 */
		protected $settings = array();


		/**
		 * @var string
		 */
		protected $value = '';


		function __construct( $settings, $value ) {

			$this->settings = $this->settings( $settings );
			$this->value    = $this->value( $value );

		}

		/**
		 * Settings
		 *
		 * @param null $settings
		 *
		 * @return array
		 */
		function settings( $settings = null ) {

			if ( is_array( $settings ) ) {
				$this->settings = $settings;
			}

			return $this->settings;

		}

		/**
		 * @param null $value
		 *
		 * @return string
		 */
		function value( $value = null ) {

			if ( is_string( $value ) ) {
				$this->value = $value;
			}

			return $this->value;

		}


		function render() {

			$out = '<div class="ut-datetimepicker-wrap">';

			$out .= '<input name="' . esc_attr( $this->settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ut-datetimepicker ' . esc_attr( $this->settings['param_name'] ) . ' ' . esc_attr( $this->settings['type'] ) . '_field" type="text" value="' . esc_attr( $this->value ) . '" />';

			$out .= '</div>';

			return $out;

		}

	}

}

/**
 * Datepicker
 *
 * @param $settings
 * @param $value
 *
 * @return mixed|void
 */
function ut_add_vc_media_title_param_type( $settings, $value ) {

	$section_anchor = new UT_Media_Title_Param( $settings, $value );
	return $section_anchor->render();

}

if( defined( 'WPB_VC_VERSION' ) ) {

	vc_add_shortcode_param(
		'media-title',
		'ut_add_vc_media_title_param_type',
		UT_SHORTCODES_URL . '/vc/admin/assets/vc_extend/media-library.js'
	);

}
