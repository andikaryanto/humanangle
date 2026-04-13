<?php
/**
 * Header template.
 *
 * @package HumanangleIssues
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
	<div class="header-stripe"></div>
	<div class="header-nav-shell ha-shell">
		<div class="header-nav-row">
			<nav class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'humanangle-issues' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_class'     => 'primary-menu',
						'container'      => false,
						'fallback_cb'    => 'humanangle_issues_menu_fallback',
					)
				);
				?>
			</nav>
			<div class="header-search" aria-label="<?php esc_attr_e( 'Site search', 'humanangle-issues' ); ?>">
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</header>
<div class="page-wrap">
