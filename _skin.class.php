<?php
/**
 * This file implements a class derived of the generic Skin class in order to provide custom code for
 * the skin in this folder.
 *
 * This file is part of the b2evolution project - {@link http://b2evolution.net/}
 *
 * @package skins
 * @subpackage bootstrap_blog
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

/**
 * Specific code for this skin.
 *
 * ATTENTION: if you make a new skin you have to change the class name below accordingly
 */
class bricks_Skin extends Skin
{
	/**
	 * Skin version
	 * @var string
	 */
	var $version = '1.0';

	/**
	 * Do we want to use style.min.css instead of style.css ?
	 */
	var $use_min_css = 'check';  // true|false|'check' Set this to true for better optimization
	// Note: we leave this on "check" in the bootstrap_blog_skin so it's easier for beginners to just delete the .min.css file
	// But for best performance, you should set it to true.

	/**
	 * Get default name for the skin.
	 * Note: the admin can customize it.
	 */
	function get_default_name()
	{
		return 'Bricks Skin';
	}


	/**
	 * Get default type for the skin.
	 */
	function get_default_type()
	{
		return 'normal';
	}


	/**
	 * What evoSkins API does has this skin been designed with?
	 *
	 * This determines where we get the fallback templates from (skins_fallback_v*)
	 * (allows to use new markup in new b2evolution versions)
	 */
	function get_api_version()
	{
		return 6;
	}


	/**
	 * What CSS framework does has this skin been designed with?
	 *
	 * This may impact default markup returned by Skin::get_template() for example
	 */
	function get_css_framework()
	{
		return 'bootstrap';
	}

	/**
	* Get supported collection kinds.
	*
	* This should be overloaded in skins.
	*
	* For each kind the answer could be:
	* - 'yes' : this skin does support that collection kind (the result will be was is expected)
	* - 'partial' : this skin is not a primary choice for this collection kind (but still produces an output that makes sense)
	* - 'maybe' : this skin has not been tested with this collection kind
	* - 'no' : this skin does not support that collection kind (the result would not be what is expected)
	* There may be more possible answers in the future...
	*/
	public function get_supported_coll_kinds()
	{
		$supported_kinds = array(
			'main'   => 'no',
			'std'    => 'yes',		// Blog
			'photo'  => 'yes',
			'forum'  => 'no',
			'manual' => 'maybe',
			'group'  => 'no',  // Tracker
			// Any kind that is not listed should be considered as "maybe" supported
		);
		return $supported_kinds;
	}


