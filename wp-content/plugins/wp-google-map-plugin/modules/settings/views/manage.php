<?php
/**
 * This class used to manage settings page in backend.
 * @author Flipper Code <hello@flippercode.com>
 * @version 4.1.6
 * @package Maps
 */

$form  = new WPGMP_Template();
$form->form_action = esc_url ( add_query_arg( 'page', 'wpgmp_manage_settings', admin_url ('admin.php') )  );
$form->set_header( esc_html__( 'General Setting(s)', 'wp-google-map-plugin' ), $response, $enable_accordion = false );

$form->add_element( 'group', 'wpgmp_general_settings', array(
	'value' => esc_html__( 'General Setting(s)', 'wp-google-map-plugin' ),
	'before' => '<div class="fc-12">',
	'after' => '</div>',
));

$link = '<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">'.esc_html__("Create Google Maps Api Key","wp-google-map-plugin").'</a>';


$form->set_col( 2 );

$form->add_element('text','wpgmp_api_key',array(
	'lable' => esc_html__( 'Google Maps API Key','wp-google-map-plugin' ),
	'value' => get_option( 'wpgmp_api_key' ),
	'before' => '<div class="fc-6">',
	'after'  => '</div>',
	'desc'  => sprintf( esc_html__( 'Create the right API key for your website. %1$s', 'wp-google-map-plugin' ), $link ),
));

$key_url = 'http://bit.ly/29Rlmfc';

if ( get_option( 'wpgmp_api_key' ) == '' ) {

	$generate_link = '<a onclick=\'window.open("' . wp_slash( $key_url ) . '", "newwindow", "width=700, height=600"); return false;\' href=\'' . $key_url . '\' class="wpgmp_key_btn fc-btn fc-btn-default btn-lg" >' . esc_html__( 'Generate API Key', 'wpgmp-google-map' ) . '</a>';

	$form->add_element(
		'html', 'wpgmp_key_btn', array(
			'html'   => $generate_link,
			'before' => '<div class="fc-2">',
			'after'  => '</div>',
		)
	);

} else {

	$generate_link = '<a href="javascript:void(0);" class="wpgmp_check_key fc-btn fc-btn-default btn-lg" >' . esc_html__( 'Test API Key', 'wpgmp-google-map' ) . '</a><span class="wpgmp_maps_preview"></span>';

	$form->add_element(
		'html', 'wpgmp_key_btn', array(
			'html'   => $generate_link,
			'before' => '<div class="fc-2">',
			'after'  => '</div>',
		)
	);
}

$form->set_col( 1 );


