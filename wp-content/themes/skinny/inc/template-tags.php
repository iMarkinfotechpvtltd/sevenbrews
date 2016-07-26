<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Skinny
 */

if ( ! function_exists( 'skinny_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function skinny_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'skinny' ),
		$time_string
	);

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}
endif;

function skinny_posted_by() {
	$byline = sprintf(
		esc_html_x( '%s', 'post author', 'skinny' ),
		'<em class="author">' .esc_html_x('By ', '', 'skinny'). '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></em>'
	);
	
	echo '' . $byline . ''; // WPCS: XSS OK.
}


if ( ! function_exists( 'skinny_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function skinny_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'skinny' ) );
		if ( $categories_list && skinny_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'skinny' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'skinny' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'skinny' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'skinny' ), esc_html__( '1 Comment', 'skinny' ), esc_html__( '% Comments', 'skinny' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'skinny' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

function skinny_entry_tags() {
	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '<ul class="tag-clouds"><li>','</li><li>','</li></ul>' );
	if ( $tags_list ) {
		printf( esc_html__( '%1$s', 'skinny' ), $tags_list ); // WPCS: XSS OK.
	}
	
}

function skinny_post_navigation(){
	$navigation = '';
	$previous   = get_previous_post_link( '<div class="nav-previous">%link</div>', '&#8592; %title', true );
	$next       = get_next_post_link( '<div class="nav-next">%link</div>', '%title &#8594;', true );

	// Only add markup if there's somewhere to navigate to.
	if ( $previous || $next ) {
		$navigation = _navigation_markup( $previous . $next, 'post-navigation' );
	}

	echo $navigation;
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function skinny_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'skinny_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'skinny_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so skinny_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so skinny_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in skinny_categorized_blog.
 */
function skinny_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'skinny_categories' );
}
add_action( 'edit_category', 'skinny_category_transient_flusher' );
add_action( 'save_post',     'skinny_category_transient_flusher' );


/*--------------------------*             							
/* Paging Nav					                							
/*--------------------------*/
function skinny_paging_nav() {

	if( is_singular() )
		return;

	global $wp_query;

	/** Stop execution if there's only 1 page */
	if( $wp_query->max_num_pages <= 1 )
		return;

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );

	/**	Add current page to the array */
	if ( $paged >= 1 )
		$links[] = $paged;

	/**	Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<ul class="pagination">' . "\n";

	/**	Previous Post Link */
	if ( get_previous_posts_link() )
		printf( '<li class="prev">%s</li>' . "\n", get_previous_posts_link('<span class="icon-chevron-left"></span>') );

	/**	Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

		if ( ! in_array( 2, $links ) )
			echo '<li>...</li>';
	}

	/**	Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		printf( '<li%s><strong><a href="%s">%s</a></strong></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	/**	Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li>...</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	}

	/**	Next Post Link */
	if ( get_next_posts_link() )
		printf( '<li class="next">%s</li>' . "\n", get_next_posts_link('<span class="icon-chevron-right"></span>') );

	echo '</ul>' . "\n";

}




	class skinny_comment_walker extends Walker_Comment {
		var $tree_type = 'comment';
		var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );
 
		
		function __construct() { ?>

			<section class="comments-list">

		<?php }

		
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>
			
			<section class="child-comments comments-list">

		<?php }
	
		
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>

			</section>

		<?php }

		
		function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
			$depth++;
			$GLOBALS['comment_depth'] = $depth;
			$GLOBALS['comment'] = $comment;
			$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); 
	
			if ( 'article' == $args['style'] ) {
				$tag = 'article';
				$add_below = 'comment';
			} else {
				$tag = 'article';
				$add_below = 'comment';
			} ?>
  <article>
    <?php echo get_avatar( $comment, 65, '[default gravatar URL]', 'Authors gravatar' ); ?>
    <h4><a class="comment-author-link" href="<?php comment_author_url(); ?>"><?php comment_author(); ?></a> &#8212; <span class="time"><?php printf( _x( '%s ago', '%s = human-readable time difference', 'skinny' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?>, <a href="#comment-<?php comment_ID() ?>"></a></span></h4>
    
	<?php edit_comment_link('<p class="comment-meta-item">Edit this comment</p>','',''); ?>
	<?php if ($comment->comment_approved == '0') : ?>
	<p class="comment-meta-item">Your comment is awaiting moderation.</p>
	<?php endif; ?>
   <?php comment_text() ?>
 
					<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			

		<?php }

		
		function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>

			</article>

		<?php }

		
		function __destruct() { ?>

			</section>
		
		<?php }

	}
	