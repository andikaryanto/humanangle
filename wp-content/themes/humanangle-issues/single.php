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
		$category_ids    = wp_list_pluck( get_the_category(), 'term_id' );
		$related_query = new WP_Query(
			array(
				'post_type'           => 'post',
				'posts_per_page'      => 3,
				'post__not_in'        => array( $current_post_id ),
				'ignore_sticky_posts' => true,
				'category__in'        => $category_ids,
			)
		);
		$more_posts_args = array(
			'post_type'           => 'post',
			'posts_per_page'      => 4,
			'post__not_in'        => array( $current_post_id ),
			'ignore_sticky_posts' => true,
		);

		if ( ! empty( $category_ids ) ) {
			$more_posts_args['category__in'] = $category_ids;
		}

		$more_posts_query = new WP_Query( $more_posts_args );
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
		<?php if ( $more_posts_query->have_posts() ) : ?>
			<section class="section-block single-more-posts" aria-label="<?php esc_attr_e( 'More articles', 'humanangle-issues' ); ?>">
				<div class="section-heading">
					<div>
						<div class="section-label"><?php esc_html_e( 'Continue Reading', 'humanangle-issues' ); ?></div>
						<h2 class="section-title"><?php esc_html_e( 'Artikel Lainnya', 'humanangle-issues' ); ?></h2>
					</div>
				</div>
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
			</section>
		<?php endif; ?>
		<?php
		wp_reset_postdata();
	endwhile;
	?>
</main>
<?php get_footer(); ?>
