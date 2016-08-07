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
	* Judge if the file is the image we want to use
	*
	* @param string filepath: the path of a file
	* array arr_types: the file type we want to use
	* @return array
	*/
	function isImage( $filepath, $arr_types=array( ".gif", ".jpeg", ".png", ".bmp", ".jpg" ) )
	{
		if(file_exists($filepath)) {
			$info = getimagesize($filepath);
			$ext  = image_type_to_extension($info['2']);
			return in_array($ext,$arr_types);
		} else {
			return false;
		}
	}


	/**
	* Get the pictures of one local folder as an array
	*
	* @param string img_folder; the image folder;
	* string img_folder_url; folder url, we would like to show the img of this folder on the screen for user viewing;
	* int thumb_width: thumb image whdth shown on the skin setting page
	* int thumb_height: thumb image height shown on the skin setting page
	* @return array
	*/
	function get_arr_pics_from_folder( $img_folder, $img_folder_url, $thumb_width = 50, $thumb_height = 50 )
	{
		$arr_filenames = $filesnames =array();
		if(file_exists($img_folder))
		{
			$filesnames = scandir($img_folder);
		}
		$count = 0;
		foreach ( $filesnames as $name )
		{
			$count++;
			if ( $name != "." && $name != ".." && $name != "_evocache" && $this->isImage($img_folder.$name) ) //not the folder and other files
			{
				$arr_filenames[] = array( $img_folder_url.$name,
				"<a href='".$img_folder_url.$name."' target='blank'><img src='".$img_folder_url.$name."' width=".$thumb_width."px heigh=".$thumb_height."px /></a>" );
			}
			if ($count==30) break; // The max number of the images we want to show
		}
		$arr_filenames[] = array("none",T_("Transparent"));
		return $arr_filenames;
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

		// System provide bg images
		$bodybg_cat = 'assets/images/header/'; // Background images folder relative to this skin folder
		$arr_bodybg = $this ->get_arr_pics_from_folder( $this->get_path().$bodybg_cat, $this->get_url().$bodybg_cat, 80, 80 );
		// User Custom bg images
		$custom_headerbg_cat = "headerbg/"; // Background images folder which created by users themselves, and it's relative to collection media dir
		$arr_custom_headerbg = $this->get_arr_pics_from_folder( $Blog->get_media_dir().$custom_headerbg_cat, $Blog->get_media_url().$custom_headerbg_cat, 65 ,65);


		$r = array_merge( array(

			/* LAYOUT OPTIONS
			 * ========================================================================== */
			'section_layout_start' => array(
				'layout' => 'begin_fieldset',
				'label'  => T_('General Settings (All disps)')
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
					'label' => T_('Max image height'),
					'note' => 'px',
					'defaultvalue' => '',
					'type' => 'integer',
					'allow_empty' => true,
				),
				'font_size' => array(
					'label' => T_('Font size'),
					'note' => '',
					'defaultvalue' => 'default',
					'options' => array(
						'default'        => T_('Default (14px)'),
						'standard'       => T_('Standard (16px)'),
						'medium'         => T_('Medium (18px)'),
						'large'          => T_('Large (20px)'),
						'very_large'     => T_('Very large (22px)'),
					),
					'type' => 'select',
				),
				'back_to_top' => array(
					'label'			=> T_( 'Back To Top Button' ),
					'note'			=> T_( 'Check to show back to top button.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
			'section_layout_end' => array(
				'layout' => 'end_fieldset',
			),


			/* CUSTOM OPTIONS
			 * ========================================================================== */
			'section_color_start' => array(
				'layout' => 'begin_fieldset',
				'label'  => T_('Custom Settings (All disps)')
			),
				'page_bg_color' => array(
					'label' => T_('Background color'),
					'note' => T_('E-g: #ff0000 for red'),
					'defaultvalue' => '#ffffff',
					'type' => 'color',
				),
				'page_text_color' => array(
					'label' => T_('Text color'),
					'note' => T_('E-g: #00ff00 for green'),
					'defaultvalue' => '#7e8082',
					'type' => 'color',
				),
				'page_link_color' => array(
					'label' => T_('Link color'),
					'note' => T_('E-g: #00ff00 for green'),
					'defaultvalue' => '#4b4e53',
					'type' => 'color',
				),
				'page_hover_link_color' => array(
					'label' => T_('Hover link color'),
					'note' => T_('E-g: #00ff00 for green'),
					'defaultvalue' => '#101010',
					'type' => 'color',
				),
				'bgimg_text_color' => array(
					'label' => T_('Text color on background image'),
					'note' => T_('E-g: #00ff00 for green'),
					'defaultvalue' => '#ffffff',
					'type' => 'color',
				),
				'bgimg_link_color' => array(
					'label' => T_('Link color on background image'),
					'note' => T_('E-g: #00ff00 for green'),
					'defaultvalue' => '#6cb2ef',
					'type' => 'color',
				),
				'bgimg_hover_link_color' => array(
					'label' => T_('Hover link color on background image'),
					'note' => T_('E-g: #00ff00 for green'),
					'defaultvalue' => '#6cb2ef',
					'type' => 'color',
				),
				'current_tab_text_color' => array(
					'label' => T_('Current tab text color'),
					'note' => T_('E-g: #00ff00 for green'),
					'defaultvalue' => '#333333',
					'type' => 'color',
				),
			'section_color_end' => array(
				'layout' => 'end_fieldset',
			),


			/* NAVIGATION OPTIONS
			* ========================================================================== */
			'section_nav_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Navigation Settings (All disps)' ),
			),
				'nav_sticky' => array(
					'label'			=> T_( 'Sticky Menu' ),
					'note'			=> T_( 'Checklist to enabling sticky navigation when scrooling.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'nav_background' => array(
					'label'			=> T_( 'Background Color' ),
					'note'			=> T_( 'Choose your favorite background color for Main Menu. Default background color is <code>#ffffff</code>' ),
					'type'			=> 'color',
					'defaultvalue'	=> '#ffffff',
				),
				'nav_color_link'	=> array(
					'label'			=> T_( 'Color Link Menu' ),
					'note'			=> T_( 'Choose your favorite color link for navigation. Default color is <code>#4b4e53</code>.' ),
					'type'			=> 'color',
					'defaultvalue'	=> '#4b4e53'
				),
				'nav_color_link_hover' => array(
					'label'			=> T_( 'Color Link Hover Menu' ),
					'note'			=> T_( 'Choose your favorite color link when the menu is hovering. Default color is <code>#111111</code>.' ),
					'type'			=> 'color',
					'defaultvalue'	=> '#111111'
				),
				'nav_bg_transparent' => array(
					'label'			=> T_( 'Background Transparent' ),
					'note'			=> T_( 'Check to make main menu with transparent background.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 0,
				),
				'nav_cl_transparent' => array(
					'label'			=> T_( 'Color Link Nav Background Transparent' ),
					'note'			=> T_( 'Choose your favorite color link when the navigation background transparent. Default color is <code>#ffffff</code>.' ),
					'type'			=> 'color',
					'defaultvalue'	=> '#ffffff',
				),
				'nav_clh_transparent' => array(
					'label'			=> T_( 'Color Link Hover Nav Background Transparent' ),
					'note'			=> T_( 'Choose your favorite color link hover when the navigation background transparent. Default color is <code>#D40000</code>.' ),
					'type'			=> 'color',
					'defaultvalue'	=> '#D40000',
				),
				'nav_search_icon' => array(
					'label'			=> T_( 'Enable Search Icon' ),
					'note'			=> T_( 'Check to enable search icon in main menu.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
			'section_nav_end' => array(
				'layout'	=> 'end_fieldset',
			),


			/* MAIN HEADER OPTIONS
			* ========================================================================== */
			'section_header_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Main Header Settings (All disps)' ),
			),
				'header_padding_top' => array(
					'label'			=> T_( 'Padding Top Header Content' ),
					'note'			=> T_( 'px. Add or encrease padding top content header. Default value is <code>320px</code>.' ),
					'type'			=> 'integer',
					'allow_empty'	=> false,
					'defaultvalue'	=> '320',
					'size'			=> 4,
				),
				'header_content_mode' => array(
					'label'			=> T_( 'Header Content Mode' ),
					'note'			=> T_( 'Select your favorite content mode for conten in header. Default value is <code>Float Mode</code>.' ),
					'type'			=> 'select',
					'options'		=> array(
						'col-md-6 float'	=> T_( 'Float Mode' ),
						'col-md-12 center'	=> T_( 'Center Mode' ),
					),
					'defaultvalue'	=> 'col-md-6 float'
				),
				'header_breadcrumb' => array(
					'label'			=> T_( 'Enable Breadcrumb' ),
					'note'			=> T_( 'Check to enable Breadcrumb content for Header.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'header_bgi_source' => array(
					'label'			=> T_( 'Background Image Source' ),
					'note'			=> T_( 'Set the background image  source for header.' ),
					'type'			=> 'select',
					'options'		=> array(
						'image_asset' => T_( 'Image Asset' ),
						'custom_bg_image' => T_( 'Custom Banckground Image' ),
					),
					'defaultvalue'	=> 'image_asset',
				),
				'header_bg_image' => array(
					'label'			=> T_( 'Background Images' ),
					'note'			=> T_( 'Choose your favorite image for set the header background image.' ),
					'type'			=> 'radio',
					'options'		=> $arr_bodybg,
					'defaultvalue'	=> reset( $arr_bodybg[0] ),
				),
				'header_custom_bgi'	=> array(
					'label'			=> T_( 'Custom Background Image' ),
					'note'			=> T_( '(Please create a folder named <code><b>'.str_replace("/","",$custom_headerbg_cat).'</b></code> in your collection media folder and put the images into it. Now <a href="admin.php?ctrl=files" target="_blank"><i>Create folder or Upload images</i></a>)' ),
					'type'			=> 'radio',
					'options'		=> $arr_custom_headerbg,
					'defaultvalue'	=> reset( $arr_custom_headerbg[0] ),
				),
				'header_bg_pos_x' => array(
					'label'			=> T_( 'Bakcground Position X' ),
					'note'			=> T_( '%. Default value is <code>50%</code>.' ),
					'type'			=> 'integer',
					'allow_empty'	=> false,
					'size'			=> 3,
					'defaultvalue'	=> 50,
				),
				'header_bg_pos_y' => array(
					'label'			=> T_( 'Background Position Y' ),
					'note'			=> T_( '%. Default value is <code>50%</code>.' ),
					'type'			=> 'integer',
					'allow_empty'	=> false,
					'size'			=> 3,
					'defaultvalue'	=> 50,
				),
				'header_bg_attachment'	=> array(
					'label'			=> T_( 'Bakcground Attachment' ),
					'note'			=> T_( '' ),
					'type'			=> 'select',
					'options'		=> array(
						'initial' => T_( 'Initial' ),
						'fixed'	=> T_( 'Fixed' ),
					),
					'defaultvalue'	=> 'initial',
				),
				'header_bg_size' => array(
					'label'			=> T_( 'Background Size' ),
					'note'			=> T_( 'Set the background size.' ),
					'type'			=> 'select',
					'options'		=> array(
						'initial' => T_( 'Initial' ),
						'contain' => T_( 'Contain' ),
						'cover'	  => T_( 'Cover' ),
					),
					'defaultvalue'	=> 'cover',
				),
				'header_overlay' => array(
					'label'			=> T_( 'Color Overlay' ),
					'note'			=> T_( 'Checkbox to enable color overlay for header.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'header_color_overlay' => array(
					'label'			=> T_( 'Change Color Overlay' ),
					'note'			=> T_( 'Choose your favorite color for content overlay in header. Default color is <code>#000000</code>.' ),
					'type'			=> 'color',
					'defaultvalue'	=> '#000000'
				),
				'header_co_opacity' => array(
					'label'			=> T_( 'Opacity Color Overlay' ),
					'note'			=> T_( 'Choose value for opacity color overlay. Default value is <code>0.5</code>.' ),
					'type'			=> 'select',
					'options'		=> array(
						'0'		=> T_( '0' ),
						'0.05'	=> T_( '0.5' ),
						'0.1'	=> T_( '0.1' ),
						'0.15'	=> T_( '0.15' ),
						'0.2'	=> T_( '0.2' ),
						'0.25'	=> T_( '0.25' ),
						'0.3'	=> T_( '0.3' ),
						'0.35'	=> T_( '0.35' ),
						'0.4'	=> T_( '0.4' ),
						'0.45'	=> T_( '0.45' ),
						'0.5'	=> T_( '0.5' ),
						'0.55'	=> T_( '0.55' ),
						'0.6'	=> T_( '0.6' ),
						'0.65'	=> T_( '0.65' ),
						'0.7'	=> T_( '0.7' ),
						'0.75'	=> T_( '0.75' ),
						'0.8'	=> T_( '0.8' ),
						'0.85'	=> T_( '0.85' ),
						'0.9'	=> T_( '0.9' ),
						'0.95'	=> T_( '0.95' ),
						'1'		=> T_( '0.1' ),
					),
					'defaultvalue'	=> '0.5'
				),
			'section_header_end' => array(
				'layout'	=> 'end_fieldset',
			),


			/* POSTS SETTINGS
			 * ========================================================================== */
			'section_posts_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Posts Settings (Posts disps)' ),
			),
				'category_list_filter' => array(
					'label'			=> T_( 'Category List Posts Filters' ),
					'note'			=> T_( 'Check to enable Category list Filters Posts. Default value is <code>Uncheck</code>.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 0,
				),
				'posts_column' => array(
					'label'			=> T_( 'Posts Column' ),
					'note'			=> T_( 'Select column for posts layout. Default value is <code>3 Columns</code>.' ),
					'type'			=> 'select',
					'options'		=> array(
						'one_column'	=> T_( '1 Column' ),
						'two_columns'	=> T_( '2 Columns' ),
						'three_columns'	=> T_( '3 Columns' ),
						'four_columns'	=> T_( '4 Columns' ),
					),
					'defaultvalue'	=> 'three_columns'
				),
				'posts_padding_column' => array(
					'label'			=> T_( 'Padding Post Column' ),
					'note'			=> T_( 'px. Set the padding for column post. Default value is <code>15px</code>.' ),
					'type'			=> 'integer',
					'defaultvalue'	=> '15',
					'size'			=> 3,
					'allow_empty'	=> false,
				),
				'posts_top_pagination' => array(
					'label'			=> T_( 'Top Pagination' ),
					'note'			=> T_( 'Check to enable posts pagination on the top of content. Default value is <code>Uncheck</code>.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 0,
				),
				'posts_pagination_align' => array(
					'label'			=> T_( 'Pagination Align' ),
					'note'			=> T_( 'Select align for pagination on disp posts. Default value is <code>Left</code>.' ),
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


			/* FOOTER OPTIONS
			 * ========================================================================== */
			'section_footer_start' => array(
				'layout'	=> 'begin_fieldset',
				'label'		=> T_( 'Footer Settings (All disps)' ),
			),
				'footer_background'	=> array(
					'label'			=> T_( 'Background Color' ),
					'note'			=> T_( 'Choose your favorite background color for footer container. Default background color is <code>#ffffff</code>.' ),
					'type'			=> 'color',
					'defaultvalue'	=> '#ffffff'
				),
				'footer_widget'	=> array(
					'label'			=> T_( 'Enable Footer Widget' ),
					'note'			=> T_( 'Check to enable footer widget content' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 0,
				),
				'footer_widgets_columns' => array(
					'label'			=> T_( 'Widget Footer Column' ),
					'note'			=> T_( 'Select column for widget footer area. Default value is <code>3 Columns</code>.' ),
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
					'label'			=> T_( 'Widget Color Title' ),
					'note'			=> T_( 'Choose your favorite color for widget title. Default color is <code>#4b4e53</code>.' ),
					'type'			=> 'color',
					'defaultvalue'	=> '#4b4e53'
				),
				'footer_wd_color_link' => array(
					'label'			=> T_( 'Widget Color Link' ),
					'note'			=> T_( 'Choose your favorite color for link in widget. Default color is <code>#7e8082</code>.' ),
					'type'			=> 'color',
					'defaultvalue'	=> '#7e8082',
				),
				'footer_wd_color_lh' => array(
					'label'			=> T_( 'Widget Color Link Hover' ),
					'note'			=> T_( 'Choose your favorite hover color link for widget. Default color is <code>#101010</code>.' ),
					'type'			=> 'color',
					'defaultvalue'	=> '#101010'
				),
				'footer_bottom_mode' => array(
					'label'			=> T_( 'Footer Bottom Mode' ),
					'note'			=> T_( 'Change footer bottom content with mode view. Default value is <code>Float Mode</code>.' ),
					'type'			=> 'select',
					'options'		=> array(
						'float'		=> T_( 'Float Mode' ),
						'center'	=> T_( 'Center Mode' ),
					),
					'defaultvalue'	=> 'float'
				),
				'footer_copyright' => array(
					'label'			=> T_( 'Enable Footer Copyright' ),
					'note'			=> T_( 'Check to enable Footer Copyright.' ),
					'type'			=> 'checkbox',
					'defaultvalue'	=> 1,
				),
				'footer_social_icon' => array(
					'label'			=> T_( 'Enable Social Icon' ),
					'note'			=> T_( 'Check to enable footer social icon.' ),
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
				'label'  => T_('Colorbox Image Zoom (All disps)')
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
				'label'  => T_('Username options (All disps)')
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
				'label'  => T_('When access is denied or requires login... (disp=access_denied and disp=access_requires_login)')
			),
				'access_login_containers' => array(
					'label' => T_('Display on login screen'),
					'note' => '',
					'type' => 'checklist',
					'options' => array(
						array( 'header',   sprintf( T_('"%s" container'), NT_('Header') ),    1 ),
						array( 'page_top', sprintf( T_('"%s" container'), NT_('Page Top') ),  1 ),
						array( 'menu',     sprintf( T_('"%s" container'), NT_('Menu') ),      0 ),
						array( 'sidebar',  sprintf( T_('"%s" container'), NT_('Sidebar') ),   0 ),
						array( 'sidebar2', sprintf( T_('"%s" container'), NT_('Sidebar 2') ), 0 ),
						array( 'footer',   sprintf( T_('"%s" container'), NT_('Footer') ),    1 ) ),
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

		// INCLUDE THE SCRIPTS
		// require_js( $this->get_url().'assets/scripts/shuffle.min.js' );
		require_js( 'assets/scripts/masonry.pkgd.min.js', 'relative' );

		if ( $this->get_setting( 'nav_sticky' ) == 1 ) {
			add_js_headline("
			jQuery( document ).ready( function(event){
				'use strict';
				var sticky = function() {
					var num = 68; //number of pixels before modifying styles
					if( $(window).width() > 1024 ) {
						$(window).bind('scroll', function () {
							if ($(window).scrollTop() > num) {
								$('#nav').addClass('fixed');
								$('.nav_fixed').addClass( 'static' );
							} else {
								$('#nav').removeClass('fixed');
								$('.nav_fixed').removeClass( 'static' );
							}
						});
					};
				};

				sticky();
			});
			");
		}

		if ( $this->get_setting( 'category_list_filter' ) == 1 ) {
			require_js( 'assets/scripts/jquery.filterizr.min.js', 'relative' );
			$layout_cat_list_filter = 'sameWidth';
			add_js_headline("
			jQuery( document ).ready( function(event){
				'use strict';
				var filterizd_var = function() {
					var id = $( '#filters-nav li' );
					var grid = $( '.grid' );

					$( id ).click( function(event) {
						$(id).removeClass('active');
						$(this).addClass('active');
						event.preventDefault();
					});

					//Default options
					var options = {
					   animationDuration: 0.4, //in seconds
					   filter: 'all', //Initial filter
					   delay: 50, //Transition delay in ms
					   delayMode: 'alternate', //'progressive' or 'alternate'
					   easing: 'ease-out',
					   filterOutCss: { //Filtering out animation
					      opacity: 0,
					      transform: 'scale(0.3)'
					   },
					   filterInCss: { //Filtering in animation
					      opacity: 1,
					      transform: 'scale(1)'
					   },
					   layout: '$layout_cat_list_filter', //See layouts
					   selector: '.grid',
					   setupControls: true,
					}

					if( grid != null ){
						var filterizd = $( grid ).filterizr(options);
					}
				};

				$(window).load( function() {
					filterizd_var();
				});
			});
			");
		} else {
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

		// Required Scripts
		require_js( 'assets/scripts/scripts.js', 'relative' );

		// Skin specific initializations:
		global $media_url, $media_path;

		// Add custom CSS:
		$custom_css = '';

		/* CUSTOM SETTINGS
		 * ========================================================================== */
		if( $color = $this->get_setting( 'page_bg_color' ) )
		{ // Custom page background color:
			$custom_css .= 'body { background-color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'page_text_color' ) )
		{ // Custom page text color:
			$custom_css .= 'body { color: '.$color." }\n";
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
		}
		if( $color = $this->get_setting( 'page_hover_link_color' ) )
		{ // Custom page link color on hover:
			$custom_css .= 'a:hover { color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'bgimg_text_color' ) )
		{	// Custom text color on background image:
			$custom_css .= '.evo_hasbgimg { color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'bgimg_link_color' ) )
		{	// Custom link color on background image:
			$custom_css .= '.evo_hasbgimg a { color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'bgimg_hover_link_color' ) )
		{	// Custom link hover color on background image:
			$custom_css .= '.evo_hasbgimg a:hover { color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'current_tab_text_color' ) )
		{ // Custom current tab text color:
			$custom_css .= 'ul.nav.nav-tabs li a.selected { color: '.$color." }\n";
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
					$custom_css .= '.container { font-size: 16px !important'." }\n";
					$custom_css .= '.container input.search_field { height: 100%'." }\n";
					$custom_css .= '.container h1 { font-size: 38px'." }\n";
					$custom_css .= '.container h2 { font-size: 32px'." }\n";
					$custom_css .= '.container h3 { font-size: 26px'." }\n";
					$custom_css .= '.container h4 { font-size: 18px'." }\n";
					$custom_css .= '.container h5 { font-size: 16px'." }\n";
					$custom_css .= '.container h6 { font-size: 14px'." }\n";
					$custom_css .= '.container .small { font-size: 85% !important'." }\n";
					break;

				case 'medium': // When default font size, no CSS entry
					$custom_css .= '.container { font-size: 18px !important'." }\n";
					$custom_css .= '.container input.search_field { height: 100%'." }\n";
					$custom_css .= '.container h1 { font-size: 40px'." }\n";
					$custom_css .= '.container h2 { font-size: 34px'." }\n";
					$custom_css .= '.container h3 { font-size: 28px'." }\n";
					$custom_css .= '.container h4 { font-size: 20px'." }\n";
					$custom_css .= '.container h5 { font-size: 18px'." }\n";
					$custom_css .= '.container h6 { font-size: 16px'." }\n";
					$custom_css .= '.container .small { font-size: 85% !important'." }\n";
					break;

				case 'large': // When default font size, no CSS entry
					$custom_css .= '.container { font-size: 20px !important'." }\n";
					$custom_css .= '.container input.search_field { height: 100%'." }\n";
					$custom_css .= '.container h1 { font-size: 42px'." }\n";
					$custom_css .= '.container h2 { font-size: 36px'." }\n";
					$custom_css .= '.container h3 { font-size: 30px'." }\n";
					$custom_css .= '.container h4 { font-size: 22px'." }\n";
					$custom_css .= '.container h5 { font-size: 20px'." }\n";
					$custom_css .= '.container h6 { font-size: 18px'." }\n";
					$custom_css .= '.container .small { font-size: 85% !important'." }\n";
					break;

				case 'very_large': // When default font size, no CSS entry
					$custom_css .= '.container { font-size: 22px !important'." }\n";
					$custom_css .= '.container input.search_field { height: 100%'." }\n";
					$custom_css .= '.container h1 { font-size: 44px'." }\n";
					$custom_css .= '.container h2 { font-size: 38px'." }\n";
					$custom_css .= '.container h3 { font-size: 32px'." }\n";
					$custom_css .= '.container h4 { font-size: 24px'." }\n";
					$custom_css .= '.container h5 { font-size: 22px'." }\n";
					$custom_css .= '.container h6 { font-size: 20px'." }\n";
					$custom_css .= '.container .small { font-size: 85% !important'." }\n";
					break;
			}
		}


		/* NAVIGATION SETTINGS
		 * ========================================================================== */
		if( $bg = $this->get_setting( 'nav_background' ) ) {
			$custom_css .= '#nav, #nav.fixed { background-color: '.$bg.' }';
		}
		if( $trans = $this->get_setting( 'nav_bg_transparent' ) ) {
			$custom_css .= '#nav { background-color: transparent }';
		}
		if( $this->get_setting( 'nav_bg_transparent' ) == 1 ) {
			$color_nav_bgt = $this->get_setting( 'nav_cl_transparent' );
			$custom_css .= '#nav.nav_bgt .nav_tabs ul a, #nav.nav_bgt .navbar-header .navbar-brand h3 a { color: '.$color_nav_bgt.' }';
			$custom_css .= '#nav.nav_bgt .search_icon .search_tringger:before { border-color: '.$color_nav_bgt.' }';
			$custom_css .= '#nav.nav_bgt .search_icon .search_tringger:after { background-color: '.$color_nav_bgt.' }';
			$custom_css .= '#nav.nav_bgt .navbar-header .navbar-toggle .icon-bar { background-color: '.$color_nav_bgt.'; }';

			$color_hov_nav_bgt = $this->get_setting( 'nav_clh_transparent' );
			$custom_css .= '#nav.nav_bgt .nav_tabs ul a:hover, #nav .nav_tabs ul a:active, #nav.nav_bgt .nav_tabs ul a:focus { color: '.$color_hov_nav_bgt.' }';
			$custom_css .= '#nav.nav_bgt .nav_tabs ul li.active > a { color: '.$color_hov_nav_bgt.'; border-color: '.$color_hov_nav_bgt.' }';
		}

		// SETTING DEFAULT
		if( $color  = $this->get_setting( 'nav_color_link' ) ) {
			$custom_css .= '#nav .nav_tabs ul a, #nav .navbar-header .navbar-brand h3 a { color: '.$color.' }';
			$custom_css .= '#nav .search_icon .search_tringger:before { border-color: '.$color.' }';
			$custom_css .= '#nav .search_icon .search_tringger:after { background-color: '.$color.' }';
			$custom_css .= '#nav .navbar-header .navbar-toggle .icon-bar { background-color: '.$color.'; }';

			$custom_css .= '#nav.fixed .nav_tabs ul a, #nav.fixed .navbar-header .navbar-brand h3 a { color: '.$color.' }';
			$custom_css .= '#nav.fixed .search_icon .search_tringger:before { border-color: '.$color.' }';
			$custom_css .= '#nav.fixed .search_icon .search_tringger:after { background-color: '.$color.' }';
			$custom_css .= '#nav.fixed .navbar-header .navbar-toggle .icon-bar { background-color: '.$color.'; }';
		}
		if( $hover = $this->get_setting( 'nav_color_link_hover' ) ) {
			$custom_css .= '#nav .nav_tabs ul a:hover, #nav .nav_tabs ul a:active, #nav .nav_tabs ul a:focus { color: '.$hover.' }';
			$custom_css .= '#nav .nav_tabs ul li.active > a { color: '.$hover.'; border-color: '.$hover.' }';

			$custom_css .= '#nav.fixed .nav_tabs ul a:hover, #nav .nav_tabs ul a:active, #nav.fixed .nav_tabs ul a:focus { color: '.$hover.' }';
			$custom_css .= '#nav.fixed .nav_tabs ul li.active > a { color: '.$hover.'; border-color: '.$hover.' }';
		}


		/* MAIN HEADER SETTINGS
		 * ========================================================================== */
		if( $padding = $this->get_setting( 'header_padding_top' ) ) {
			$custom_css .= '@media screen and ( min-width: 1024px ) { #main_header { padding-top: '.$padding.'px } }';
		}

		if( $this->get_setting( 'header_bgi_source' ) == 'image_asset' ) {
			$header_bgi_asset = $this->get_setting( 'header_bg_image' );
			$custom_css .= '#main_header { background-image: url( \''.$header_bgi_asset.'\' ) }';
		} else {
			$header_bgi_custom = $this->get_setting( 'header_custom_bgi' );
			$custom_css .= '#main_header { background-image: url( \''.$header_bgi_custom.'\' ) }';
		}

		$bg_header_x = $this->get_setting( 'header_bg_pos_x');
		$bg_header_y = $this->get_setting( 'header_bg_pos_y');
		if( !empty($bg_header_x) || !empty($bg_header_y)  ) {
			$custom_css .= '#main_header{ background-position: '.$bg_header_x.'% '.$bg_header_y.'%; }';
		}

		if( $bg_header_attach = $this->get_setting( 'header_bg_attachment' ) ) {
			$custom_css .= '#main_header { background-attachment: '.$bg_header_attach.' }';
		}
		if( $bg_header_size  = $this->get_setting( 'header_bg_size' ) ) {
			$custom_css .= '#main_header { background-size: '.$bg_header_size.' }';
		}
		if( $this->get_setting( 'header_overlay' ) == 0 ) {
			$custom_css .= '#main_header:after{ display: none; }';
		} else {
			$header_color_overlay = $this->get_setting( 'header_color_overlay' );
			$header_cov_opacity = $this->get_setting( 'header_co_opacity' );
			$custom_css .= '#main_header:after { background-color: '.$header_color_overlay.'; opacity: '.$header_cov_opacity.' }';
		}

		/* POSTS SETTINGS
		 * ========================================================================== */
		if ( $padding = $this->get_setting( 'posts_padding_column' ) ) {
			$custom_css .= '.disp_posts #grid_posts .evo_post_article { padding: 0 '.$padding.'px; }';
			$custom_css .= '.disp_posts #grid_posts { margin-left: -'.$padding.'px; margin-right: -'.$padding.'px; }';
		}

		/* FOOTER SETTINGS
		 * ========================================================================== */
		if( $bg = $this->get_setting( 'footer_background' ) ) {
			$custom_css .= '#footer { background-color: '.$bg.' }';
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
	 * @param string Widget container key: 'header', 'page_top', 'menu', 'sidebar', 'sidebar2', 'footer'
	 * @return boolean TRUE to display
	 */
	function is_visible_container( $container_key )
	{
		global $Blog;

		if( $Blog->has_access() )
		{	// If current user has an access to this collection then don't restrict containers:
			return true;
		}

		// Get what containers are available for this skin when access is denied or requires login:
		$access = $this->get_setting( 'access_login_containers' );

		return ( ! empty( $access ) && ! empty( $access[ $container_key ] ) );
	}


	/**
	 * Check if we can display a sidebar for the current layout
	 *
	 * @param boolean TRUE to check if at least one sidebar container is visible
	 * @return boolean TRUE to display a sidebar
	 */
	function is_visible_sidebar( $check_containers = false )
	{
		$layout = $this->get_setting( 'layout' );

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


	/**
	 * Get value for attbiute "class" of column block
	 * depending on skin setting "Layout"
	 *
	 * @return string
	 */
	function get_column_class()
	{

		switch( $this->get_setting( 'layout' ) )
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

}

?>