	/**
	 * Get definitions for editable params
	 *
	 * @see Plugin::GetDefaultSettings()
	 * @param local params like 'for_editing' => true
	 * @return array
	 */
	function get_param_definitions( $params )
	{
		global $Blog;

		// Load to use function get_available_thumb_sizes();
		load_funcs( 'files/model/_image.funcs.php' );
		load_class( 'widgets/model/_widget.class.php', 'ComponentWidget' );


		$r = array_merge( array(

			/* LAYOUT OPTIONS
			 * ========================================================================== */
			'section_layout_start' => array(
				'layout' => 'begin_fieldset',
				'label'  => T_('General Settings'),
			),
				'layout' => array(
					'label' => T_('Layout'),
					'note' => '',
					'defaultvalue' => 'single_column',
					'options' => array(
						'single_column'              => T_('Single Column Large'),
						'single_column_normal'       => T_('Single Column'),
						'single_column_narrow'       => T_('Single Column Narrow'),
						'single_column_extra_narrow' => T_('Single Column Extra Narrow'),
						'left_sidebar'               => T_('Left Sidebar'),
						'right_sidebar'              => T_('Right Sidebar'),
					),
					'type' => 'select',
				),
				'max_image_height' => array(
					'label' 		=> T_('Max image height'),
					'note' 			=> 'px. ' . T_('Set maximum height for post images.'),
					'defaultvalue' 	=> '',
					'type' 			=> 'integer',
					'allow_empty' 	=> true,
				),
				'font_size' => array(
					'label' 		=> T_('Font size'),
					'note' 			=> '',
					'defaultvalue'  => 'default',
					'options' => array(
						'default'        => T_('Default').' (14px)',
						'standard'       => T_('Standard').' (16px)',
						'medium'         => T_('Medium').' (18px)',
						'large'          => T_('Large').' (20px)',
						'very_large'     => T_('Very large').' (22px)',
					),
					'type' => 'select',
				),
				'back_to_top' => array(
					'label'			=> T_( 'Back To Top Button' ),
					'note'			=> T_( 'Check to display "Back to Top" button.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
			'section_layout_end' => array(
				'layout' => 'end_fieldset',
			),


			/* CUSTOM COLOR OPTIONS
			 * ========================================================================== */
			'section_color_start' => array(
				'layout' => 'begin_fieldset',
				'label'  => T_('Custom Settings'),
			),
				'page_bg_color' => array(
					'label' 		=> T_('Background color'),
					'note' 			=> T_('Default value is').' <code>#ffffff</code>.',
					'defaultvalue'  => '#ffffff',
					'type' 			=> 'color',
				),
				'page_text_color' => array(
					'label' 		=> T_('Content color'),
					'note' 			=> T_('Default value is').' <code>#7e8082</code>.',
					'defaultvalue' 	=> '#7e8082',
					'type' 			=> 'color',
				),
				'page_link_color' => array(
					'label' 		=> T_('Link color'),
					'note' 			=> T_('Default value is').' <code>#4b4e53</code>.',
					'defaultvalue' 	=> '#4b4e53',
					'type' 			=> 'color',
				),
				'page_hover_link_color' => array(
					'label' 		=> T_('Hover link color'),
					'note' 			=> T_('Default value is').' <code>#101010</code>.',
					'defaultvalue' 	=> '#101010',
					'type' 			=> 'color',
				),
				// 'color_heading' => array(
					// 'label' 		=> T_('Title Color'),
					// 'note' 			=> T_('Default value is').' <code>#4b4e53</code>.',
					// 'defaultvalue' 	=> '#4b4e53',
					// 'type' 			=> 'color',
				// ),
				'panel_color' => array(
					'label'			=> T_( 'Panel Content Color' ),
					'note'			=> T_( 'Default value is' ).'  <code>#7e8082</code>.',
					'type'			=> 'color',
					'defaultvalue' 	=> '#7e8082'
				),
				'bgimg_text_color' => array(
					'label' 		=> T_('Text color on background image'),
					'note' 			=> T_('Default value is').' <code>#ffffff</code>.',
					'defaultvalue' 	=> '#ffffff',
					'type' 			=> 'color',
				),
				'bgimg_link_color' => array(
					'label' 		=> T_('Link color on background image'),
					'note' 			=> T_('Default value is').' <code>#6cb2ef</code>.',
					'defaultvalue' 	=> '#6cb2ef',
					'type' 			=> 'color',
				),
				'bgimg_hover_link_color' => array(
					'label' 		=> T_('Hover link color on background image'),
					'note' 			=> T_('Default value is').' <code>#6cb2ef</code>.',
					'defaultvalue'  => '#6cb2ef',
					'type' 			=> 'color',
				),
			'section_color_end' => array(
				'layout' => 'end_fieldset',
			),


			/* NAVIGATION OPTIONS
			* ========================================================================== */
			'section_nav_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Navigation Settings' ),
			),
				'nav_background' => array(
					'label'			=> T_( 'Background Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#ffffff</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#ffffff',
				),
				'nav_color_link'	=> array(
					'label'			=> T_( 'Menu Links Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#4b4e53</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#4b4e53'
				),
				'nav_color_link_hover' => array(
					'label'			=> T_( 'Menu Links Hover Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#111111</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#111111'
				),
				'nav_search_icon' => array(
					'label'			=> T_( 'Enable Search Icon' ),
					'note'			=> T_( 'Check to enable search icon in main menu.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),

			'section_stickynav_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Sticky Navigation Settings' ),
			),
				'nav_sticky' => array(
					'label'			=> T_( 'Enable Sticky Menu' ),
					'note'			=> T_( 'Check to enable sticky (fixed) navigation when scrolling.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'nav_background_sticky' => array(
					'label'			=> T_( 'Sticky Menu Background Color' ),
					'note'			=> T_( 'Set menu background color on scroll when "Sticky menu" option is enabled.' ) . ' ' . T_( 'Default value is' ).' <code>#ffffff</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#ffffff',
				),
				'nav_color_link_sticky'	=> array(
					'label'			=> T_( 'Sticky Menu Links Color' ),
					'note'			=> T_( 'Set menu links color on scroll when "Sticky menu" option is enabled.' ) . ' ' . T_( 'Default value is' ).' <code>#4b4e53</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#4b4e53'
				),
				'nav_color_link_hover_sticky' => array(
					'label'			=> T_( 'Sticky Menu Links Hover Color' ),
					'note'			=> T_( 'Set menu links hover color on scroll when "Sticky menu" option is enabled.' ) . ' ' . T_( 'Default value is' ).' <code>#111111</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#111111'
				),
			'section_stickynav_end' => array(
				'layout'	=> 'end_fieldset',
			),

			'section_transparentnav_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Transparent Navigation Settings' ),
			),
				'nav_bg_transparent' => array(
					'label'			=> T_( 'Transparent Background' ),
					'note'			=> T_( 'Check to enable transparent menu background.') . ' ' . T_('It will work with').' <strong>'.T_('Main Header Style').'</strong>.',
					'type'			=> 'checkbox',
					'defaultvalue'	=> 0,
				),
				'nav_cl_transparent' => array(
					'label'			=> T_( 'Transparent Menu Links Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#ffffff</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#ffffff',
				),
				'nav_clh_transparent' => array(
					'label'			=> T_( 'Transparent Menu Hover Links Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#ff3b3b</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#ff3b3b',
				),
			'section_transparentnav_end' => array(
				'layout'	=> 'end_fieldset',
			),
			
			'section_nav_end' => array(
				'layout'	=> 'end_fieldset',
			),


			/* MAIN HEADER OPTIONS
			* ========================================================================== */
			'section_header_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Main Header Settings' ),
			),
				'header_padding_top' => array(
					'label'			=> T_( 'Top Padding' ),
					'note'			=> 'px. ' . T_( 'Default value is' ).' <code>320px</code>.',
					'type'			=> 'integer',
					'allow_empty'	=> false,
					'defaultvalue'	=> '320',
					'size'			=> 4,
				),
				'header_content_mode' => array(
					'label'			=> T_( 'Header Content Mode' ),
					'note'			=> T_( 'Default value is').' <code>' . T_( 'Floated Content' ) . '</code>.',
					'type'			=> 'select',
					'options'		=> array(
						'col-md-6 float'	=> T_( 'Floated Content' ),
						'col-md-12 center'	=> T_( 'Centered Content' ),
					),
					'defaultvalue'	=> 'col-md-6 float'
				),
				'header_breadcrumb' => array(
					'label'			=> T_( 'Enable Breadcrumb' ),
					'note'			=> T_( 'Check to enable Breadcrumb in Header.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'header_bg_image' => array(
					'label' 		=> T_('Background image'),
					'note' 			=> T_('Set background image for Main Header.'),
					'type' 			=> 'fileselect',
					'initialize_with' => 'skins/bricks_skin/assets/images/header/header-6.jpg',
					'thumbnail_size' => 'fit-320x320',
				),
				'header_bg_pos_x' => array(
					'label'			=> T_( 'Horizontal Background Position' ),
					'note'			=> '%. '. T_( 'Default value is' ).' <code>50%</code>.',
					'type'			=> 'integer',
					'allow_empty'	=> false,
					'size'			=> 3,
					'defaultvalue'	=> 50,
				),
				'header_bg_pos_y' => array(
					'label'			=> T_( 'Vertical Background Position' ),
					'note'			=> '%. '.T_( 'Default value is' ).' <code>50%</code>.',
					'type'			=> 'integer',
					'allow_empty'	=> false,
					'size'			=> 3,
					'defaultvalue'	=> 50,
				),
				'header_bg_attachment'	=> array(
					'label'			=> T_( 'Background Attachment' ),
					'note'			=> T_( '' ),
					'type'			=> 'select',
					'options'		=> array(
						'initial' 	=> 	T_( 'Default' ),
						'fixed'		=> 	T_( 'Fixed' ),
					),
					'defaultvalue'	=> 'initial',
				),
				'header_overlay' => array(
					'label'			=> T_( 'Enable Overlay Color' ),
					'note'			=> T_( 'Check to enable overlay color for header section.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'header_color_overlay' => array(
					'label'			=> T_( 'Overlay Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#000000</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#000000'
				),
				'header_co_opacity' => array(
					'label'			=> T_( 'Overlay Color Opacity' ),
					'note'			=> T_( 'Default value is' ).' <code>0.5</code>.',
					'type'			=> 'select',
					'options'		=> array(
						'0'		=> '0',
						'0.05'	=> '0.5',
						'0.1'	=> '0.1',
						'0.15'	=> '0.15',
						'0.2'	=> '0.2',
						'0.25'	=> '0.25',
						'0.3'	=> '0.3',
						'0.35'	=> '0.35',
						'0.4'	=> '0.4',
						'0.45'	=> '0.45',
						'0.5'	=> '0.5',
						'0.55'	=> '0.55',
						'0.6'	=> '0.6',
						'0.65'	=> '0.65',
						'0.7'	=> '0.7',
						'0.75'	=> '0.75',
						'0.8'	=> '0.8',
						'0.85'	=> '0.85',
						'0.9'	=> '0.9',
						'0.95'	=> '0.95',
						'1'		=> '0.1',
					),
					'defaultvalue'	=> '0.5'
				),
			'section_header_end' => array(
				'layout'	=> 'end_fieldset',
			),

			/* HEADER PAGE
			 * ========================================================================== */
			'section_header_page_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Custom Header Settings' ),
			),
				'header_page_bg' => array(
					'label'			=> T_( 'Header Background' ),
					'note'			=> T_( 'Default value is' ).' <code>#eeeeee</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#eeeeee',
				),
				'header_page_color_content' => array(
					'label'			=> T_( 'Header Content Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#4b4e53</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#4b4e53'
				),
				'header_page_pt' => array(
					'label'			=> T_( 'Padding Top' ),
					'note'			=> T_( 'px. Default value is' ).' <code>80px</code>.',
					'type'			=> 'text',
					'defaultvalue'	=> '80',
					'size'			=> 4,
				),
				'header_page_pb' => array(
					'label'			=> T_( 'Padding Bottom' ),
					'note'			=> T_( 'px. Default value is' ).' <code>60px</code>.',
					'type'			=> 'text',
					'defaultvalue'	=> '60',
					'size'			=> 4,
				),
				'header_page_content_mode' => array(
					'label'			=> T_( 'Header Content Mode' ),
					'note'			=> T_( 'Default value is' ).' <code>' . T_( 'Floated Mode' ) . '</code>.',
					'type'			=> 'select',
					'options'		=> array(
						'col-md-6 float'	=> T_( 'Floated Mode' ),
						'col-md-12 center'	=> T_( 'Centered Mode' ),
					),
					'defaultvalue'	=> 'col-md-6 float'
				),
			'section_header_page_end' => array(
				'layout'	=> 'end_fieldset',
			),

			/* POSTS SETTINGS
			 * ========================================================================== */
			'section_posts_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Posts Settings' ).' (disp=posts)',
			),
				'posts_header' => array(
					'label'			=> T_( 'Header Style' ),
					'note'			=> T_( 'Default value is' ).' <code>' . T_( 'Main Header' ) . '</code>.',
					'type'			=> 'select',
					'options'		=> array(
						'header_main' => T_( 'Main Header' ),
						'header_page' => T_( 'Custom Header' ),
					),
					'defaultvalue'	=> 'header_main',
				),
				'posts_layout' => array(
					'label' => T_('Page Layout'),
					'note' => '',
					'defaultvalue' => 'single_column',
					'options' => array(
						'single_column'              => T_('Single Column Large'),
						'single_column_normal'       => T_('Single Column'),
						'single_column_narrow'       => T_('Single Column Narrow'),
						'single_column_extra_narrow' => T_('Single Column Extra Narrow'),
						'left_sidebar'               => T_('Left Sidebar'),
						'right_sidebar'              => T_('Right Sidebar'),
					),
					'type' => 'select',
				),
				'category_list_filter' => array(
					'label'			=> T_( 'Category List Plugin' ),
					'note'			=> T_( 'Check to display a list of categories for filtering posts.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'posts_column' => array(
					'label'			=> T_( 'Post Columns' ),
					'note'			=> T_( 'Set the number of post columns.' ) . ' ' . T_( 'Default value is' ).' <code>3 Columns</code>.',
					'type'			=> 'select',
					'options'		=> array(
						'one_column'	=> T_('1 Column'),
						'two_columns'	=> T_('2 Columns'),
						'three_columns'	=> T_('3 Columns'),
						'four_columns'	=> T_('4 Columns'),
					),
					'defaultvalue'	=> 'three_columns'
				),
				'posts_padding_column' => array(
					'label'			=> T_( 'Post Columns Padding' ),
					'note'			=> 'px. ' . T_( 'Set the ammount of padding on each side of post columns.' ) . ' ' . T_( 'Default value is' ) . ' <code>15px</code>.',
					'type'			=> 'integer',
					'defaultvalue'	=> '15',
					'size'			=> 3,
					'allow_empty'	=> false,
				),
				'posts_border_color' => array(
					'label'			=> T_( 'Posts Border Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#eeeeee</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#eeeeee'
				),
				'posts_featured_bg' => array(
					'label'			=> T_( 'Featured Posts Background Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#f5f5f5</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#f5f5f5'
				),
				'posts_featured_color' => array(
					'label'			=> T_( 'Featured Posts Content Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#7e8082</code>.',
					'type'			=> 'color',
					'defaultvalue' 	=> '#7e8082'
				),
				'posts_featured_border' => array(
					'label'			=> T_( 'Featured Posts Border Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#eeeeee</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#eeeeee'
				),
				'posts_top_pagination' => array(
					'label'			=> T_( 'Top Pagination' ),
					'note'			=> T_( 'Check to enable top pagination.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 0,
				),
				'posts_pagination_align' => array(
					'label'			=> T_( 'Pagination Alignment' ),
					'note'			=> T_( 'Default value is' ).' <code>' . T_( 'Left' ) . '</code>.',
					'type'			=> 'select',
					'options'		=> array(
						'left'		=> T_( 'Left' ),
						'center'	=> T_( 'Center' ),
						'right'		=> T_( 'Right' ),
					),
					'defaultvalue'	=> 'left',
				),
			'section_posts_end' => array(
				'layout'	=> 'end_fieldset',
			),


			/* SINGLE SETTINGS
			 * ========================================================================== */
			'section_single_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Single Post Settings' ).' (disp=single & disp=page)',
			),
				'single_header'	=> array(
					'label'			=> T_( 'Header Style' ),
					'note'			=> T_( 'Default value is' ).' <code>' . T_( 'Custom Header' ) . '</code>.',
					'type'			=> 'select',
					'options'		=> array(
						'header_main'	=> T_( 'Main Header' ),
						'header_page'	=> T_( 'Custom Header' ),
					),
					'defaultvalue'	=> 'header_page',
				),
				'single_border_color' => array(
					'label'			=> T_( 'Border Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#eeeeee</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#eeeeee'
				),
				'single_comments_bg' => array(
					'label'			=> T_( 'Comments Background Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#eeeeee</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#eeeeee',
				),
				'single_comment_color' => array(
					'label'			=> T_( 'Comments Content Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#7e8082</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#7e8082'
				),
			'section_single_end' => array(
				'layout'	=> 'end_fieldset',
			),


			/* SEARCH PAGE SETTINGS
			 * ========================================================================== */
			'section_search_start' => array(
				'layout'		=> 'begin_fieldset',
				'label'			=> T_( 'Search Page Settings' ).' (disp=search)',
			),
				'search_header'	=> array(
					'label'			=> T_( 'Header Style' ),
					'note'			=> T_( 'Default value is' ).' <code>' . T_( 'Custom Header' ) . '</code>.',
					'type'			=> 'select',
					'options'		=> array(
						'header_main' => T_( 'Main Header' ),
						'header_page' => T_( 'Custom Header' ),
					),
					'defaultvalue'	=>'header_page',
				),
				'search_box' => array(
					'label'			=> T_( 'Display Search field' ),
					'note'			=> T_( 'Check to display search field.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'search_pagi_align' => array(
					'label'			=> T_( 'Pagination Alignment' ),
					'note'			=> T_( 'Default value is' ).' <code>' . T_( 'Center' ) . '</code>.',
					'type'			=> 'select',
					'options'		=> array(
						'left'		=> T_( 'Left' ),
						'center' 	=> T_( 'Center' ),
						'right'		=> T_( 'Right' ),
					),
					'defaultvalue' => 'center',
				),
			'section_search_end' => array(
				'layout'		=> 'end_fieldset',
			),


			/* MEDIAIDX SETTINGS
			 * ========================================================================== */
			'section_gallery_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Media Index Page Settings' ).' (disp=mediaidx)',
			),
				'gallery_header' => array(
					'label'			=> T_( 'Header Style' ),
					'note'			=> T_( 'Select header style for media index page.' ),
					'type'			=> 'select',
					'options'		=> array(
						'header_main'	=> T_( 'Main Header' ),
						'header_page'	=> T_( 'Custom Header' ),
					),
					'defaultvalue'	=> 'header_page'
				),
				'gallery_thumb'	=> array(
					'label'			=> T_( 'Gallery Images Size' ),
					'note'			=> T_( 'Select the size for gallery images.' ),
					'type'			=> 'select',
					'options'		=> get_available_thumb_sizes(),
					'defaultvalue'	=> 'crop-480x320'
				),
				'gallery_column' => array(
					'label'			=> T_( 'Gallery Columns' ),
					'note'			=> T_( 'Set the number of columns for displaying Gallery Images.' ),
					'type'			=> 'select',
					'options'		=> array(
						'one_column'	=> T_( '1 Column' ),
						'two_columns'	=> T_( '2 Columns' ),
						'three_columns'	=> T_( '3 Columns' ),
						'four_columns'	=> T_( '4 Columns' ),
					),
					'defaultvalue'	=> 'three_columns'
				),
				'gallery_gutter' => array(
					'label'			=> T_( 'Gallery Columns Gutter' ),
					'note'			=> 'px. ' . T_( 'Default value is' ).' <code>10px</code>.',
					'type'			=> 'text',
					'defaultvalue'	=> '10',
					'size'			=> 3,
				),
				'gallery_title'	=> array(
					'label'			=> T_( 'Display Post Titles' ),
					'note'			=> T_('Check to display post titles when hovering gallery images.'),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
			'section_gallery_end' => array(
				'layout'	=> 'end_fieldset',
			),


			/* CONTACTS PAGE SETTINGS
			 * ========================================================================== */
			'section_contact_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Contact Settings' ).' (disp=msgform)',
			),
				'contact_map_show' => array(
					'label'			=> T_( 'Display Map' ),
					'note'			=> T_( 'Check to display Google map.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'contact_map_lat' => array(
					'label'			=> T_( 'Location Latitude' ),
					'note'			=> T_( 'Set the latitude for the map. Example' ).' <code>48.8583861</code>.',
					'type'			=> 'text',
					'defaultvalue'	=> '48.8583861',
					'size'			=> 50,
				),
				'contact_map_lng' => array(
					'label'			=> T_( 'Location Longitude' ),
					'note'			=> T_( 'Set hte longitude for the map. Example' ).' <code>2.2944542</code>.',
					'type'			=> 'text',
					'defaultvalue'	=> '2.2944542',
					'size'			=> 50,
				),
				'contact_map_zoom' => array(
					'label'			=> T_( 'Zoom Map' ),
					'note'			=> T_( 'Default value is' ).' <code>16</code>.',
					'type'			=> 'select',
					'options'		=> array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
						'7'	=> '7',
						'8'	=> '8',
						'9'	=> '9',
						'10' => '10',
						'11' => '11',
						'12' => '12',
						'13' => '13',
						'14' => '14',
						'15' => '15',
						'16' => '16',
						'17' => '17',
						'18' => '18',
					),
					'defaultvalue'	=> 16,
				),
				'contact_map_drag' => array(
					'label'			=> T_( 'Draggable Map' ),
					'note'			=> T_( 'Check to enable draggable map.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'contact_map_scrol' => array(
					'label'			=> T_( 'Scrollwheel Map' ),
					'note'			=> T_( 'Check to enable scrollwheel zoom on the map.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 0,
				),
				'contact_map_doubleclick' => array(
					'label'			=> T_( 'Disable Double Click Zoom' ),
					'note'			=> T_( 'Check to disable double click zoom on the map.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'contact_map_fullscreen' => array(
					'label'			=> T_( 'Full Screen Control' ),
					'note'			=> T_( 'Check to enable full screen control on the map.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'contact_map_disableDefaultUI' => array(
					'label'			=> T_( 'Disable Default UI' ),
					'note'			=> T_( 'Check to disable Default UI on the map.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 0,
				),
				'contact_map_marker_show' => array(
					'label'			=> T_( 'Show Map Marker' ),
					'note'			=> T_( 'Check to display map marker.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 0,
				),
				'contact_map_marker_lat' => array(
					'label'			=> T_( 'Marker Latitude Coordinates' ),
					'note'			=> T_( 'Set the Latitude Coordinates for marker. Example' ).' <code>48.8583861</code>.',
					'type'			=> 'text',
					'defaultvalue'	=> '',
					'size'			=> 50,
				),
				'contact_map_marker_lng' => array(
					'label'			=> T_( 'Marker Longitude Coordinates' ),
					'note'			=> T_( 'Set the Longitude Coordinates for marker. Example' ).' <code>2.2944542</code>.',
					'type'			=> 'text',
					'defaultvalue'	=> '',
					'size'			=> 50,
				),
				'contact_map_marker_content' => array(
					'label'			=> T_( 'Content Marker' ),
					'note'			=> T_( 'Add content for the Marker.' ),
					'type'			=> 'textarea',
				),
				'contact_info_show' => array(
					'label'			=> T_( 'Enable Conctact Info' ),
					'note'			=> T_( 'Check to display contact info section.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'contact_info_address' => array(
					'label'			=> T_( 'Contact Address Field' ),
					'note'			=> T_( 'Type your contact address.' ),
					'type'			=> 'textarea',
					'defaultvalue'	=> 'Your Address location',
				),
				'contact_info_email' => array(
					'label'			=> T_( 'Contact Email Field' ),
					'note'			=> T_( 'Type your contact email.' ),
					'type'			=> 'text',
					'defaultvalue'	=> 'youremail@example.com',
					'size'			=> 30,
				),
				'contact_info_number' => array(
					'label'			=> T_( 'Contact Number Field' ),
					'note'			=> T_( 'Type your contact number.' ),
					'type'			=> 'text',
					'defaultvalue'	=> T_( '(+123) 4567 8910' ),
					'size'			=> 30,
				),
				'contact_info_bg' => array(
					'label'			=> T_( 'Contact Info Section Background Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#f5f5f5</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#f5f5f5',
				),
				'contact_info_color' => array(
					'label'			=> T_( 'Contact Info Section Content Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#7e8082</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#7e8082'
				),
			'section_contact_end' => array(
				'layout'	=> 'end_fieldset',
			),


			/* SPECIAL WIDGET SETTINGS
			 * ========================================================================== */
			'section_special_widget_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Special Widget Settings' ),
			),
				'sw_rm_button' => array(
					'label'			=> T_( 'List-type Widgets "Read More" button' ),
					'note'			=> T_( 'Check to display the "Read more" button after content on all list-type widgets (Excerpt and Teaser)' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 0,
				),
				'sw_bg_wl'	=> array(
					'label'			=> T_( 'Background RWD Widget List' ),
					'note'			=> T_( 'Default value is' ).' <code>#fafafa</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#fafafa'
				),
				'sw_tag_color' => array(
					'label'			=> T_( 'Tag Cloud Elements Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#7e8082</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#7e8082',
				),
				'sw_tag_border' => array(
					'label'			=> T_( 'Tag Cloud Elements Border Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#eeeeee</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#eeeeee',
				),
				'sw_tag_color_hover' => array(
					'label'			=> T_( 'Tag Cloud Elements Hover Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#ffffff</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#ffffff',
				),
				'sw_tag_bg_hover' => array(
					'label'			=> T_( 'Tag Cloud Elements Hover Background Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#4b4e53</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#4b4e53'
				),
			'section_special_widget_end' => array(
				'layout'	=> 'end_fieldset'
			),


			/* FOOTER OPTIONS
			 * ========================================================================== */
			'section_footer_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Footer Settings' ),
			),
				'footer_background'	=> array(
					'label'			=> T_( 'Background Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#ffffff</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#ffffff'
				),
				'footer_wd_content_color' => array(
					'label'			=> T_( 'Content Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#7e8082</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#7e8082',
				),
				'footer_wd_color_link' => array(
					'label'			=> T_( 'Links Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#7e8082</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#7e8082',
				),
				'footer_wd_color_lh' => array(
					'label'			=> T_( 'Links Hover color' ),
					'note'			=> T_( 'Default value is' ).' <code>#101010</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#101010'
				),
				'footer_border_color' => array(
					'label'			=> T_( 'Borders Color' ),
					'note'			=> T_( 'Default value is' ).' <code>#eeeeee</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#eeeeee',
				),
				'footer_widget'	=> array(
					'label'			=> T_( 'Enable Footer Container' ),
					'note'			=> T_( 'Check to enable footer container.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 0,
				),
				'footer_widgets_columns' => array(
					'label'			=> T_( 'Number of Widget Columns' ),
					'note'			=> T_( 'Default value is' ).' <code>'. T_( '2 Columns' ) .'</code>. '. T_( 'This works only if previous option is enabled.' ),
					'type'			=> 'select',
					'options'		=> array(
						'col-md-12' => T_( '1 Column' ),
						'col-md-6'	=> T_( '2 Columns' ),
						'col-md-4'	=> T_( '3 Columns' ),
						'col-md-3'	=> T_( '4 Columns' ),
					),
					'defaultvalue'	=> 'col-md-3',
				),
				'footer_wd_title_color' => array(
					'label'			=> T_( 'Widget Titles Color' ),
					'note'			=> T_( 'Default color is' ).' <code>#4b4e53</code>.',
					'type'			=> 'color',
					'defaultvalue'	=> '#4b4e53'
				),
				'footer_copyright' => array(
					'label'			=> T_( 'Footer Copyright' ),
					'note'			=> T_( 'Check to enable footer copyright text.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'footer_bottom_mode' => array(
					'label'			=> T_( 'Copyright Text Position' ),
					'note'			=> T_( 'Set the position of the copyright text and social links.' ),
					'type'			=> 'select',
					'options'		=> array(
						'float'		=> T_( 'Default' ),
						'center'	=> T_( 'Centered' ),
					),
					'defaultvalue'	=> 'float'
				),
				'footer_social_icon' => array(
					'label'			=> T_( 'Enable Social Icon' ),
					'note'			=> T_( 'Check to display social icons section.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
			'section_footer_end' => array(
				'layout'	=> 'end_fieldset'
			),


			/* COLOR IMAGE ZOOM OPTIONS
			 * ========================================================================== */
			'section_colorbox_start' => array(
				'layout' => 'begin_fieldset',
				'label'  => T_('Colorbox Image Zoom').' (All disps)',
			),
				'colorbox' => array(
					'label' => T_('Colorbox Image Zoom'),
					'note' => T_('Check to enable javascript zooming on images (using the colorbox script)'),
					'defaultvalue' => 1,
					'type' => 'checkbox',
				),
				'colorbox_vote_post' => array(
					'label' => T_('Voting on Post Images'),
					'note' => T_('Check this to enable AJAX voting buttons in the colorbox zoom view'),
					'defaultvalue' => 1,
					'type' => 'checkbox',
				),
				'colorbox_vote_post_numbers' => array(
					'label' => T_('Display Votes'),
					'note' => T_('Check to display number of likes and dislikes'),
					'defaultvalue' => 1,
					'type' => 'checkbox',
				),
				'colorbox_vote_comment' => array(
					'label' => T_('Voting on Comment Images'),
					'note' => T_('Check this to enable AJAX voting buttons in the colorbox zoom view'),
					'defaultvalue' => 1,
					'type' => 'checkbox',
				),
				'colorbox_vote_comment_numbers' => array(
					'label' => T_('Display Votes'),
					'note' => T_('Check to display number of likes and dislikes'),
					'defaultvalue' => 1,
					'type' => 'checkbox',
				),
				'colorbox_vote_user' => array(
					'label' => T_('Voting on User Images'),
					'note' => T_('Check this to enable AJAX voting buttons in the colorbox zoom view'),
					'defaultvalue' => 1,
					'type' => 'checkbox',
				),
				'colorbox_vote_user_numbers' => array(
					'label' => T_('Display Votes'),
					'note' => T_('Check to display number of likes and dislikes'),
					'defaultvalue' => 1,
					'type' => 'checkbox',
				),
			'section_colorbox_end' => array(
				'layout' => 'end_fieldset',
			),


			/* USERNAME OPTIONS
			 * ========================================================================== */
			'section_username_start' => array(
				'layout' => 'begin_fieldset',
				'label'  => T_('Username options') . ' (All disps)'
			),
				'gender_colored' => array(
					'label' => T_('Display gender'),
					'note' => T_('Use colored usernames to differentiate men & women.'),
					'defaultvalue' => 0,
					'type' => 'checkbox',
				),
				'bubbletip' => array(
					'label' => T_('Username bubble tips'),
					'note' => T_('Check to enable bubble tips on usernames'),
					'defaultvalue' => 0,
					'type' => 'checkbox',
				),
				'autocomplete_usernames' => array(
					'label' => T_('Autocomplete usernames'),
					'note' => T_('Check to enable auto-completion of usernames entered after a "@" sign in the comment forms'),
					'defaultvalue' => 1,
					'type' => 'checkbox',
				),
			'section_username_end' => array(
				'layout' => 'end_fieldset',
			),


			/* ACCESS DENID OPTIONS
			 * ========================================================================== */
			'section_access_start' => array(
				'layout' => 'begin_fieldset',
				'label'  => T_('When access is denied or requires login...'). ' (disp=access_denied and disp=access_requires_login)'
			),
				'access_login_containers' => array(
					'label' => T_('Display on login screen'),
					'note'  => '',
					'type'  => 'checklist',
					'options' => array(
						array( 'menu',     sprintf( T_('"%s" container'), NT_('Menu') ),      1 ),
						array( 'header',   sprintf( T_('"%s" container'), NT_('Header') ),    1 ),
						array( 'sidebar',  sprintf( T_('"%s" container'), NT_('Sidebar') ),   0 ),
						array( 'footer',   sprintf( T_('"%s" container'), NT_('Footer') ),    0 )
					),
				),
			'section_access_end' => array(
				'layout' => 'end_fieldset',
			),

			), parent::get_param_definitions( $params ) );

		return $r;
	}


	/* CHANGE CLASS
	* ========================================================================== */
	function change_class( $id ) {
		$id = $this->get_setting( $id );
		if ( $id == $id ) {
			return $id;
		}
	}


	/**
	 * Get ready for displaying the skin.
	 *
	 * This may register some CSS or JS...
	 */
	function display_init()
	{
		global $Messages, $disp, $debug;

		// Request some common features that the parent function (Skin::display_init()) knows how to provide:
		parent::display_init( array(
			'jquery',                  // Load jQuery
			'font_awesome',            // Load Font Awesome (and use its icons as a priority over the Bootstrap glyphicons)
			'bootstrap',               // Load Bootstrap (without 'bootstrap_theme_css')
			'bootstrap_evo_css',       // Load the b2evo_base styles for Bootstrap (instead of the old b2evo_base styles)
			'bootstrap_messages',      // Initialize $Messages Class to use Bootstrap styles
			'style_css',               // Load the style.css file of the current skin
			'colorbox',                // Load Colorbox (a lightweight Lightbox alternative + customizations for b2evo)
			'bootstrap_init_tooltips', // Inline JS to init Bootstrap tooltips (E.g. on comment form for allowed file extensions)
			'disp_auto',               // Automatically include additional CSS and/or JS required by certain disps (replace with 'disp_off' to disable this)
		) );

		
		// Include Font
		// ======================================================================== /
		add_headline('<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700|Open+Sans:300,400,700" rel="stylesheet">');
		
		
		// INCLUDE THE SCRIPTS
		require_js( 'assets/scripts/masonry.pkgd.min.js', 'relative' );

		if( $disp == 'posts' ) {
			add_js_headline("
			jQuery( document ).ready( function(event){
				'use strict';
				var posts_masonry = function() {
					$('.grid').masonry({
						// options
						itemSelector: '.filtr-item',
						// columnWidth: 200
					});
				};

				$(window).load( function() {
					posts_masonry();
				});
			});
			");
		};


		/**
		 * ============================================================================
		 * MAPS ON CONTACTS
		 * ============================================================================
		 */
		if( ($disp == 'msgform' || $disp == 'threads') && $this->get_setting( 'contact_map_show' ) == 1 ) {
			// require_js( 'assets/scripts/map_api.js', 'relative' );
			require_js( 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCgKRuQhHjO2Xuz1JBLBuf9rhzKEIWQYPM' );
			require_js( 'assets/scripts/gmaps.min.js', 'relative' );

			$lat 	 = $this->get_setting( 'contact_map_lat' );
			$lng 	 = $this->get_setting( 'contact_map_lng' );
			$zoom 	 = $this->get_setting( 'contact_map_zoom' );
			$drag 	 = $this->get_setting( 'contact_map_drag' );
			$scrol 	 = $this->get_setting( 'contact_map_scrol' );
			$fullsc  = $this->get_setting( 'contact_map_fullscreen' );
			$dis_ui  = $this->get_setting( 'contact_map_disableDefaultUI' );
			$doublec = $this->get_setting( 'contact_map_doubleclick' );
			$mar_lat = $this->get_setting( 'contact_map_marker_lat' );
			$mar_lng = $this->get_setting( 'contact_map_marker_lng' );
			$mar_con = $this->get_setting( 'contact_map_marker_content' );

			$map_marker = '';
			if ( $this->get_setting( 'contact_map_marker_show' ) == 1 ){
				$map_marker = "map.addMarker({
						lat: $mar_lat,
						lng: $mar_lng,
						title: 'Marker Content',
				        infoWindow: {
				          content: '$mar_con'
				        }
					});";
			};

			add_js_headline("
				var map;
				$(document).ready(function(){
					map = new GMaps({
						div: '#maps',
						lat: $lat,
						lng: $lng,
						zoom: $zoom, // Max zoom 18
						draggable: $drag,
						scrollwheel: $scrol,
						disableDoubleClickZoom: $doublec,
						fullscreenControl: $fullsc,
						disableDefaultUI: $dis_ui,
					});

					$map_marker

				});
			");
		};


		/* Required Scripts
		 * ========================================================================== */
		require_js( 'assets/scripts/scripts.js', 'relative' );

		// Skin specific initializations:
		global $media_url, $media_path;

		// Add custom CSS:
		$custom_css = '';

		/* CUSTOM COLOR OPTIONS
		 * ========================================================================== */
		if( $color = $this->get_setting( 'page_bg_color' ) )
		{ // Custom page background color:
			$custom_css .= '#skin_wrapper { background-color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'page_text_color' ) )
		{ // Custom page text color:
			$custom_css .= '#skin_wrapper, .text-muted, .dimmed, .note, .notes { color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'page_link_color' ) )
		{ // Custom page link color:
			$custom_css .= 'a { color: '.$color." }\n";
			$custom_css .= 'h4.evo_comment_title a, h4.panel-title a.evo_comment_type, .pagination li:not(.active) a, .pagination li:not(.active) span { color: '.$color." !important }\n";
			$custom_css .= '.pagination li.active a, .pagination li.active span { color: #fff; background-color: '.$color.' !important; border-color: '.$color." }\n";
			if( $this->get_setting( 'gender_colored' ) !== 1 )
			{ // If gender option is not enabled, choose custom link color. Otherwise, chose gender link colors:
				$custom_css .= 'h4.panel-title a { color: '.$color." }\n";
			}
			$custom_css .= ".disp_posts .filters .nav-gallery li.active { background-color: $color; border-color: $color; }";
		}
		if( $color = $this->get_setting( 'page_hover_link_color' ) )
		{ // Custom page link color on hover:
			$custom_css .= 'a:hover { color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'bgimg_text_color' ) )
		{	// Custom text color on background image:
			$custom_css .= '.evo_hasbgimg { color: '.$color." !important }\n";
		}
		if( $color = $this->get_setting( 'bgimg_link_color' ) )
		{	// Custom link color on background image:
			$custom_css .= '.evo_hasbgimg a:not(.btn) { color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'bgimg_hover_link_color' ) )
		{	// Custom link hover color on background image:
			$custom_css .= '.evo_hasbgimg a:not(.btn):hover { color: '.$color." }\n";
		}
		// if( $color = $this->get_setting( 'color_heading' ) )
		// { // Custom current tab text color:
			// $custom_css .= 'h1, h2, h3, h4, h5, h6 { color: '.$color." !important }\n";
		// }
		if( $color = $this->get_setting( 'panel_color' ) ) {
			$custom_css .= "#skin_wrapper .panel, #skin_wrapper .panel .evo_comment_info { color: $color; }";
		}

		// Limit images by max height:
		$max_image_height = intval( $this->get_setting( 'max_image_height' ) );
		if( $max_image_height > 0 )
		{
			$custom_css .= '.evo_image_block img { max-height: '.$max_image_height.'px; width: auto; }'." }\n";
		}

		/* FONT SIZE COSTUMIZE
		 * ========================================================================== */
		if( $font_size = $this->get_setting( 'font_size' ) )
		{
			switch( $font_size )
			{
				case 'default': // When default font size, no CSS entry
					//$custom_css .= '';
					break;

				case 'standard':// When standard layout
					$custom_css .= '#skin_wrapper { font-size: 11.4px }';
					// $custom_css .= 'body { font-size: 16px !important'." }\n";
					$custom_css .= '#skin_wrapper input.search_field { height: 100%'." }\n";
					$custom_css .= '#skin_wrapper h1 { font-size: 38px'." }\n";
					$custom_css .= '#skin_wrapper h2 { font-size: 32px'." }\n";
					$custom_css .= '#skin_wrapper h3 { font-size: 26px'." }\n";
					$custom_css .= '#skin_wrapper h4 { font-size: 18px'." }\n";
					$custom_css .= '#skin_wrapper h5 { font-size: 16px'." }\n";
					$custom_css .= '#skin_wrapper h6 { font-size: 14px'." }\n";
					$custom_css .= '#skin_wrapper .small { font-size: 85% !important'." }\n";
					break;

				case 'medium': // When default font size, no CSS entry
					$custom_css .= '#skin_wrapper { font-size: 12.858px; }';
					$custom_css .= '#skin_wrapper { line-height: 26px !important; }';
					// $custom_css .= 'body { font-size: 18px !important'." }\n";
					$custom_css .= '#skin_wrapper input.search_field { height: 100%'." }\n";
					$custom_css .= '#skin_wrapper h1 { font-size: 40px'." }\n";
					$custom_css .= '#skin_wrapper h2 { font-size: 34px'." }\n";
					$custom_css .= '#skin_wrapper h3 { font-size: 28px'." }\n";
					$custom_css .= '#skin_wrapper h4 { font-size: 20px'." }\n";
					$custom_css .= '#skin_wrapper h5 { font-size: 18px'." }\n";
					$custom_css .= '#skin_wrapper h6 { font-size: 16px'." }\n";
					$custom_css .= '#skin_wrapper .small { font-size: 85% !important'." }\n";
					break;

				case 'large': // When default font size, no CSS entry
					$custom_css .= '#skin_wrapper { font-size: 20px !important'." }\n";
					$custom_css .= '#skin_wrapper input.search_field { height: 100%'." }\n";
					$custom_css .= '#skin_wrapper h1 { font-size: 42px'." }\n";
					$custom_css .= '#skin_wrapper h2 { font-size: 36px'." }\n";
					$custom_css .= '#skin_wrapper h3 { font-size: 30px'." }\n";
					$custom_css .= '#skin_wrapper h4 { font-size: 22px'." }\n";
					$custom_css .= '#skin_wrapper h5 { font-size: 20px'." }\n";
					$custom_css .= '#skin_wrapper h6 { font-size: 18px'." }\n";
					$custom_css .= '#skin_wrapper .small { font-size: 85% !important'." }\n";
					break;

				case 'very_large': // When default font size, no CSS entry
					$custom_css .= '#skin_wrapper { font-size: 22px !important'." }\n";
					$custom_css .= '#skin_wrapper input.search_field { height: 100%'." }\n";
					$custom_css .= '#skin_wrapper h1 { font-size: 44px'." }\n";
					$custom_css .= '#skin_wrapper h2 { font-size: 38px'." }\n";
					$custom_css .= '#skin_wrapper h3 { font-size: 32px'." }\n";
					$custom_css .= '#skin_wrapper h4 { font-size: 24px'." }\n";
					$custom_css .= '#skin_wrapper h5 { font-size: 22px'." }\n";
					$custom_css .= '#skin_wrapper h6 { font-size: 20px'." }\n";
					$custom_css .= '#skin_wrapper .small { font-size: 85% !important'." }\n";
					break;
			}
		}


		/* NAVIGATION OPTIONS
		 * ========================================================================== */
		if( $bg = $this->get_setting( 'nav_background' ) && $this->get_setting( 'nav_bg_transparent' ) != 1 ) {
			$custom_css .= '#nav, #nav.nav_page, #nav.nav_bgt { background-color: '.$bg.' }';
		}
		if( $color = $this->get_setting( 'nav_background_sticky' ) ) {
			$custom_css .= "@media screen and ( min-width: 1025px ){ #nav.affix, #nav.nav_bgt.affix{ background-color: $color } }";
		}
		if( $trans = $this->get_setting( 'nav_bg_transparent' ) ) {
			if( $this->get_setting( 'nav_sticky' ) == 1 ) {
				$custom_css .= '@media screen and ( min-width: 1025px ){ #nav.affix-top.nav_bgt { background-color: transparent } }';
			}
			else
			{
				$custom_css .= '@media screen and ( min-width: 1025px ){ #nav.nav_bgt { background-color: transparent } }';
			}
		}
		if( $this->get_setting( 'nav_bg_transparent' ) == 1 ) {
			$color_nav_bgt = $this->get_setting( 'nav_cl_transparent' );
			$custom_css .= '@media screen and ( min-width: 1025px ){ #nav.nav_bgt .nav_tabs ul a, #nav.nav_bgt .navbar-header .navbar-brand h3 a { color: '.$color_nav_bgt.' } }';
			$custom_css .= '@media screen and ( min-width: 1025px ){ #nav.nav_bgt .search_icon .search_tringger:before { border-color: '.$color_nav_bgt.' } }';
			$custom_css .= '@media screen and ( min-width: 1025px ){ #nav.nav_bgt .search_icon .search_tringger:after { background-color: '.$color_nav_bgt.' } }';
			$custom_css .= '@media screen and ( min-width: 1025px ){#nav.nav_bgt .navbar-header .navbar-toggle .icon-bar { background-color: '.$color_nav_bgt.'; } }';

			$color_hov_nav_bgt = $this->get_setting( 'nav_clh_transparent' );
			$custom_css .= '#nav.nav_bgt.affix-top .nav_tabs ul a:hover, #nav .nav_tabs ul a:active, #nav.nav_bgt.affix-top .nav_tabs ul a:focus { color: '.$color_hov_nav_bgt.' }';
			$custom_css .= '#nav.nav_bgt.affix-top .nav_tabs ul li.active > a { color: '.$color_hov_nav_bgt.'; border-color: '.$color_hov_nav_bgt.' }';
		}


		// SETTING DEFAULT
		if( $color  = $this->get_setting( 'nav_color_link' ) ) {
			$custom_css .= '#nav .nav_tabs ul a, #nav .navbar-header .navbar-brand h3 a { color: '.$color.' }';
			$custom_css .= '#nav .search_icon .search_tringger:before { border-color: '.$color.' }';
			$custom_css .= '#nav .search_icon .search_tringger:after { background-color: '.$color.' }';
			$custom_css .= '#nav .navbar-header .navbar-toggle .icon-bar { background-color: '.$color.'; }';
		}
		if( $color = $this->get_setting( 'nav_color_link_sticky' ) ) {
			$custom_css .= '@media screen and ( min-width: 1025px ) { #nav.affix .nav_tabs ul a, #nav.affix .navbar-header .navbar-brand h3 a { color: '.$color.' }';
			$custom_css .= '#nav.affix .search_icon .search_tringger:before { border-color: '.$color.' }';
			$custom_css .= '#nav.affix .search_icon .search_tringger:after { background-color: '.$color.' }';
			$custom_css .= '#nav.affix .navbar-header .navbar-toggle .icon-bar { background-color: '.$color.'; } }';
		}
		if( $hover = $this->get_setting( 'nav_color_link_hover' ) ) {
			$custom_css .= '#nav .nav_tabs ul a:hover, #nav .nav_tabs ul a:active, #nav .nav_tabs ul a:focus { color: '.$hover.' }';
			$custom_css .= '#nav .nav_tabs ul li.active > a { color: '.$hover.'; border-color: '.$hover.' }';
		}
		if( $hover = $this->get_setting( 'nav_color_link_hover_sticky' ) ) {
			if( $this->get_setting( 'nav_sticky' ) == 1 ) {
			$custom_css .= '#nav.affix .nav_tabs ul a:hover, #nav.affix .nav_tabs ul a:active, #nav.affix .nav_tabs ul a:focus { color: '.$hover.' }';
			$custom_css .= '#nav.affix .nav_tabs ul li.active > a { color: '.$hover.'; border-color: '.$hover.' }';
			}
		}
		

		if ( $this->get_setting( 'nav_sticky' ) == 1 ) {
			$custom_css .= "@media screen and ( min-width: 1025px ) { #nav.affix-top.nav_bgt { position:absolute !important; z-index:9999 } }";
			$custom_css .= "@media screen and ( min-width: 1025px ) { #nav.affix.nav_bgt + #main_header { margin-top:0 !important } }\n";
		}
		


		/* MAIN HEADER SETTINGS
		 * ========================================================================== */
		if( $padding = $this->get_setting( 'header_padding_top' ) ) {
			$custom_css .= '@media screen and ( min-width: 1025px ) { #main_header { padding-top: '.$padding.'px } }';
		}

		$FileCache = & get_FileCache();

		if( $this->get_setting( 'header_bg_image' ) ) {
			$bg_image_File = & $FileCache->get_by_ID( $this->get_setting( 'header_bg_image' ), false, false );
		}


		if( !empty( $bg_image_File ) && $bg_image_File->exists() )
		{ // Custom body background image:
			$custom_css .= '#main_header { background-image: url('.$bg_image_File->get_url().") }\n";
		}

		$bg_header_x = $this->get_setting( 'header_bg_pos_x');
		$bg_header_y = $this->get_setting( 'header_bg_pos_y');
		if( !empty($bg_header_x) || !empty($bg_header_y)  ) {
			$custom_css .= '#main_header{ background-position: '.$bg_header_x.'% '.$bg_header_y.'%; }';
		}

		if( $bg_header_attach = $this->get_setting( 'header_bg_attachment' ) ) {
			$custom_css .= '#main_header { background-attachment: '.$bg_header_attach.' }';
		}
		if( $this->get_setting( 'header_overlay' ) == 0 ) {
			$custom_css .= '#main_header:after{ display: none; }';
		} else {
			$header_color_overlay = $this->get_setting( 'header_color_overlay' );
			$header_cov_opacity = $this->get_setting( 'header_co_opacity' );
			$custom_css .= '#main_header:after { background-color: '.$header_color_overlay.'; opacity: '.$header_cov_opacity.' }';
		}


		/* HEADER PAGE SETTINGS
		 * ========================================================================== */
		if( $color = $this->get_setting( 'header_page_bg' ) ) {
			$custom_css .= "#main_header_page { background-color: $color }";
		}
		if( $color = $this->get_setting( 'header_page_color_content' ) ) {
			$custom_css .= "#main_header_page .single_title_post h1, #main_header_page .bc_content .breadcrumb > .active, #main_header_page .bc_content .breadcrumb a{ color: $color !important; }";
		}
		if( $padding = $this->get_setting( 'header_page_pt' ) ) {
			$custom_css .= '@media screen and ( min-width: 768px ){ #main_header_page{ padding-top: '.$padding.'px; } }';
		}
		if( $padding = $this->get_setting( 'header_page_pb' ) ) {
			$custom_css .= '@media screen and ( min-width: 768px ){#main_header_page { padding-bottom: '.$padding.'px; } }';
		}


		/* POSTS SETTINGS
		 * ========================================================================== */
		if ( $padding = $this->get_setting( 'posts_padding_column' ) ) {
			$custom_css .= '.disp_posts #grid_posts .evo_post_article { padding: 0 '.$padding.'px; }';
			$custom_css .= '.disp_posts #grid_posts { margin-left: -'.$padding.'px; margin-right: -'.$padding.'px; }';
		}
		if ( $color = $this->get_setting( 'posts_featured_bg' ) ) {
			$custom_css .= ".disp_posts #grid_posts .featured_posts .evo_post_image, .disp_posts #grid_posts .featured_posts .evo_post_title, .disp_posts #grid_posts .featured_posts .evo_post_info, .disp_posts #grid_posts .featured_posts .evo_post__excerpt, .disp_posts #grid_posts .featured_posts .evo_post_footer_info, .disp_posts #grid_posts .featured_posts .evo_post__full { background-color: $color }";
			$custom_css .= ".disp_posts #grid_posts .featured_posts .evo_post_image, .disp_posts #grid_posts .featured_posts .evo_post_title, .disp_posts #grid_posts .featured_posts .evo_post_info, .disp_posts #grid_posts .featured_posts .evo_post__excerpt, .disp_posts #grid_posts .featured_posts .evo_post_footer_info, .disp_posts #grid_posts .featured_posts .evo_post__full { background-color: $color; padding: 15px; }";
			$custom_css .= ".disp_posts .featured_posts .evo_featured_post { background-color: $color; }";
			$custom_css .= ".disp_posts #grid_posts .evo_post_article .evo_post_info { opacity: 1; }";
		}
		if( $color = $this->get_setting( 'posts_featured_color' ) ) {
			$custom_css .= ".disp_posts #grid_posts .featured_posts .evo_post_article { color: $color; }";
		}
		if( $color = $this->get_setting( 'posts_border_color' ) ) {
			$custom_css .= ".disp_posts #grid_posts .evo_post_article .evo_post__excerpt, .disp_posts #grid_posts .evo_post_article .evo_post__full_text { border-color: $color; }";
			$custom_css .= ".disp_posts .filters .nav-gallery li { border-color: $color; }";
		}
		if( $color = $this->get_setting( 'posts_featured_border' ) ) {
			$custom_css .= ".disp_posts #grid_posts .featured_posts .evo_post_article .evo_post__excerpt, .disp_posts #grid_posts .featured_posts .evo_post_article .evo_post__full_text { border-color: $color; }";
		}


		/* SINGLE SETTINGS
		 * ========================================================================== */
		if( $color = $this->get_setting( 'single_comments_bg' ) ) {
			$custom_css .= "#main_content .evo_content_single .evo_post_article .evo_single_comments .single_comment_form, #main_content .evo_post_lists .evo_post_article .evo_single_comments .single_comment_form, #main_content .evo_content_single .evo_single_article .evo_single_comments .single_comment_form, #main_content .evo_post_lists .evo_single_article .evo_single_comments .single_comment_form{ background-color: $color !important; border-color: $color !important; }";
			$custom_css .= "#main_content .evo_content_single .evo_post_article .evo_single_comments .evo_comment_meta .panel, #main_content .evo_post_lists .evo_post_article .evo_single_comments .evo_comment_meta .panel, #main_content .evo_content_single .evo_single_article .evo_single_comments .evo_comment_meta .panel, #main_content .evo_post_lists .evo_single_article .evo_single_comments .evo_comment_meta .panel{ background-color: $color }";
		}
		if( $color = $this->get_setting( 'single_comment_color' ) ) {
			$custom_css .= "#main_content .evo_content_single .evo_post_article .evo_single_comments .single_comment_form, #main_content .evo_post_lists .evo_post_article .evo_single_comments .single_comment_form, #main_content .evo_content_single .evo_single_article .evo_single_comments .single_comment_form, #main_content .evo_post_lists .evo_single_article .evo_single_comments .single_comment_form { color: $color }";
			$custom_css .= ".evo_single_comments .evo_comment_meta, .evo_single_comments .evo_comment_meta .evo_comment_footer { color: $color }";
		}
		if( $color = $this->get_setting( 'single_border_color' ) ) {
			$custom_css .= ".disp_single #main_content .evo_content_single .evo_post_article .evo_post__full, .disp_page #main_content .evo_content_single .evo_post_article .evo_post__full, .disp_single #main_content .evo_post_lists .evo_post_article .evo_post__full, .disp_page #main_content .evo_post_lists .evo_post_article .evo_post__full, .disp_single #main_content .evo_content_single .evo_single_article .evo_post__full, .disp_page #main_content .evo_content_single .evo_single_article .evo_post__full, .disp_single #main_content .evo_post_lists .evo_single_article .evo_post__full, .disp_page #main_content .evo_post_lists .evo_single_article .evo_post__full { border-color: $color; }";
			$custom_css .= ".disp_single #main_content .evo_content_single .evo_post_article .single_pager, .disp_page #main_content .evo_content_single .evo_post_article .single_pager, .disp_single #main_content .evo_post_lists .evo_post_article .single_pager, .disp_page #main_content .evo_post_lists .evo_post_article .single_pager, .disp_single #main_content .evo_content_single .evo_single_article .single_pager, .disp_page #main_content .evo_content_single .evo_single_article .single_pager, .disp_single #main_content .evo_post_lists .evo_single_article .single_pager, .disp_page #main_content .evo_post_lists .evo_single_article .single_pager { border-color: $color; }";
			$custom_css .= ".evo_comment { border-color: $color; }";
			$custom_css .= ".evo_comment .evo_comment_footer .permalink_right, .evo_comment .evo_comment_info .permalink_right { border-color: $color; }";
			$custom_css .= ".disp_single #main_content .evo_content_single .evo_post_article .evo_post__full_text table th, .disp_page #main_content .evo_content_single .evo_post_article .evo_post__full_text table th, .disp_single #main_content .evo_post_lists .evo_post_article .evo_post__full_text table th, .disp_page #main_content .evo_post_lists .evo_post_article .evo_post__full_text table th, .disp_single #main_content .evo_content_single .evo_single_article .evo_post__full_text table th, .disp_page #main_content .evo_content_single .evo_single_article .evo_post__full_text table th, .disp_single #main_content .evo_post_lists .evo_single_article .evo_post__full_text table th, .disp_page #main_content .evo_post_lists .evo_single_article .evo_post__full_text table th, .disp_single #main_content .evo_content_single .evo_post_article .evo_post__full_text table td, .disp_page #main_content .evo_content_single .evo_post_article .evo_post__full_text table td, .disp_single #main_content .evo_post_lists .evo_post_article .evo_post__full_text table td, .disp_page #main_content .evo_post_lists .evo_post_article .evo_post__full_text table td, .disp_single #main_content .evo_content_single .evo_single_article .evo_post__full_text table td, .disp_page #main_content .evo_content_single .evo_single_article .evo_post__full_text table td, .disp_single #main_content .evo_post_lists .evo_single_article .evo_post__full_text table td, .disp_page #main_content .evo_post_lists .evo_single_article .evo_post__full_text table td { border-color: $color; }";
			$custom_css .= ".disp_single #main_content .evo_content_single .evo_post_article .widget_core_item_tags .item_tags a, .disp_page #main_content .evo_content_single .evo_post_article .widget_core_item_tags .item_tags a, .disp_single #main_content .evo_post_lists .evo_post_article .widget_core_item_tags .item_tags a, .disp_page #main_content .evo_post_lists .evo_post_article .widget_core_item_tags .item_tags a, .disp_single #main_content .evo_content_single .evo_single_article .widget_core_item_tags .item_tags a, .disp_page #main_content .evo_content_single .evo_single_article .widget_core_item_tags .item_tags a, .disp_single #main_content .evo_post_lists .evo_single_article .widget_core_item_tags .item_tags a, .disp_page #main_content .evo_post_lists .evo_single_article .widget_core_item_tags .item_tags a { border-color: $color; }";
		}


		/* MEDIAIDX SETTINGS
		 * ========================================================================== */
		if ( $padding = $this->get_setting( 'gallery_gutter' ) ) {
			$custom_css .= '.disp_mediaidx #main_content .widget_core_coll_media_index .main_content_gallery .content_gallery .evo_image_gallery { margin: '.$padding.'px; }';
			$custom_css .= '.disp_mediaidx #main_content .widget_core_coll_media_index .main_content_gallery { margin-left: -'.$padding.'px; margin-right: -'.$padding.'px }';
		}


		/* CONTACTS PAGE SETTINGS
		 * ========================================================================== */
		if( $color = $this->get_setting( 'contact_info_bg' ) ) {
			$custom_css .= ".disp_threads .contact_info, .disp_msgform .contact_info { background-color: $color; }";
		}
		if( $color = $this->get_setting( 'contact_info_color' ) ) {
			$custom_css .= ".disp_threads .contact_info .main_contact_info_icon .ei, .disp_msgform .contact_info .main_contact_info_icon .ei, .disp_threads .contact_info .main_contact_info_text, .disp_msgform .contact_info .main_contact_info_text { color: $color; }";
			$custom_css .= ".disp_threads .contact_info .main_contact_info:after, .disp_msgform .contact_info .main_contact_info:after{ background-color: $color }";
			$custom_css .= '.disp_threads .contact_info .main_contact_info_text h3, .disp_msgform .contact_info .main_contact_info_text h3 { color: '.$color.' !important; }';
		}


		/* SPESIAL WIDGET SETTINGS
		 * ========================================================================== */
		 if( $this->get_setting('sw_rm_button') == 0 ) {
 			$custom_css .= '
 			.widget_core_coll_post_list .item_content a,
 			.widget_core_coll_featured_posts .item_content a,
 			.widget_core_coll_related_post_list, .item_content a,
 			.widget_core_coll_page_list .item_content a,
 			.widget_core_coll_item_list .item_content a,
 			.widget_core_coll_flagged_list .item_content a,
 			.widget_core_coll_post_list .item_excerpt a,
 			.widget_core_coll_featured_posts .item_excerpt a,
 			.widget_core_coll_related_post_list, .item_excerpt a,
 			.widget_core_coll_page_list .item_excerpt a,
 			.widget_core_coll_item_list .item_excerpt a,
 			.widget_core_coll_flagged_list .item_excerpt a
 			{ display: none !important }
 			';
 		}

		if( $color = $this->get_setting( 'sw_bg_wl' ) ) {
			$custom_css .= "div.evo_widget.widget_core_coll_featured_posts.evo_layout_rwd .widget_rwd_blocks .widget_rwd_content, div.evo_widget.widget_core_coll_item_list.evo_layout_rwd .widget_rwd_blocks .widget_rwd_content, div.evo_widget.widget_core_coll_post_list.evo_layout_rwd .widget_rwd_blocks .widget_rwd_content, div.evo_widget.widget_core_coll_page_list.evo_layout_rwd .widget_rwd_blocks .widget_rwd_content, div.evo_widget.widget_core_coll_flagged_list.evo_layout_rwd .widget_rwd_blocks .widget_rwd_content, div.evo_widget.widget_core_coll_related_post_list.evo_layout_rwd .widget_rwd_blocks .widget_rwd_content { background-color: $color; }";
		}

		if( $color = $this->get_setting( 'sw_tag_color' ) ) {
			$custom_css .= ".evo_widget.widget_core_coll_tag_cloud .tag_cloud a { color: $color; }";
		}
		if( $color = $this->get_setting( 'sw_tag_border' ) ) {
			$custom_css .= ".evo_widget.widget_core_coll_tag_cloud .tag_cloud a { border-color: $color; }";
		}
		if( $color = $this->get_setting( 'sw_tag_color_hover' ) ) {
			$custom_css .= ".evo_widget.widget_core_coll_tag_cloud .tag_cloud a:hover, .evo_widget.widget_core_coll_tag_cloud .tag_cloud a:active, .evo_widget.widget_core_coll_tag_cloud .tag_cloud a:focus { color: $color; }";
		}
		if ( $color = $this->get_setting( 'sw_tag_bg_hover' ) ) {
			$custom_css .= ".evo_widget.widget_core_coll_tag_cloud .tag_cloud a:hover, .evo_widget.widget_core_coll_tag_cloud .tag_cloud a:active, .evo_widget.widget_core_coll_tag_cloud .tag_cloud a:focus { background-color: $color; border-color: $color; }";
		}


		/* FOOTER SETTINGS
		 * ========================================================================== */
		if( $bg = $this->get_setting( 'footer_background' ) ) {
			$custom_css .= '#footer { background-color: '.$bg.' }';
		}
		if( $color = $this->get_setting( 'footer_wd_title_color' ) ) {
			$custom_css .= ".footer_widgets .evo_widget .evo_widget_title{ color: $color !important; }";
		}
		if( $color = $this->get_setting( 'footer_wd_content_color' ) ) {
			$custom_css .= ".footer_widgets .evo_widget .evo_widget_body{ color: $color; }";
			$custom_css .= "#footer .footer_bottom .copyright { color: $color; }";
		}
		if( $color = $this->get_setting( 'footer_wd_color_link' ) ) {
			$custom_css .= "#footer .footer_widgets .evo_widget ul a{ color: $color }";
			$custom_css .= "#footer .footer_widgets .evo_widget a{ color: $color }";
			$custom_css .= "#footer .footer_bottom .copyright a { color: $color; }";
			$custom_css .= "#footer .footer_bottom .social_icon .ufld_icon_links a{ color: $color; }";
			$custom_css .= ".footer_widgets .evo_widget.widget_core_coll_tag_cloud .evo_widget_body .tag_cloud a:hover, .footer_widgets .evo_widget.widget_core_coll_tag_cloud .evo_widget_body .tag_cloud a:active, .footer_widgets .evo_widget.widget_core_coll_tag_cloud .evo_widget_body .tag_cloud a:focus { background-color: $color; border-color: $color; }";
		}
		if( $color = $this->get_setting( 'footer_wd_color_lh' ) ) {
			$custom_css .= "#footer .footer_widgets .evo_widget ul a:hover, #footer .footer_widgets .evo_widget ul a:active, #footer .footer_widgets .evo_widget ul a:focus{ color: $color; }";
			$custom_css .= "#footer .footer_bottom .copyright a:hover, #footer .footer_bottom .copyright a:active, #footer .footer_bottom .copyright a:focus  { color: $color; }";
		}
		if( $color = $this->get_setting( 'footer_border_color' ) ) {
			$custom_css .= "#footer .footer_widgets{ border-bottom-color: $color; }";
			$custom_css .= ".footer_widgets .evo_widget.widget_core_coll_tag_cloud .evo_widget_body .tag_cloud a{ border-color: $color; }";
		}


		/* STYLE OUTPUT
		 * ========================================================================== */
		if( ! empty( $custom_css ) )
		{	// Function for custom_css:
			$custom_css = '<style type="text/css">
<!--
'.$custom_css.'
-->
		</style>';
			add_headline( $custom_css );
		}
	}


	/**
	 * Check if we can display a widget container
	 *
	 * @param string Widget container key: 'header', 'menu', 'sidebar', 'footer'
	 * @param string Skin setting name
	 * @return boolean TRUE to display
	 */
	function is_visible_container( $container_key, $setting_name = 'access_login_containers' )
	{
		$access = $this->get_setting( $setting_name );
		return ( ! empty( $access ) && ! empty( $access[ $container_key ] ) );
	}


	/**
	 * Get value for attbiute "class" of column block
	 * depending on skin setting "Layout"
	 *
	 * @return string
	 */
	function get_column_class( $id = 'layout' )
	{

		$id_skin = $this->get_setting( $id );

		switch( $id_skin )
		{
			case 'single_column':
				// Single Column Large
				return 'col-md-12';

			case 'single_column_normal':
				// Single Column
				return 'col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1';

			case 'single_column_narrow':
				// Single Column Narrow
				return 'col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2';

			case 'single_column_extra_narrow':
				// Single Column Extra Narrow
				return 'col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3';

			case 'left_sidebar':
				// Left Sidebar
				return 'col-sm-8 col-md-8 pull-right';

			case 'right_sidebar':
				// Right Sidebar
			default:
				return 'col-sm-8 col-md-8';
		}
	}

	/**
	 * Check if we can display a sidebar for the current layout
	 *
	 * @param boolean TRUE to check if at least one sidebar container is visible
	 * @return boolean TRUE to display a sidebar
	 */
	function is_visible_sidebar( $check_containers = false )
	{
		global $disp;

		$layout = '';
		if( $disp == 'posts' ) {
			$layout = $this->get_setting('posts_layout');
		} else {
			$layout = $this->get_setting('layout');
		}


		if( $layout != 'left_sidebar' && $layout != 'right_sidebar' )
		{ // Sidebar is not displayed for selected skin layout
			return false;
		}

		if( $check_containers )
		{ // Check if at least one sidebar container is visible
			return ( $this->is_visible_container( 'sidebar' ) ||  $this->is_visible_container( 'sidebar2' ) );
		}
		else
		{ // We should not check the visibility of the sidebar containers for this case
			return true;
		}
	}


}

?>
