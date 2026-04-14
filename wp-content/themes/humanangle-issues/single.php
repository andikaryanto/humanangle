<?php
/**
 * Single post template.
 *
 * @package HumanangleIssues
 */

get_header();
?>
<main class="ha-shell">
	<?php
	while ( have_posts() ) :
		the_post();
		$current_post_id = get_the_ID();
		$sidebar_query    = humanangle_issues_recommended_posts( $current_post_id, 4 );
		$more_posts_query = humanangle_issues_recommended_posts( $current_post_id, 4 );
		?>
		<article <?php post_class( 'entry-shell' ); ?>>
			<div class="entry-layout">
				<div>
					<div class="entry-tax"><?php echo wp_kses_post( humanangle_issues_post_terms() ); ?></div>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="entry-meta">
						<span><?php echo esc_html( get_the_date() ); ?></span>
						<span><?php echo esc_html( get_the_author() ); ?></span>
						<span><?php echo esc_html( humanangle_issues_read_time() ); ?></span>
					</div>
					<div class="entry-feature">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'full' );
						}
						?>
					</div>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</div>
				<aside class="sidebar-stack">
					<section class="sidebar-panel sidebar-panel-related">
						<h2 class="sidebar-title sidebar-title-accent"><?php esc_html_e( 'Baca Juga', 'humanangle-issues' ); ?></h2>
						<?php if ( $sidebar_query->have_posts() ) : ?>
							<div class="related-visual-list">
								<?php
								while ( $sidebar_query->have_posts() ) :
									$sidebar_query->the_post();
									?>
									<article class="related-visual-item">
										<a class="related-visual-thumb" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
											<?php
											if ( has_post_thumbnail() ) {
												the_post_thumbnail( 'medium' );
											}
											?>
										</a>
										<div class="related-visual-body">
											<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<p class="related-date"><?php echo esc_html( get_the_date() ); ?></p>
										</div>
									</article>
								<?php endwhile; ?>
							</div>
						<?php else : ?>
							<p class="archive-excerpt"><?php esc_html_e( 'Belum ada artikel lain untuk ditampilkan.', 'humanangle-issues' ); ?></p>
						<?php endif; ?>
					</section>
				</aside>
			</div>
		</article>
		<section class="section-block single-more-posts" aria-label="<?php esc_attr_e( 'More articles', 'humanangle-issues' ); ?>">
			<div class="section-heading">
				<div>
					<div class="section-label"><?php esc_html_e( 'Continue Reading', 'humanangle-issues' ); ?></div>
					<h2 class="section-title"><?php esc_html_e( 'Baca Juga', 'humanangle-issues' ); ?></h2>
				</div>
			</div>
			<?php if ( $more_posts_query->have_posts() ) : ?>
				<div class="story-grid single-more-grid">
					<?php
					while ( $more_posts_query->have_posts() ) :
						$more_posts_query->the_post();
						?>
						<article <?php post_class( 'story-card' ); ?>>
							<div class="story-card-thumb">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'large' );
								}
								?>
							</div>
							<div class="story-card-body">
								<div class="story-term"><?php echo wp_kses_post( humanangle_issues_post_terms() ); ?></div>
								<h3 class="story-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p class="story-summary"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
								<div class="story-meta">
									<span><?php echo esc_html( get_the_date() ); ?></span>
									<span><?php echo esc_html( humanangle_issues_read_time() ); ?></span>
								</div>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
				<div class="no-results">
					<p><?php esc_html_e( 'Belum ada artikel lain untuk dibaca.', 'humanangle-issues' ); ?></p>
				</div>
			<?php endif; ?>
		</section>
		<?php
		wp_reset_postdata();
	endwhile;
	?>
</main>
<?php get_footer(); ?>
