<?php
/**
 * This is the template that displays the item block: title, author, content (sub-template), tags, comments (sub-template)
 *
 * This file is not meant to be called directly.
 * It is meant to be called by an include in the main.page.php template (or other templates)
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/gnu-gpl-license}
 * @copyright (c)2003-2016 by Francois Planque - {@link http://fplanque.com/}
 *
 * @package evoskins
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $Item, $Skin, $app_version, $disp, $Blog;

// Default params:
$params = array_merge( array(
	'feature_block'              => false,			// fp>yura: what is this for??
	// Classes for the <article> tag:
	'item_class'                 => 'evo_single_article evo_post evo_content_block',
	'item_type_class'            => 'evo_post__ptyp_',
	'item_status_class'          => 'evo_post__',
	'author_link_text'        	 => 'name', // avatar_name | avatar_login | only_avatar | name | login | nickname | firstname | lastname | fullname | preferredname
	'item_style'                 => '',
	// Controlling the title:
	'disp_title'                 => true,
	'item_title_line_before'     => '<div class="evo_post_title">',	// Note: we use an extra class because it facilitates styling
	'item_title_before'          => '<h2>',
	'item_title_after'           => '</h2>',
	'item_title_single_before'   => '<h1>',	// This replaces the above in case of disp=single or disp=page
	'item_title_single_after'    => '</h1>',
	'item_title_line_after'      => '</div>',

	// Controlling the content:
	'content_mode'               => 'excerpt',		// excerpt|full|normal|auto -- auto will auto select depending on $disp-detail
	'image_class'                => 'img-responsive',
	'image_size'                 => 'fit-1280x720',

	'excerpt_more_text'          => T_('Read More').' <span class="ei ei-arrow_right"></span>',
), $params );

/* LAYOUT POST AND SINGLE DISP
 * ========================================================================== */
$content_class = '';
$layout = '';
$posts_column = $Skin->change_class( 'posts_column' );

if ( $disp == 'single' || $disp == 'page' ) {
	$content_class  = 'evo_content_single';
	$layout 		= ' one_column';

} elseif( $disp == 'posts' && !$Item->is_intro() ) {
	$content_class  = 'evo_post_lists picture-item filtr-item';
	$layout 		= " $posts_column";
}
elseif(  $Item->is_intro() ) {
	$content_class  = 'evo_intro_block';
	$layout 		= ' one_columns';
}


/* CATEGORY POST ID
 * ========================================================================== */
$Chapters = $Item->get_Chapters();
$cat_id = '';
foreach ( $Chapters as $Chapter ) {
	$cat_id .= $Chapter->get( 'ID' ).', ';
}
$cat_id = substr($cat_id, 0, strlen($cat_id) - 2);

$data_cat = '';
if ( $disp == 'posts' ) {
	$data_cat = "data-category=\"$cat_id\"";
}

/* IMAGE POSTS SETTINGS
 * ========================================================================== */
$content_mode = $Blog->get_setting('main_content');
$content_post = '';
$img_position = '';

if ( $content_mode == 'excerpt' ) {
	$content_post .= 'excerpt';
	$img_position .= 'teaser';
} elseif( $content_mode == 'full') {
	$content_post .= 'full';
	$img_position .= 'cover';
} elseif( $content_mode == 'normal') {
	$content_post .= 'normal';
	$img_position .= 'cover';
}

if ( $Item->is_featured() ) {
	echo '<div class="featured_posts '.$content_class.$layout.'" '.$data_cat.'>';
} else {
	echo '<div class="'.$content_class.$layout.'" '.$data_cat.'>'; // Beginning of post display
}

