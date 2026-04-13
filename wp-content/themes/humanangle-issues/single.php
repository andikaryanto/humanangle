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
		$related_query = new WP_Query(
			array(
				'post_type'           => 'post',
				'posts_per_page'      => 3,
				'post__not_in'        => array( get_the_ID() ),
				'ignore_sticky_posts' => true,
				'category__in'        => wp_list_pluck( get_the_category(), 'term_id' ),
			)
		);
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
					<section class="sidebar-panel">
						<h2 class="sidebar-title"><?php esc_html_e( 'Key Takeaway', 'humanangle-issues' ); ?></h2>
						<p class="archive-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 34 ) ); ?></p>
					</section>
					<?php if ( $related_query->have_posts() ) : ?>
						<section class="sidebar-panel">
							<h2 class="sidebar-title"><?php esc_html_e( 'Related', 'humanangle-issues' ); ?></h2>
							<div class="compact-list">
								<?php
								while ( $related_query->have_posts() ) :
									$related_query->the_post();
									?>
									<article class="compact-item">
										<div class="story-term"><?php echo wp_kses_post( humanangle_issues_post_terms() ); ?></div>
										<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<p class="story-meta">
											<span><?php echo esc_html( get_the_date() ); ?></span>
											<span><?php echo esc_html( humanangle_issues_read_time() ); ?></span>
										</p>
									</article>
								<?php endwhile; ?>
							</div>
						</section>
					<?php endif; ?>
				</aside>
			</div>
		</article>
		<?php
		wp_reset_postdata();
	endwhile;
	?>
</main>
<?php get_footer(); ?>
