<?php
/**
 * This is the template that displays the help screen for a collection
 *
 * This file is not meant to be called directly.
 * It is meant to be called by an include in the main.page.php template.
 * To display the archive directory, you should call a stub AND pass the right parameters
 * For example: /blogs/index.php?disp=help
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/gnu-gpl-license}
 * @copyright (c)2003-2016 by Francois Planque - {@link http://fplanque.com/}
 *
 * @package evoskins
 * @subpackage bootstrap_blog_skin
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );


global $app_version, $disp, $Blog;

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
			<div id="main_content" class="<?php echo $Skin->get_column_class('layout'); ?>">

				<?php
					// ------------------------- MESSAGES GENERATED FROM ACTIONS -------------------------
					messages( array(
						'block_start' => '<div class="action_messages">',
						'block_end'   => '</div>',
					) );
					// --------------------------------- END OF MESSAGES ---------------------------------
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
						'msgform_text'       => T_('Messagesss'),
						'user_text'          => '',
						'users_text'         => '',
					) );
					// ----------------------------- END OF REQUEST TITLE ----------------------------
				?>

				<?php
					// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
					skin_include( '$disp$' );
					// Note: you can customize any of the sub templates included here by
					// copying the matching php file into your skin directory.
					// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
				?>

			</div><!-- .col -->
			<?php
				// ------------------------- SIDEBAR INCLUDED HERE --------------------------
				skin_include( '_sidebar.inc.php' );
				// Note: You can customize the sidebar by copying the
				// _sidebar.inc.php file into the current skin folder.
				// ----------------------------- END OF SIDEBAR -----------------------------
			?>
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- #main_content -->

<?php
// ---------------------------- SITE FOOTER INCLUDED HERE ----------------------------
// If site footers are enabled, they will be included here:
skin_include( '_body_footer.inc.php' );
// ------------------------------- END OF SITE FOOTER --------------------------------


// ------------------------- HTML FOOTER INCLUDED HERE --------------------------
skin_include( '_html_footer.inc.php' );
// ------------------------------- END OF FOOTER --------------------------------
?>
