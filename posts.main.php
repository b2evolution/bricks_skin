<?php
/**
 * This is the main/default page template for the "bootstrap_blog" skin.
 *
 * This skin only uses one single template which includes most of its features.
 * It will also rely on default includes for specific dispays (like the comment form).
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://b2evolution.net/man/skin-development-primer}
 *
 * The main page template is used to display the blog when no specific page template is available
 * to handle the request (based on $disp).
 *
 * @package evoskins
 * @subpackage bootstrap_blog
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

if( evo_version_compare( $app_version, '6.4' ) < 0 )
{ // Older skins (versions 2.x and above) should work on newer b2evo versions, but newer skins may not work on older b2evo versions.
	die( 'This skin is designed for b2evolution 6.4 and above. Please <a href="http://b2evolution.net/downloads/index.html">upgrade your b2evolution</a>.' );
}

global $cat, $disp, $Item;

$header = '';
if ( $Skin->get_setting( 'posts_header' ) == 'header_main' ) {
	$header = '_body_header.inc.php';
} else {
	$header = '_body_header_page.inc.php';
}

// This is the main template; it may be used to display very different things.
// Do inits depending on current $disp:
skin_init( $disp );

// -------------------------- HTML HEADER INCLUDED HERE --------------------------
skin_include( '_html_header.inc.php', array() );
// -------------------------------- END OF HEADER --------------------------------


// ---------------------------- SITE HEADER INCLUDED HERE ----------------------------
// If site headers are enabled, they will be included here:
skin_include( $header );
// ------------------------------- END OF SITE HEADER --------------------------------
?>

<div id="content">
	<div class="container">
		<div class="row">

			<div id="main_content" class="<?php echo $Skin->get_column_class('posts_layout'); ?>">
				<!-- ================================= START OF MAIN AREA ================================== -->
				<?php
				if( ! in_array( $disp, array( 'login', 'lostpassword', 'register', 'activateinfo', 'access_requires_login' ) ) )
				{ // Don't display the messages here because they are displayed inside wrapper to have the same width as form
					// ------------------------- MESSAGES GENERATED FROM ACTIONS -------------------------
					messages( array(
						'block_start' => '<div class="action_messages">',
						'block_end'   => '</div>',
					) );
					// --------------------------------- END OF MESSAGES ---------------------------------
				}
				?>

				<?php
					// ------------------- PREV/NEXT POST LINKS (SINGLE POST MODE) -------------------
					item_prevnext_links( array(
						'block_start' => '<nav><ul class="pager">',
						'prev_start'  => '<li class="previous">',
						'prev_end'    => '</li>',
						'next_start'  => '<li class="next">',
						'next_end'    => '</li>',
						'block_end'   => '</ul></nav>',
					) );
					// ------------------------- END OF PREV/NEXT POST LINKS -------------------------
				?>

				<?php
					// ------------------------ TITLE FOR THE CURRENT REQUEST ------------------------
					request_title( array(
						'title_before'      => '<h2 class="evo_title_disp">',
						'title_after'       => '</h2>',
						'title_none'        => '',
						'glue'              => ' - ',
						'title_single_disp' => false,
						'title_page_disp'   => false,
						'format'            => 'htmlbody',
						'register_text'     => '',
						'login_text'        => '',
						'lostpassword_text' => '',
						'account_activation' => '',
						'msgform_text'      => '',
						'user_text'         => '',
						'users_text'        => '',
						'display_edit_links'=> false,
					) );
					// ----------------------------- END OF REQUEST TITLE ----------------------------
				?>

				<?php
				// Go Grab the featured post:
				if( ! in_array( $disp, array( 'single', 'page' ) ) && $Item = & get_featured_Item() )
				{	// We have a featured/intro post to display:
					$intro_item_style = '';
					$LinkOwner = new LinkItem( $Item );
					$LinkList = $LinkOwner->get_attachment_LinkList( 1, 'cover' );
					if( ! empty( $LinkList ) &&
							$Link = & $LinkList->get_next() &&
							$File = & $Link->get_File() &&
							$File->exists() &&
							$File->is_image() )
					{	// Use cover image of intro-post as background:
						$intro_item_style = 'background-image: url("'.$File->get_url().'")';
					}
					// ---------------------- ITEM BLOCK INCLUDED HERE ------------------------
					skin_include( '_item_block.inc.php', array(
							'feature_block' => true,
							'content_mode'  => 'full', // We want regular "full" content, even in category browsing: i-e no excerpt or thumbnail
							'intro_mode'    => 'normal',	// Intro posts will be displayed in normal mode
							'item_class'    => ($Item->is_intro() ? 'well evo_intro_post' : 'well evo_featured_post').( empty( $intro_item_style ) ? '' : ' evo_hasbgimg' ),
							'item_style'    => $intro_item_style,
							'Item'          => $Item,
						) );
					// ----------------------------END ITEM BLOCK  ----------------------------
				}
				?>

				<?php
					if( $Skin->get_setting( 'category_list_filter' ) == 1 ) :
		                skin_widget( array(
		                    // CODE for the widget:
		                    'widget'               => 'coll_category_list',
		                    // Optional display params
							'block_start'         => '<div class="evo_widget $wi_class$ cat_list">',
							'block_end'           => '</div>',
							'block_display_title' => false,
							'level' 			  => 1,
		                ) );
					endif;
				 ?>

				<?php
					// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
					skin_include( '$disp$', array(
						'item_class'	   		=> 'evo_post_article',
						'content_mode'     		=> 'auto',
						'author_link_text' 		=> 'auto',

						// Item content:
						'url_link_position'     => 'top',

						// Activate form
						'activate_form_title'  	=> T_('Account activation'),
						'activate_page_before' 	=> '<div class="evo_panel__activation">',
						'activate_page_after'  	=> '</div>',

						// Search
						'search_input_before'  	=> '<div class="input-group">',
						'search_input_after'   	=> '',
						'search_submit_before' 	=> '<span class="input-group-btn">',
						'search_submit_after'  	=> '</span></div>',
					) );
					// Note: you can customize any of the sub templates included here by
					// copying the matching php file into your skin directory.
					// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
				?>
			</div><!-- #main_content -->

			<?php
				// ------------------------- SIDEBAR INCLUDED HERE --------------------------
				skin_include( '_sidebar.inc.php' );
				// Note: You can customize the sidebar by copying the
				// _sidebar.inc.php file into the current skin folder.
				// ----------------------------- END OF SIDEBAR -----------------------------
			?>

		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- #content -->


<?php
// ---------------------------- SITE FOOTER INCLUDED HERE ----------------------------
// If site footers are enabled, they will be included here:
skin_include( '_body_footer.inc.php' );
// ------------------------------- END OF SITE FOOTER --------------------------------


// ------------------------- HTML FOOTER INCLUDED HERE --------------------------
skin_include( '_html_footer.inc.php' );
// ------------------------------- END OF FOOTER --------------------------------
?>