if( $disp == 'single' || $disp == 'page' )
{	// Display images that are linked to this post:
	$Item->images( array(
		'before'              => '<div class="evo_cover_image">',
		'before_images'       => '',
		'before_image'        => '<figure class="evo_image_block">',
		'before_image_legend' => '<figcaption class="evo_image_legend">',
		'after_image_legend'  => '</figcaption>',
		'after_image'         => '</figure>',
		'after_images'        => '',
		'after'               => '</div>',
		'image_class'         => 'img-responsive',
		'image_size'          => $params['image_size'],
		'limit'               =>  1,
		'image_link_to'       => 'original', // Can be 'original', 'single' or empty
		// We DO NOT want to display galleries here, only one cover image
		'gallery_image_limit' => 0,
		'gallery_colls'       => 0,
		// We want ONLY cover image to display here
		'restrict_to_image_position' => 'cover',
	) );
}

?>
<article id="<?php $Item->anchor_id() ?>" class="<?php $Item->div_classes( $params ) ?>" lang="<?php $Item->lang() ?>"<?php
	echo empty( $params['item_style'] ) ? '' : ' style="'.format_to_output( $params['item_style'], 'htmlattr' ).'"' ?>>
	<?php
		$Item->locale_temp_switch();

		if( $content_mode == $content_post && $disp == 'posts' && ! $Item->is_intro() )
		{	// Display images that are linked to this post:
			$Item->images( array(
				'before'              => '<div class="evo_post_image">',
				'before_images'       => '',
				'before_image'        => '<figure class="evo_image_block">',
				'before_image_legend' => '<figcaption class="evo_image_legend">',
				'after_image_legend'  => '</figcaption>',
				'after_image'         => '</figure>',
				'after_images'        => '',
				'after'               => '</div>',

				'image_class'         => 'img-responsive',
				'image_size'          => $params['image_size'],
				'limit'               => 1,
				'image_link_to'       => 'single', // Can be 'original', 'single' or empty
				// We DO NOT want to display galleries here, only one cover image
				'gallery_image_limit' => 0,
				'gallery_colls'       => 0,
				// We want ONLY cover image to display here
				'restrict_to_image_position' => $img_position,
			) );
		}
	?>

	<header>
	<?php
		$title_before = '';
		$title_after  = '';
		$edit_link    = '';
		// ------- Title -------
		if( $disp == 'single' || $disp == 'page' )
		{
			$title_before = $params['item_title_single_before'];
			$title_after = $params['item_title_single_after'];
		}
		else
		{
			$title_before = $params['item_title_before'];
			$title_after = $params['item_title_after'];
		}

		// EDIT LINK:
		if( $Item->is_intro() )
		{ // Display edit link only for intro posts, because for all other posts the link is displayed on the info line.
			ob_start();
			$Item->edit_link( array(
				'before' => '<div class="'.button_class( 'group' ).'">',
				'after'  => '</div>',
				'text'   => $Item->is_intro() ? get_icon( 'edit' ).' '.T_('Edit Intro') : '#',
				'class'  => button_class( 'text' ),
			) );
			$edit_link = ob_get_contents();
			ob_end_clean();
		}
	?>

	<?php
	if( ! $Item->is_intro() )
	{	// Don't display the following for intro posts
		if( $disp == 'posts' )
		{
			// ------------------------- "Item in List" CONTAINER EMBEDDED HERE --------------------------
			// Display container contents:
			widget_container( 'item_in_list', array(
				'widget_context' => 'item',	// Signal that we are displaying within an Item
				// The following (optional) params will be used as defaults for widgets included in this container:
				'container_display_if_empty' => false, // If no widget, don't display container at all
				// This will enclose each widget in a block:
				'block_start' => '<div class="evo_widget $wi_class$">',
				'block_end' => '</div>',
				// This will enclose the title of each widget:
				'block_title_start' => '<h3>',
				'block_title_end' => '</h3>',
				'author_link_text' => $params['author_link_text'],
				// Template params for "Item Title" widget:
				'widget_item_title_display' => $params['disp_title'],
				'widget_item_title_params'  => array(
						'before' => '<div class="evo_post_title">'.$title_before,
						'after'  => $title_after.'</div>',
					),
				// Template params for "Item Visibility Badge" widget:
				'widget_item_visibility_badge_display' => ( ! $Item->is_intro() && $Item->status != 'published' ),
				'widget_item_visibility_badge_params'  => array(
						'template' => '<div class="evo_status evo_status__$status$ badge pull-right" data-toggle="tooltip" data-placement="top" title="$tooltip_title$">$status_title$</div>',
					),
				// Template params for "Item Info Line" widget:
				'widget_item_info_line_before' => '<div class="evo_post_info">',
				'widget_item_info_line_after'  => '</div>',
				'widget_item_info_line_params' => array(
						'before_flag'         => '',
						'after_flag'          => ' ',
						'before_permalink'    => '',
						'after_permalink'     => ' ',
						'before_author'       => '<span class="divider">/</span>',
						'after_author'        => '',
						'before_post_time'    => '',
						'after_post_time'     => '',
						'before_categories'   => '<span class="divider">/</span>',
						'after_categories'    => '',
						'before_last_touched' => '<span class="divider">/</span>'.T_('Last touched').': ',
						'after_last_touched'  => '',
						'before_last_updated' => '<span class="divider">/</span>'.T_('Contents updated').': ',
						'after_last_updated'  => '',
						'before_edit_link'    => '<span class="divider">/</span>',
						'after_edit_link'     => '',
						'format'              => '$flag$$permalink$$post_time$$author$$edit_link$',
					),
			) );
			// ----------------------------- END OF "Item in List" CONTAINER -----------------------------
		}
		elseif( $disp == 'single' )
		{
			// ------------------------- "Item Single - Header" CONTAINER EMBEDDED HERE --------------------------
			// Display container contents:
			$link_all_blog = $Blog->get( 'recentpostsurl' );
			widget_container( 'item_single_header', array(
					'widget_context' => 'item',	// Signal that we are displaying within an Item
					// The following (optional) params will be used as defaults for widgets included in this container:
					'container_display_if_empty' => false, // If no widget, don't display container at all
					// This will enclose each widget in a block:
					'block_start' => '<div class="evo_widget $wi_class$">',
					'block_end'   => '</div>',
					// This will enclose the title of each widget:
					'block_title_start' => '<h3>',
					'block_title_end'   => '</h3>',
					'author_link_text' => 'name',
					// Template params for "Item Title" widget:
					'widget_item_title_display' => $params['disp_title'],
					'widget_item_title_params'  => array(
							'before'    => '<div class="evo_post_title">'.$title_before,
							'after'    => $title_after.'</div>',
							'link_type'=> '#',
						),
					// Template params for "Item Previous Next" widget:
					'widget_item_next_previous_params' => array(
							'block_start' => '<nav class="single_pager clearfix"><ul>',
							'prev_start'  => '<li class="previous">',
							'prev_text'   => '<i class="ei ei-arrow_carrot-left"></i> '.T_('Prev'),
							'prev_class'  => '',
							'prev_end'    => '</li>',
							'separator'   => '<li><a href="'.$link_all_blog.'">'.T_('All Posts').'</a></li>',
							'next_start'  => '<li class="next">',
							'next_text'   => T_('Next').' <i class="ei ei-arrow_carrot-right"></i>',
							'next_class'  => '',
							'next_end'    => '</li>',
							'block_end'   => '</ul></nav>',
						),
					// Template params for "Item Visibility Badge" widget:
					'widget_item_visibility_badge_display' => ( ! $Item->is_intro() && $Item->status != 'published' ),
					'widget_item_visibility_badge_params'  => array(
							'template' => '<div class="evo_post_info pull-right"><div class="evo_status evo_status__$status$ badge" data-toggle="tooltip" data-placement="top" title="$tooltip_title$">$status_title$</div></div>',
						),
					// Template params for "Item Info Line" widget:
					'widget_item_info_line_before' => '<div class="evo_post_info">',
					'widget_item_info_line_after'  => '</div>',
					'widget_item_info_line_params' => array(
							'before_flag'         => '',
							'after_flag'          => ' ',
							'before_permalink'    => '',
							'after_permalink'     => ' ',
							'before_author'       => '<span class="divider">/</span>',
							'after_author'        => '',
							'before_post_time'    => '',
							'after_post_time'     => '',
							'before_categories'   => '<span class="divider">/</span>',
							'after_categories'    => '',
							'before_last_touched' => '<span class="divider">/</span>'.T_('Last touched').': ',
							'after_last_touched'  => '',
							'before_last_updated' => '<span class="divider">/</span>'.T_('Contents updated').': ',
							'after_last_updated'  => '',
							'before_edit_link'    => '<span class="divider">/</span>',
							'after_edit_link'     => '',
							'format'              => '$flag$$permalink$$post_time$$author$$categories$$edit_link$',
						),
			) );
			// ----------------------------- END OF "Item Single - Header" CONTAINER -----------------------------
		}
		else
		{
			// ------- Title -------
		if( $params['disp_title'] )
		{
			echo $params['item_title_line_before'];
			if( $disp == 'single' || $disp == 'page' )
			{
				$title_before = $params['item_title_single_before'];
				$title_after = $params['item_title_single_after'];
			}
			else
			{
				$title_before = $params['item_title_before'];
				$title_after = $params['item_title_after'];
			}
			// POST TITLE:
			$Item->title( array(
				'before'    => $title_before,
				'after'     => $title_after,
				'link_type' => '#'
			) );
			// EDIT LINK:
			if( $Item->is_intro() )
			{ // Display edit link only for intro posts, because for all other posts the link is displayed on the info line.
				$Item->edit_link( array(
					'before' => '<div class="'.button_class( 'group' ).'">',
					'after'  => '</div>',
					'text'   => $Item->is_intro() ? get_icon( 'edit' ).' '.T_('Edit Intro') : '#',
					'class'  => button_class( 'text' ),
				) );
			}
			echo $params['item_title_line_after'];
		}

			echo '<div class="evo_post_info">';
			if( $Item->status != 'published' ) {
				$Item->format_status( array(
					'template' => '<div class="evo_status evo_status__$status$ badge pull-right">$status_title$</div>',
				) );
			}
			// Permalink:
			$Item->permanent_link( array(
				'text' => '',
			) );
			// We want to display the post time:
			$Item->issue_time( array(
				'before'      => '',
				'after'       => '',
				'time_format' => 'M j, Y',
			) );
			// Author
			$Item->author( array(
				'before'    => '<span class="divider">/</span>',
				'after'     => '',
				'link_text' => $params['author_link_text'],
			) );
			if ( $disp !== 'posts' ) {
				$Item->categories( array(
					'before'          => '<span class="divider">/</span>',
							'after'           => '',
							'include_main'    => true,
							'include_other'   => true,
							'include_external'=> true,
							'link_categories' => true,
				) );
			}
			// Link for editing
			$Item->edit_link( array(
				'before'    => '<span class="divider">/</span>',
				'after'     => '',
			) );
			echo '</div>';
		}
	}
	?>
	</header>

	<?php
	if( $disp == 'single' )
	{
			// ------------------------- "Item Single" CONTAINER EMBEDDED HERE --------------------------
			// Display container contents:
			widget_container( 'item_single', array(
				'widget_context' => 'item',	// Signal that we are displaying within an Item
				// The following (optional) params will be used as defaults for widgets included in this container:
				'container_display_if_empty' => false, // If no widget, don't display container at all
				'container_start'            => '<div evo_container $wico_class$">',
				'container_end'              => '</div>',
				// This will enclose each widget in a block:
				'block_start' => '<div class="evo_widget $wi_class$">',
				'block_end'   => '</div>',
				// This will enclose the title of each widget:
				'block_title_start' => '<h3>',
				'block_title_end'   => '</h3>',
				// Template params for "Item Tags" widget
				'widget_item_tags_before'    => '<div class="item_tags">',
				'widget_item_tags_after'     => '</div>',
				'widget_item_tags_separator' => '',
				// Params for skin file "_item_content.inc.php"
				'widget_item_content_params' => $params,
			) );
			// ----------------------------- END OF "Item Single" CONTAINER -----------------------------
	}
	elseif( $disp == 'page' )
	{
		// ------------------------- "Item Page" CONTAINER EMBEDDED HERE --------------------------
		// Display container contents:
		widget_container( 'item_page', array(
			'widget_context' => 'item',	// Signal that we are displaying within an Item
			// The following (optional) params will be used as defaults for widgets included in this container:
			'container_display_if_empty' => false, // If no widget, don't display container at all
			// This will enclose each widget in a block:
			'block_start' => '<div class="evo_widget $wi_class$">',
			'block_end' => '</div>',
			// This will enclose the title of each widget:
			'block_title_start' => '<h3>',
			'block_title_end' => '</h3>',
			// Template params for "Item Link" widget
			'widget_item_link_before'    => '<p class="evo_post_link">',
			'widget_item_link_after'     => '</p>',
			// Template params for "Item Tags" widget
			'widget_item_tags_before'    => '<nav class="small post_tags">'.T_('Tags').': ',
			'widget_item_tags_after'     => '</nav>',
			// Params for skin file "_item_content.inc.php"
			'widget_item_content_params' => $params,
			// Template params for "Item Attachments" widget:
			'widget_item_attachments_params' => array(
					'limit_attach'       => 1000,
					'before'             => '<div class="evo_post_attachments"><h3>'.T_('Attachments').':</h3><ul class="evo_files">',
					'after'              => '</ul></div>',
					'before_attach'      => '<li class="evo_file">',
					'after_attach'       => '</li>',
					'before_attach_size' => ' <span class="evo_file_size">(',
					'after_attach_size'  => ')</span>',
				),
			// Controlling the title:
			'widget_item_title_params'  => array(
				'before' => '<div class="evo_post_title">'.( in_array( $disp, array( 'single', 'page' ) ) ? '<h1>' : '<h2>' ),
				'after' => ( in_array( $disp, array( 'single', 'page' ) ) ? '</h1>' : '</h2>' ).'</div>',
			),
		) );
		// ----------------------------- END OF "Item Page" CONTAINER -----------------------------
	}
	else
	{
		// this will create a <section>
		// ---------------------- POST CONTENT INCLUDED HERE ----------------------
		skin_include( '_item_content.inc.php', $params );
		// Note: You can customize the default item content by copying the generic
		// /skins/_item_content.inc.php file into the current skin folder.
		// -------------------------- END OF POST CONTENT -------------------------
		// this will end a </section>
	}
	?>

	<?php if( $disp == 'posts' && ! $Item->is_intro() ) : ?>
	<footer class="evo_post_footer_info">
		<div class="evo_readmore_link">
			<a href="<?php echo $Item->get_permanent_url(); ?>"><?php echo T_('Read More'); ?> <span class="ei ei-arrow_right"></span></a>
		</div>

		<nav class="post_comments_link">
		<?php
				// Link to comments, trackbacks, etc.:
				$Item->feedback_link( array(
					'type' 			 => 'comments',
					'link_before' 	 => '',
					'link_after'	 => '',
					'link_text_zero' => '<span class="ei ei-comment_alt"></span> 0',
					'link_text_one'  => '<span class="ei ei-comment_alt"></span> 1',
					'link_text_more' => '<span class="ei ei-comment_alt"></span> %d',
					'link_title' 	 => '#',
					// fp> WARNING: creates problem on home page: 'link_class' => 'btn btn-default btn-sm',
					// But why do we even have a comment link on the home page ? (only when logged in)
				) );

				// Link to comments, trackbacks, etc.:
				$Item->feedback_link( array(
					'type' 			 => 'trackbacks',
					'link_before' 	 => ' &bull; ',
					'link_after' 	 => '',
					'link_text_zero' => '<span class="ei ei-comment_alt"></span> 0',
					'link_text_one'  => '<span class="ei ei-comment_alt"></span> 1',
					'link_text_more' => '<span class="ei ei-comment_alt"></span> %d',
					'link_title' 	 => '#',
				) );
		?>
		</nav>
	</footer>
	<?php endif; ?>

	<?php
	// ------------------- PREV/NEXT POST LINKS (SINGLE POST MODE) -------------------
	$link_all_blog = $Blog->get( 'recentpostsurl' );
	if ( $disp == 'single' ) {
		item_prevnext_links( array(
			'block_start' => '<nav class="single_pager clearfix"><ul>',
			'prev_start'  => '<li class="previous">',
			'prev_text'   => '<i class="ei ei-arrow_carrot-left"></i> '.T_('Prev'),
			'prev_class'  => '',
			'prev_end'    => '</li>',
			'separator'   => '<li><a href="'.$link_all_blog.'">'.T_('All Posts').'</a></li>',
			'next_start'  => '<li class="next">',
			'next_text'   => T_('Next').' <i class="ei ei-arrow_carrot-right"></i>',
			'next_class'  => '',
			'next_end'    => '</li>',
			'block_end'   => '</ul></nav>',
		) );
	}
	// ------------------------- END OF PREV/NEXT POST LINKS -------------------------
	?>

	<div class="evo_single_comments">
		<?php
			global $Session;
			// ------------------ FEEDBACK (COMMENTS/TRACKBACKS) INCLUDED HERE ------------------
			skin_include( '_item_feedback.inc.php', array_merge( array(
				'before_section_title'  => '<div class="clearfix"></div><h3 class="evo_comment__list_title">',
				'after_section_title'   => '</h3>',
				'comment_start'         => '<article class="evo_comment">',
				'comment_end'           => '</article>',
				'comment_post_before'   => '<h3 class="evo_comment_post_title">',
				'comment_post_after'    => '</h3>',
				'comment_title_before'  => '<h4 class="evo_comment_title">',
				'comment_title_after'   => '</h4>',
				'comment_avatar_before' => '<span class="evo_comment_avatar">',
				'comment_avatar_after'  => '</span>',
				'comment_rating_before' => '<div class="evo_comment_rating">',
				'comment_rating_after'  => '</div>',
				'comment_text_before'   => '<div class="evo_comment_text">',
				'comment_text_after'    => '</div>',
				'comment_info_before'   => '<footer class="evo_comment_footer clear text-muted"><small>',
				'comment_info_after'    => '</small></footer>',
				'preview_start'         => '<article class="evo_comment evo_comment__preview panel panel-warning" id="comment_preview">',
				'preview_end'           => '</article>',
				'comment_error_start'   => '<article class="evo_comment evo_comment__error panel panel-default" id="comment_error">',
				'comment_error_end'     => '</article>',
				'form_title_start'      => '<div class="single_comment_form panel '.( $Session->get('core.preview_Comment') ? 'panel-danger' : 'panel-default' ).'"><div class="panel-heading"><h4 class="panel-title">',
			), $params ) );
			// Note: You can customize the default item feedback by copying the generic
			// /skins/_item_feedback.inc.php file into the current skin folder.
			// ---------------------- END OF FEEDBACK (COMMENTS/TRACKBACKS) ---------------------
		?>

		<?php
		if( evo_version_compare( $app_version, '6.7' ) >= 0 )
		{	// We are running at least b2evo 6.7, so we can include this file:
			// ------------------ WORKFLOW PROPERTIES INCLUDED HERE ------------------
			skin_include( '_item_workflow.inc.php' );
			// ---------------------- END OF WORKFLOW PROPERTIES ---------------------
		}
		?>

		<?php
		if( evo_version_compare( $app_version, '6.7' ) >= 0 )
		{	// We are running at least b2evo 6.7, so we can include this file:
			echo '<div class="evo_comment_meta">';
			// ------------------ META COMMENTS INCLUDED HERE ------------------
			skin_include( '_item_meta_comments.inc.php', array(
				'comment_start'         => '<article class="evo_comment evo_comment__meta panel panel-default">',
				'comment_end'           => '</article>',
			) );
			// ---------------------- END OF META COMMENTS ---------------------
			echo '</div>';
		}
		?>
	</div>

	<?php
		locale_restore_previous();	// Restore previous locale (Blog locale)
	?>
</article>

<?php echo '</div>'; // End of post display ?>
