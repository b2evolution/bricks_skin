
<?php
/**
 * This is the template that displays the posts for a blog
 *
 * This file is not meant to be called directly.
 * It is meant to be called by an include in the main.page.php template.
 * To display the archive directory, you should call a stub AND pass the right parameters
 * For example: /blogs/index.php?disp=posts
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/gnu-gpl-license}
 * @copyright (c)2003-2016 by Francois Planque - {@link http://fplanque.com/}
 *
 * @package evoskins
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $Skin;

$pag_align = $Skin->change_class( 'posts_pagination_align' );


// -------------------- PREV/NEXT PAGE LINKS (POST LIST MODE) --------------------
if ( $Skin->get_setting( 'posts_top_pagination' ) == 1 && $Blog->get_setting( 'posts_per_page' ) >= 5 ) :
	mainlist_page_links( array(
		'block_start'           => '<div class="evo_post_pagination '.$pag_align.' top_pagin"><ul class="pagination">',
		'block_end'             => '</ul></div>',
		'page_item_before'      => '<li>',
		'page_item_after'       => '</li>',
		'page_item_current_before' => '<li class="active">',
		'page_item_current_after'  => '</li>',
		'page_current_template' => '<span>$page_num$</span>',
		'prev_text'             => '<i class="ei ei-arrow_carrot-left"></i>',
		'next_text'             => '<i class="ei ei-arrow_carrot-right"></i>',
	) );
endif;
// ------------------------- END OF PREV/NEXT PAGE LINKS -------------------------
echo '<div id="grid_posts" class="grid clearfix">';
// --------------------------------- START OF POSTS -------------------------------------
// Display message if no post:
display_if_empty();
while( mainlist_get_item() )
{ // For each blog post, do everything below up to the closing curly brace "}"
	// ---------------------- ITEM BLOCK INCLUDED HERE ------------------------

	skin_include( '_item_block.inc.php', array_merge( array(
		'content_mode' => 'auto', // 'auto' will auto select depending on $disp-detail
	), $params ) );
	// ----------------------------END ITEM BLOCK  ----------------------------


} // ---------------------------------- END OF POSTS ------------------------------------
echo '</div>';
// -------------------- PREV/NEXT PAGE LINKS (POST LIST MODE) --------------------

if ( $Blog->get_setting( 'posts_per_page' ) >= 3 ) {
mainlist_page_links( array(
	'block_start'           => '<div class="evo_post_pagination '.$pag_align.'"><ul class="pagination">',
	'block_end'             => '</ul></div>',
	'page_current_template' => '<span>$page_num$</span>',
	'page_item_before'      => '<li>',
	'page_item_after'       => '</li>',
	'page_item_current_before' => '<li class="active">',
	'page_item_current_after'  => '</li>',
	'prev_text'             => '<i class="ei ei-arrow_carrot-left"></i>',
	'next_text'             => '<i class="ei ei-arrow_carrot-right"></i>',
) );
}
// ------------------------- END OF PREV/NEXT PAGE LINKS -------------------------
?>
