<?php
/**
 * This is the BODY header include template.
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://b2evolution.net/man/skin-development-primer}
 *
 * This is meant to be included in a page template.
 *
 * @package evoskins
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );
// ---------------------------- SITE HEADER INCLUDED HERE ----------------------------
// If site headers are enabled, they will be included here:
siteskin_include( '_site_body_header.inc.php' );
// ------------------------------- END OF SITE HEADER --------------------------------
?>

<header id="nav">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav_tabs" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
        </div>
        <nav id="nav_tabs" class="nav_tabs collapse navbar-collapse">
    		<ul class="main_nav">
    		<?php
    			// ------------------------- "Menu" CONTAINER EMBEDDED HERE --------------------------
    			// Display container and contents:
    			// Note: this container is designed to be a single <ul> list
    			skin_container( NT_('Menu'), array(
    					// The following params will be used as defaults for widgets included in this container:
					'block_start'         => '',
					'block_end'           => '',
					'block_display_title' => false,
					'list_start'          => '',
					'list_end'            => '',
					'item_start'          => '<li class="evo_widget $wi_class$">',
					'item_end'            => '</li>',
					'item_selected_start' => '<li class="active evo_widget $wi_class$">',
					'item_selected_end'   => '</li>',
					'item_title_before'   => '',
					'item_title_after'    => '',
				) );
    			// ----------------------------- END OF "Menu" CONTAINER -----------------------------
    		?>
    		</ul>
        </nav>
        <div class="search_icon">
            <a href="#cd_search" class="search_tringger">
                <span></span>
            </a>
        </div>
        <div id="cd_search">
            <?php
                skin_widget( array(
                    // CODE for the widget:
                    'widget'               => 'coll_search_form',
                    // Optional display params
                    'block_start'          => '<div class="evo_widget $wi_class$ header_search">',
                    'block_end'            => '</div>',
                    'block_display_title'  => false,
                    'search_submit_before' => '<span class="hidden">',
                    'search_submit_after'  => '</span>',
                ) );
            ?>
        </div>
    </div><!-- .container-fluid -->
</header>
<div class="nav_fixed"></div>

<header id="main_header">
    <div class="container">
        <div class="row">
            <div class="coll-xs-12 coll-sm-12 col-md-4 col-md-push-8">
                <div class="evo_container evo_container__page_top">
                <?php
                    // ------------------------- "Page Top" CONTAINER EMBEDDED HERE --------------------------
                    // Display container and contents:
                    skin_container( NT_('Page Top'), array(
                            // The following params will be used as defaults for widgets included in this container:
                            'block_start'         => '<div class="evo_widget $wi_class$">',
                            'block_end'           => '</div>',
                            'block_display_title' => false,
                            'list_start'          => '<ul>',
                            'list_end'            => '</ul>',
                            'item_start'          => '<li>',
                            'item_end'            => '</li>',
                        ) );
                    // ----------------------------- END OF "Page Top" CONTAINER -----------------------------
                ?>
                </div>
            </div><!-- .col -->

            <div class="coll-xs-12 col-sm-12 col-md-8 col-md-pull-4">
                <div class="evo_container evo_container__header">
                <?php
                    // ------------------------- "Header" CONTAINER EMBEDDED HERE --------------------------
                    // Display container and contents:
                    skin_container( NT_('Header'), array(
                            // The following params will be used as defaults for widgets included in this container:
                            'block_start'       => '<div class="evo_widget $wi_class$">',
                            'block_end'         => '</div>',
                            'block_title_start' => '<h1>',
                            'block_title_end'   => '</h1>',
                        ) );
                    // ----------------------------- END OF "Header" CONTAINER -----------------------------
                ?>
                </div>
            </div><!-- .col -->
        </div>
    </div>
</header>
