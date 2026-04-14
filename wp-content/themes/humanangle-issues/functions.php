<?php
/**
 * Theme functions for Humanangle Issues.
 *
 * @package HumanangleIssues
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function humanangle_issues_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'humanangle-issues' ),
			'footer'  => __( 'Footer Menu', 'humanangle-issues' ),
		)
	);
}
add_action( 'after_setup_theme', 'humanangle_issues_setup' );

function humanangle_issues_enqueue_assets() {
	wp_enqueue_style( 'humanangle-issues-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'humanangle_issues_enqueue_assets' );

function humanangle_issues_menu_fallback() {
	$categories = get_categories(
		array(
			'orderby'    => 'count',
			'order'      => 'DESC',
			'number'     => 10,
			'hide_empty' => true,
		)
	);

	echo '<ul class="primary-menu">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	if ( ! empty( $categories ) ) {
		foreach ( $categories as $category ) {
			printf(
				'<li><a href="%1$s">%2$s</a></li>',
				esc_url( get_category_link( $category ) ),
				esc_html( $category->name )
			);
		}
	} else {
		wp_list_pages(
			array(
				'title_li' => '',
				'depth'    => 1,
			)
		);
	}

	echo '</ul>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

function humanangle_issues_read_time( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$content = wp_strip_all_tags( get_post_field( 'post_content', $post_id ) );
	$words   = str_word_count( $content );
	$minutes = max( 1, (int) ceil( $words / 220 ) );

	return sprintf(
		/* translators: %d: minutes to read */
		_n( '%d min read', '%d min read', $minutes, 'humanangle-issues' ),
		$minutes
	);
}

function humanangle_issues_pick_categories( $limit = 3 ) {
	return get_categories(
		array(
			'orderby'    => 'count',
			'order'      => 'DESC',
			'number'     => $limit,
			'hide_empty' => true,
		)
	);
}

function humanangle_issues_post_terms( $post_id = 0 ) {
	$post_id    = $post_id ? $post_id : get_the_ID();
	$categories = get_the_category( $post_id );

	if ( empty( $categories ) ) {
		return '';
	}

	$output = array();
	foreach ( array_slice( $categories, 0, 2 ) as $category ) {
		$output[] = sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( get_category_link( $category ) ),
			esc_html( $category->name )
		);
	}

	return implode( '', $output );
}

function humanangle_issues_story_image_url( $post_id = 0, $size = 'large' ) {
	$post_id = $post_id ? $post_id : get_the_ID();

	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail_url( $post_id, $size );
	}

	return '';
}

function humanangle_issues_section_query( $category_id, $exclude = array(), $posts_per_page = 1 ) {
	return new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => $posts_per_page,
			'post__not_in'        => $exclude,
			'ignore_sticky_posts' => true,
			'cat'                 => (int) $category_id,
		)
	);
}

function humanangle_issues_recommended_posts( $post_id, $limit = 4 ) {
	$post_id      = (int) $post_id;
	$limit        = max( 1, (int) $limit );
	$category_ids = wp_list_pluck( get_the_category( $post_id ), 'term_id' );
	$post_ids     = array();

	if ( ! empty( $category_ids ) ) {
		$same_category = get_posts(
			array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'numberposts'         => $limit,
				'post__not_in'        => array( $post_id ),
				'ignore_sticky_posts' => true,
				'category__in'        => $category_ids,
				'fields'              => 'ids',
			)
		);

		$post_ids = array_map( 'intval', $same_category );
	}

	if ( count( $post_ids ) < $limit ) {
		$fallback = get_posts(
			array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'numberposts'         => $limit - count( $post_ids ),
				'post__not_in'        => array_merge( array( $post_id ), $post_ids ),
				'ignore_sticky_posts' => true,
				'fields'              => 'ids',
			)
		);

		$post_ids = array_merge( $post_ids, array_map( 'intval', $fallback ) );
	}

	if ( empty( $post_ids ) ) {
		return new WP_Query(
			array(
				'post_type'      => 'post',
				'post__in'       => array( 0 ),
				'posts_per_page' => 0,
			)
		);
	}

	return new WP_Query(
		array(
			'post_type'           => 'post',
			'post__in'            => $post_ids,
			'orderby'             => 'post__in',
			'posts_per_page'      => count( $post_ids ),
			'ignore_sticky_posts' => true,
		)
	);
}
