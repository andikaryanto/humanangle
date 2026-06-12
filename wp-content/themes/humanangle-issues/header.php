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
	<div class="header-top">
		<div class="header-top-shell ha-shell">
			<div class="site-brand" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					?>
					<a class="site-brand-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<span class="ha-logo" aria-hidden="true">
							<span class="ha-monogram">HA</span>
							<span class="ha-logo-copy">
								<span class="ha-logo-word">Human Angle</span>
								<span class="ha-logo-tagline">Stories behind the headlines</span>
							</span>
						</span>
					</a>
					<?php
				}
				?>
			</div>
			<div class="header-actions">
				<div class="social-links" aria-label="<?php esc_attr_e( 'Social links', 'humanangle-issues' ); ?>">
					<a class="social-link social-instagram" href="#" aria-label="<?php esc_attr_e( 'Instagram', 'humanangle-issues' ); ?>">&#9678;</a>
					<a class="social-link social-x" href="#" aria-label="<?php esc_attr_e( 'X', 'humanangle-issues' ); ?>">X</a>
					<a class="social-link social-facebook" href="#" aria-label="<?php esc_attr_e( 'Facebook', 'humanangle-issues' ); ?>">f</a>
					<a class="social-link social-tiktok" href="#" aria-label="<?php esc_attr_e( 'TikTok', 'humanangle-issues' ); ?>">&#9834;</a>
					<a class="social-link social-youtube" href="#" aria-label="<?php esc_attr_e( 'YouTube', 'humanangle-issues' ); ?>">&#9654;</a>
				</div>
			</div>
		</div>
	</div>
	<div class="header-nav-shell">
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