$language = array(
'en' => esc_html__( 'ENGLISH', 'wp-google-map-plugin' ),
'ar' => esc_html__( 'ARABIC', 'wp-google-map-plugin' ),
'eu' => esc_html__( 'BASQUE', 'wp-google-map-plugin' ),
'bg' => esc_html__( 'BULGARIAN', 'wp-google-map-plugin' ),
'bn' => esc_html__( 'BENGALI', 'wp-google-map-plugin' ),
'ca' => esc_html__( 'CATALAN', 'wp-google-map-plugin' ),
'cs' => esc_html__( 'CZECH', 'wp-google-map-plugin' ),
'da' => esc_html__( 'DANISH', 'wp-google-map-plugin' ),
'de' => esc_html__( 'GERMAN', 'wp-google-map-plugin' ),
'el' => esc_html__( 'GREEK', 'wp-google-map-plugin' ),
'en-AU' => esc_html__( 'ENGLISH (AUSTRALIAN)', 'wp-google-map-plugin' ),
'en-GB' => esc_html__( 'ENGLISH (GREAT BRITAIN)', 'wp-google-map-plugin' ),
'es' => esc_html__( 'SPANISH', 'wp-google-map-plugin' ),
'fa' => esc_html__( 'FARSI', 'wp-google-map-plugin' ),
'fi' => esc_html__( 'FINNISH', 'wp-google-map-plugin' ),
'fil' => esc_html__( 'FILIPINO', 'wp-google-map-plugin' ),
'fr' => esc_html__( 'FRENCH', 'wp-google-map-plugin' ),
'gl' => esc_html__( 'GALICIAN', 'wp-google-map-plugin' ),
'gu' => esc_html__( 'GUJARATI', 'wp-google-map-plugin' ),
'hi' => esc_html__( 'HINDI', 'wp-google-map-plugin' ),
'hr' => esc_html__( 'CROATIAN', 'wp-google-map-plugin' ),
'hu' => esc_html__( 'HUNGARIAN', 'wp-google-map-plugin' ),
'id' => esc_html__( 'INDONESIAN', 'wp-google-map-plugin' ),
'it' => esc_html__( 'ITALIAN', 'wp-google-map-plugin' ),
'iw' => esc_html__( 'HEBREW', 'wp-google-map-plugin' ),
'ja' => esc_html__( 'JAPANESE', 'wp-google-map-plugin' ),
'kn' => esc_html__( 'KANNADA', 'wp-google-map-plugin' ),
'ko' => esc_html__( 'KOREAN', 'wp-google-map-plugin' ),
'lt' => esc_html__( 'LITHUANIAN', 'wp-google-map-plugin' ),
'lv' => esc_html__( 'LATVIAN', 'wp-google-map-plugin' ),
'ml' => esc_html__( 'MALAYALAM', 'wp-google-map-plugin' ),
'it' => esc_html__( 'ITALIAN', 'wp-google-map-plugin' ),
'mr' => esc_html__( 'MARATHI', 'wp-google-map-plugin' ),
'nl' => esc_html__( 'DUTCH', 'wp-google-map-plugin' ),
'no' => esc_html__( 'NORWEGIAN', 'wp-google-map-plugin' ),
'pl' => esc_html__( 'POLISH', 'wp-google-map-plugin' ),
'pt' => esc_html__( 'PORTUGUESE', 'wp-google-map-plugin' ),
'pt-BR' => esc_html__( 'PORTUGUESE (BRAZIL)', 'wp-google-map-plugin' ),
'pt-PT' => esc_html__( 'PORTUGUESE (PORTUGAL)', 'wp-google-map-plugin' ),
'ro' => esc_html__( 'ROMANIAN', 'wp-google-map-plugin' ),
'ru' => esc_html__( 'RUSSIAN', 'wp-google-map-plugin' ),
'sk' => esc_html__( 'SLOVAK', 'wp-google-map-plugin' ),
'sl' => esc_html__( 'SLOVENIAN', 'wp-google-map-plugin' ),
'sr' => esc_html__( 'SERBIAN', 'wp-google-map-plugin' ),
'sv' => esc_html__( 'SWEDISH', 'wp-google-map-plugin' ),
'tl' => esc_html__( 'TAGALOG', 'wp-google-map-plugin' ),
'ta' => esc_html__( 'TAMIL', 'wp-google-map-plugin' ),
'te' => esc_html__( 'TELUGU', 'wp-google-map-plugin' ),
'th' => esc_html__( 'THAI', 'wp-google-map-plugin' ),
'tr' => esc_html__( 'TURKISH', 'wp-google-map-plugin' ),
'uk' => esc_html__( 'UKRAINIAN', 'wp-google-map-plugin' ),
'vi' => esc_html__( 'VIETNAMESE', 'wp-google-map-plugin' ),
'zh-CN' => esc_html__( 'CHINESE (SIMPLIFIED)', 'wp-google-map-plugin' ),
'zh-TW' => esc_html__( 'CHINESE (TRADITIONAL)', 'wp-google-map-plugin' ),
);

$form->add_element( 'select', 'wpgmp_language', array(
	'lable' => esc_html__( 'Map Language', 'wp-google-map-plugin' ),
	'current' => get_option( 'wpgmp_language' ),
	'desc' => esc_html__( 'Choose your language for map. Default language is English.', 'wp-google-map-plugin' ),
	'options' => $language,
	'before' => '<div class="fc-6">',
	'after' => '</div>',
));

$form->add_element( 'radio', 'wpgmp_scripts_place', array(
	'lable' => esc_html__( 'Include Scripts in ', 'wp-google-map-plugin' ),
	'radio-val-label' => array( 'header' => esc_html__( 'Header','wp-google-map-plugin' ),'footer' => esc_html__( 'Footer (Recommended)','wp-google-map-plugin' ) ),
	'current' => get_option( 'wpgmp_scripts_place' ),
	'class' => 'chkbox_class',
	'default_value' => 'footer',
));

$form->add_element('submit','wpgmp_save_settings',array(
	'value' => esc_html__( 'Save Settings','wp-google-map-plugin' ),
	));
$form->add_element('hidden','operation',array(
	'value' => 'save',
	));
$form->add_element('hidden','page_options',array(
	'value' => 'wpgmp_api_key,wpgmp_scripts_place',
	));
$form->render();
