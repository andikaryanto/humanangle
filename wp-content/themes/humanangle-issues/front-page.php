<?php
/**
 * Front page template.
 *
 * @package HumanangleIssues
 */

get_header();

$featured_query = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 1,
	)
);

$featured_ids = array();
if ( $featured_query->have_posts() ) {
	$featured_ids = wp_list_pluck( $featured_query->posts, 'ID' );
}

$side_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 4,
		'post__not_in'        => $featured_ids,
		'ignore_sticky_posts' => false,
	)
);

$latest_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 4,
		'post__not_in'        => $featured_ids,
		'ignore_sticky_posts' => false,
	)
);

$recent_sidebar = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 5,
		'post__not_in'        => $featured_ids,
		'ignore_sticky_posts' => true,
	)
);

$section_categories = humanangle_issues_pick_categories( 3 );
$portal_sections    = array(
	array(
		'label' => __( 'Reporting', 'humanangle-issues' ),
		'query' => new WP_Query(
			array(
				'post_type'           => 'post',
				'posts_per_page'      => 3,
				'post__not_in'        => $featured_ids,
				'ignore_sticky_posts' => true,
			)
		),
	),
	array(
		'label' => __( 'Essays', 'humanangle-issues' ),
		'query' => new WP_Query(
			array(
				'post_type'           => 'post',
				'posts_per_page'      => 4,
				'offset'              => 3,
				'post__not_in'        => $featured_ids,
				'ignore_sticky_posts' => true,
			)
		),
	),
	array(
		'label' => __( 'Editorials', 'humanangle-issues' ),
		'query' => new WP_Query(
			array(
				'post_type'           => 'post',
				'posts_per_page'      => 4,
				'offset'              => 7,
				'post__not_in'        => $featured_ids,
				'ignore_sticky_posts' => true,
			)
		),
	),
	array(
		'label' => __( 'Columns', 'humanangle-issues' ),
		'query' => new WP_Query(
			array(
				'post_type'           => 'post',
				'posts_per_page'      => 4,
				'offset'              => 11,
				'post__not_in'        => $featured_ids,
				'ignore_sticky_posts' => true,
			)
		),
	),
);
?>
<main class="ha-shell">
	<section class="billboard-banner" aria-label="<?php esc_attr_e( 'Editorial campaign banner', 'humanangle-issues' ); ?>">
		<div class="billboard-inner">
			<div class="billboard-kicker"><?php esc_html_e( 'Focus This Week', 'humanangle-issues' ); ?></div>
			<div class="billboard-copy">
				<h2><?php esc_html_e( 'Food insecurity, war, and climate disruption are not distant issues. Their impact is already shaping everyday life.', 'humanangle-issues' ); ?></h2>
				<p><?php esc_html_e( 'This banner area can be used for special reporting packages, sponsored placements, or major editorial campaigns with a classic news portal feel.', 'humanangle-issues' ); ?></p>
			</div>
			<div class="billboard-tag"><?php esc_html_e( 'World Social Desk', 'humanangle-issues' ); ?></div>
		</div>
	</section>

	<?php if ( $featured_query->have_posts() ) : ?>
		<section class="hero-grid home-lead-grid">
			<?php
			while ( $featured_query->have_posts() ) :
				$featured_query->the_post();
				$image_url = humanangle_issues_story_image_url();
				?>
				<article <?php post_class( 'hero-story' . ( $image_url ? ' has-thumbnail' : '' ) ); ?><?php echo $image_url ? ' style="background-image: linear-gradient(180deg, rgba(10, 24, 34, 0.08) 0%, rgba(10, 24, 34, 0.72) 72%, rgba(10, 24, 34, 0.92) 100%), url(' . esc_url( $image_url ) . ');"' : ''; ?>>
					<div class="hero-content">
						<div class="story-term"><?php echo wp_kses_post( humanangle_issues_post_terms() ); ?></div>
						<h2 class="hero-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="hero-summary"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 34 ) ); ?></p>
						<div class="meta-row hero-meta">
							<span><?php echo esc_html( get_the_date() ); ?></span>
							<span><?php echo esc_html( humanangle_issues_read_time() ); ?></span>
							<span><?php esc_html_e( 'Lead Story', 'humanangle-issues' ); ?></span>
						</div>
					</div>
				</article>
			<?php endwhile; ?>
			<aside class="hero-side latest-sidebar">
				<section class="sidebar-panel latest-sidebar-panel">
					<h2 class="sidebar-title sidebar-title-accent"><?php esc_html_e( 'Latest', 'humanangle-issues' ); ?></h2>
					<div class="compact-list compact-list-visual">
						<?php
						while ( $side_query->have_posts() ) :
							$side_query->the_post();
							?>
							<article <?php post_class( 'story-card' ); ?>>
								<div class="story-card-thumb">
									<?php
									if ( has_post_thumbnail() ) {
										the_post_thumbnail( 'medium_large' );
									}
									?>
								</div>
								<div class="story-card-body">
									<div class="story-term"><?php echo wp_kses_post( humanangle_issues_post_terms() ); ?></div>
									<h3 class="story-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<p class="story-summary"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 14 ) ); ?></p>
									<div class="story-meta">
										<span><?php echo esc_html( get_the_date() ); ?></span>
										<span><?php echo esc_html( humanangle_issues_read_time() ); ?></span>
									</div>
								</div>
							</article>
						<?php endwhile; ?>
					</div>
				</section>
			</aside>
		</section>
	<?php endif; ?>

	<section class="section-block">
		<div class="section-heading">
			<div>
				<div class="section-label"><?php esc_html_e( 'Global Social Radar', 'humanangle-issues' ); ?></div>
				<h2 class="section-title"><?php esc_html_e( 'Issues shaping ordinary lives across countries and regions', 'humanangle-issues' ); ?></h2>
			</div>
		</div>
		<div class="topic-strip" id="focus-topics">
			<span class="topic-pill"><?php esc_html_e( 'Human Rights', 'humanangle-issues' ); ?></span>
			<span class="topic-pill"><?php esc_html_e( 'Climate', 'humanangle-issues' ); ?></span>
			<span class="topic-pill"><?php esc_html_e( 'Migration', 'humanangle-issues' ); ?></span>
			<span class="topic-pill"><?php esc_html_e( 'Labour', 'humanangle-issues' ); ?></span>
			<span class="topic-pill"><?php esc_html_e( 'Public Health', 'humanangle-issues' ); ?></span>
			<span class="topic-pill"><?php esc_html_e( 'Inequality', 'humanangle-issues' ); ?></span>
		</div>
	</section>

	<section class="section-block news-grid" id="latest-stories">
		<div>
			<div class="section-heading">
				<div>
					<div class="section-label"><?php esc_html_e( 'Latest Coverage', 'humanangle-issues' ); ?></div>
					<h2 class="section-title"><?php esc_html_e( 'Field reporting, analysis, and selected opinion pieces', 'humanangle-issues' ); ?></h2>
				</div>
			</div>
			<div class="story-grid">
				<?php if ( $latest_query->have_posts() ) : ?>
					<?php
					while ( $latest_query->have_posts() ) :
						$latest_query->the_post();
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
								<p class="story-summary"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
								<div class="story-meta">
									<span><?php echo esc_html( get_the_author() ); ?></span>
									<span><?php echo esc_html( humanangle_issues_read_time() ); ?></span>
								</div>
							</div>
						</article>
					<?php endwhile; ?>
				<?php else : ?>
					<div class="no-results">
						<p><?php esc_html_e( 'No articles yet. Publish a few posts to populate this editorial homepage.', 'humanangle-issues' ); ?></p>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<aside class="sidebar-stack">
			<section class="sidebar-panel trending-panel">
				<h2 class="sidebar-title sidebar-title-accent"><?php esc_html_e( 'Trending', 'humanangle-issues' ); ?></h2>
				<div class="compact-list">
					<?php
					while ( $recent_sidebar->have_posts() ) :
						$recent_sidebar->the_post();
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
			<section class="sidebar-panel mission-card" id="newsletter">
				<h2 class="sidebar-title"><?php esc_html_e( 'Editorial Direction', 'humanangle-issues' ); ?></h2>
				<p><?php esc_html_e( 'This theme is built for newsrooms covering poverty, war, migration, discrimination, public health, and the social impact of the climate crisis across borders.', 'humanangle-issues' ); ?></p>
				<a class="action-pill primary" href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>"><?php esc_html_e( 'Write New Story', 'humanangle-issues' ); ?></a>
			</section>
		</aside>
	</section>

	<?php foreach ( $portal_sections as $portal_section ) : ?>
		<section class="section-block portal-section">
			<div class="section-heading">
				<div class="section-chip"><?php echo esc_html( $portal_section['label'] ); ?></div>
			</div>
			<?php if ( $portal_section['query']->have_posts() ) : ?>
				<div class="portal-grid">
					<?php
					$portal_index = 0;
					while ( $portal_section['query']->have_posts() ) :
						$portal_section['query']->the_post();
						$portal_index++;
						?>
						<article <?php post_class( 1 === $portal_index ? 'portal-card portal-card-featured' : 'portal-card' ); ?>>
							<div class="portal-thumb">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 1 === $portal_index ? 'large' : 'medium_large' );
								}
								?>
							</div>
							<div class="portal-body">
								<div class="story-term"><?php echo wp_kses_post( humanangle_issues_post_terms() ); ?></div>
								<h3 class="story-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p class="topic-summary"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 1 === $portal_index ? 26 : 14 ) ); ?></p>
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
					<p><?php esc_html_e( 'No articles available for this section yet.', 'humanangle-issues' ); ?></p>
				</div>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</section>
	<?php endforeach; ?>

	<section class="section-block">
		<div class="section-heading">
			<div>
				<div class="section-label"><?php esc_html_e( 'Topic Highlights', 'humanangle-issues' ); ?></div>
				<h2 class="section-title"><?php esc_html_e( 'Sustained attention on the categories drawing the most coverage', 'humanangle-issues' ); ?></h2>
			</div>
		</div>
		<div class="topic-grid">
			<?php if ( ! empty( $section_categories ) ) : ?>
				<?php foreach ( $section_categories as $category ) : ?>
					<?php
					$topic_query = humanangle_issues_section_query( $category->term_id, $featured_ids, 1 );
					if ( ! $topic_query->have_posts() ) {
						continue;
					}
					while ( $topic_query->have_posts() ) :
						$topic_query->the_post();
						?>
						<article class="topic-panel">
							<div class="topic-thumb">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'large' );
								}
								?>
							</div>
							<div class="story-term"><a href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a></div>
							<h3 class="story-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p class="topic-summary"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
							<div class="story-meta">
								<span><?php echo esc_html( humanangle_issues_read_time() ); ?></span>
								<span><?php echo esc_html( sprintf( _n( '%d story', '%d stories', (int) $category->count, 'humanangle-issues' ), (int) $category->count ) ); ?></span>
							</div>
						</article>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="no-results">
					<p><?php esc_html_e( 'Add categories and posts so this topic highlight area can fill automatically.', 'humanangle-issues' ); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
wp_reset_postdata();
get_footer();
