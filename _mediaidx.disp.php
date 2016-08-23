<?php
/**
 * This is the template that displays the media index for a blog
 *
 * This file is not meant to be called directly.
 * It is meant to be called by an include in the main.page.php template.
 * To display the archive directory, you should call a stub AND pass the right parameters
 * For example: /blogs/index.php?disp=arcdir
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/gnu-gpl-license}
 * @copyright (c)2003-2016 by Francois Planque - {@link http://fplanque.com/}
 *
 * @package evoskins
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $thumbnail_sizes, $Item;

// $link = $Item->get_permanent_url();

// Merge the params from current skin
$params = array_merge( array(
	'mediaidx_thumb_size' => 'crop-480x320'
), $params );

// $photocell_styles = '';
// if( isset( $thumbnail_sizes[ $params['mediaidx_thumb_size'] ] ) )
// {
// 	$photocell_styles = ' style="width:'.$thumbnail_sizes[ $params['mediaidx_thumb_size'] ][1].'px;'
// 		.'height:'.$thumbnail_sizes[ $params['mediaidx_thumb_size'] ][2].'px"';
// }

// --------------------------------- START OF MEDIA INDEX --------------------------------
skin_widget( array(
	// CODE for the widget:
	'widget'              => 'coll_media_index',
	// Optional display params
	'block_start'         => '<div class="evo_widget $wi_class$">',
	'block_end'           => '</div>',
	'block_display_title' => false,

    'disp_image_title'    => true,
	'thumb_size'          => $params['mediaidx_thumb_size'],
	'thumb_layout'        => 'list',

    'list_start'          => '<ul class="main_content_gallery">',
    'list_end'            => '</ul>',
    'item_start'          => '<li class="content_gallery three_columns"><div class="evo_image_gallery">',
    'item_end'            => '</div></li>',

    'link_default_class'  => 'default',
	'link_selected_class' => 'selected',
	'item_text_start'     => '',
	'item_text_end'       => '',
	'item_text'           => '%s',

    'link_type'           => 'canonic',		// 'canonic' | 'context' (context will regenrate URL injecting/replacing a single filter)

	'order_by'            => $Blog->get_setting('orderby'),
	'order_dir'           => $Blog->get_setting('orderdir'),
	'limit'               => 1000,
) );
// ---------------------------------- END OF MEDIA INDEX ---------------------------------

?>