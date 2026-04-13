<?php
/**
 * Main index template.
 *
 * @package HumanangleIssues
 */

get_header();
?>
<main class="ha-shell">
	<section class="section-block">
		<div class="section-heading">
			<div>
				<div class="section-label"><?php esc_html_e( 'Editorial Archive', 'humanangle-issues' ); ?></div>
				<h1 class="section-title"><?php echo is_home() ? esc_html__( 'Latest Coverage', 'humanangle-issues' ) : esc_html__( 'All Stories', 'humanangle-issues' ); ?></h1>
			</div>
		</div>
		<?php if ( have_posts() ) : ?>
			<div class="archive-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'archive-card' ); ?>>
						<div class="archive-thumb">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'large' );
							}
							?>
						</div>
						<div class="archive-card-body">
							<div class="story-term"><?php echo wp_kses_post( humanangle_issues_post_terms() ); ?></div>
							<h2 class="story-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p class="archive-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
							<div class="story-meta">
								<span><?php echo esc_html( get_the_date() ); ?></span>
								<span><?php echo esc_html( humanangle_issues_read_time() ); ?></span>
							</div>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<div class="pagination">
				<?php the_posts_pagination(); ?>
			</div>
		<?php else : ?>
			<div class="no-results">
				<p><?php esc_html_e( 'No content is available to display yet.', 'humanangle-issues' ); ?></p>
			</div>
		<?php endif; ?>
	</section>
</main>
<?php get_footer(); ?>
