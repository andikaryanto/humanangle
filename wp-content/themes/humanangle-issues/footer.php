<?php
/**
 * Footer template.
 *
 * @package HumanangleIssues
 */

?>
</div>
<footer class="site-footer">
	<div class="ha-shell footer-grid">
		<div>
			<h2 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Humanangle World Issues</a></h2>
			<p class="footer-note"><?php esc_html_e( 'Reporting, analysis, and public voices for understanding global social issues with human-centred context.', 'humanangle-issues' ); ?></p>
		</div>
		<nav aria-label="<?php esc_attr_e( 'Footer menu', 'humanangle-issues' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'menu_class'     => 'footer-menu',
					'container'      => false,
					'fallback_cb'    => 'humanangle_issues_menu_fallback',
				)
			);
			?>
		</nav>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
