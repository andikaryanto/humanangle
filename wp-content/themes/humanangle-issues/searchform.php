<?php
/**
 * Search form template.
 *
 * @package HumanangleIssues
 */

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'humanangle-issues' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr__( 'Search...', 'humanangle-issues' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	</label>
	<button type="submit" class="search-submit" aria-label="<?php esc_attr_e( 'Search', 'humanangle-issues' ); ?>">&#128269;</button>
</form>
