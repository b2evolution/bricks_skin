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

// This is the main template; it may be used to display very different things.
// Do inits depending on current $disp:
skin_init( $disp );


// -------------------------- HTML HEADER INCLUDED HERE --------------------------
skin_include( '_html_header.inc.php', array() );
// -------------------------------- END OF HEADER --------------------------------


// ---------------------------- SITE HEADER INCLUDED HERE ----------------------------
// If site headers are enabled, they will be included here:
skin_include( '_body_header.inc.php' );
// ------------------------------- END OF SITE HEADER --------------------------------
?>
<div id="content">
	<div class="container">
		<div class="row">

			<div id="main_content" class="col-md-12">
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
						'title_before'       => '<h2 class="evo_title_disp">',
						'title_after'        => '</h2>',
						'title_none'         => '',
						'glue'               => ' - ',
						'title_single_disp'  => false,
						'title_page_disp'    => false,
						'format'             => 'htmlbody',
						'display_edit_links' => false,
						'category_text'      => '',
						'categories_text'    => '',
						'catdir_text'        => '',
						'comments_text'      => T_('Latest Replies'),
						'front_text'         => '',
						'posts_text'         => '',
						'useritems_text'     => T_('User\'s topics'),
						'usercomments_text'  => T_('User\'s replies'),
						'register_text'      => '',
						'login_text'         => '',
						'lostpassword_text'  => '',
						'account_activation' => '',
						'msgform_text'       => T_('Contact').' <span>'.T_('Us').'</span>',
						'user_text'          => '',
						'users_text'         => '',
					) );
					// ----------------------------- END OF REQUEST TITLE ----------------------------
				?>

				<?php
					// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
					skin_include( '$disp$', array(
						'author_link_text' 		  => 'auto',

						// Pagination
						'pagination' => array(
							'block_start'           => '<div class="center"><ul class="pagination">',
							'block_end'             => '</ul></div>',
							'page_current_template' => '<span>$page_num$</span>',
							'page_item_before'      => '<li>',
							'page_item_after'       => '</li>',
							'page_item_current_before' => '<li class="active">',
							'page_item_current_after'  => '</li>',
							'prev_text'             => '<i class="fa fa-angle-double-left"></i>',
							'next_text'             => '<i class="fa fa-angle-double-right"></i>',
						),
						// Item content:
						'url_link_position'     => 'top',

						// Form params for the forms below: login, register, lostpassword, activateinfo and msgform
						'skin_form_before'      => '<div class="panel panel-default skin-form">'
													.'<div class="panel-heading">'
														.'<h3 class="panel-title">$form_title$</h3>'
													.'</div>'
													.'<div class="panel-body">',
						'skin_form_after'       => '</div></div>',

						// Search
						'search_input_before'  	=> '<div class="input-group">',
						'search_input_after'   	=> '',
						'search_submit_before' 	=> '<span class="input-group-btn">',
						'search_submit_after'  	=> '</span></div>',

						// Form "Sending a message"
						'msgform_form_title' 	=> T_('Contact').' <span>'.T_('Us').'</span>',
					) );
					// Note: you can customize any of the sub templates included here by
					// copying the matching php file into your skin directory.
					// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
				?>
			</div><!-- #main_content -->
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
