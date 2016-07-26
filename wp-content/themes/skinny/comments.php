<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Skinny
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				printf( // WPCS: XSS OK.
					esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'skinny' ) ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'skinny' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'skinny' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'skinny' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<section id="app" class="comments">
			<?php
			wp_list_comments( array(
			    'walker' => new skinny_comment_walker()
			) );
			?>
		</section>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'skinny' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'skinny' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'skinny' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'skinny' ); ?></p>
	<?php
	endif;
	$args = array(
		'fields' => apply_filters(
			'comment_form_default_fields', array(
				'author' =>'<p class="comment-form-author">' . ( $req ? '<span class="required">*</span>' : '' )  . '<input id="author" placeholder="Your Name" name="author" type="text" value="' .
					esc_attr( $commenter['comment_author'] ) . '" size="30"\ />'.
					
					
					'</p>'
					,
				'email'  => '<p class="comment-form-email">' . ( $req ? '<span class="required">*</span>' : '' )  .'<input id="email" placeholder="your email address" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
					'" size="30" />'  .
					
					
					'</p>',
				'url'    => '<p class="comment-form-url">' .
				 '<input id="url" name="url" placeholder="your website" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /> ' .
				
		           '</p>'
			)
		),
		'comment_field' => '<p class="comment-form-comment">' .
			
			'<textarea id="comment" name="comment" placeholder="Enter your comment..." cols="45" rows="8" aria-required="true"></textarea>' .
			'</p>',
	    'comment_notes_after' => '',
	    
	);
	comment_form($args);
	?>

</div><!-- #comments -->
