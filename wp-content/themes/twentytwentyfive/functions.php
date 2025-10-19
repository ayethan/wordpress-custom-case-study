<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( 'assets/css/editor-style.css' );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;

// Class TwentyTwentyFive_Case_Studies
class TwentyTwentyFive_Case_Studies {

	private $post_type = 'case-study';

	private $text_domain;

	public function __construct() {
		$this->text_domain = wp_get_theme()->get( 'TextDomain' );
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_shortcode( 'featured_case_studies', array( $this, 'featured_case_studies_shortcode' ) );
		add_filter( 'the_title', array( $this, 'modify_title' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
	}

	// Registers the "Case Study" custom post type.
	public function register_post_type() {
		$labels = array(
			'name'          => _x( 'Case Studies', 'Post Type General Name', $this->text_domain ),
			'singular_name' => _x( 'Case Study', 'Post Type Singular Name', $this->text_domain ),
			'menu_name'     => __( 'Case Studies', $this->text_domain ),
			'all_items'     => __( 'All Case Studies', $this->text_domain ),
			'add_new_item'  => __( 'Add New Case Study', $this->text_domain ),
			'add_new'       => __( 'Add New', $this->text_domain ),
			'new_item'      => __( 'New Case Study', $this->text_domain ),
			'edit_item'     => __( 'Edit Case Study', $this->text_domain ),
		);
		$args   = array(
			'label'              => __( 'Case Study', $this->text_domain ),
			'labels'             => $labels,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'hierarchical'       => false,
			'public'             => true,
			'show_ui'            => true,
			'menu_position'      => 5,
			'has_archive'        => true,
			'publicly_queryable' => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-book-alt',
		);
		register_post_type( $this->post_type, $args );
	}

	// Renders the shortcode.
	public function featured_case_studies_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'posts_per_page' => 3,
			),
			$atts,
			'featured_case_studies'
		);

		$args = array(
			'post_type'      => $this->post_type,
			'posts_per_page' => absint( $atts['posts_per_page'] ),
			'post_status'    => 'publish',
			'order'          => 'DESC',
			'orderby'        => 'date',
			'no_found_rows'  => true,
		);

		$case_studies_query = new WP_Query( $args );
		$output             = '';

		if ( $case_studies_query->have_posts() ) {
			$output .= '<div class="featured-case-studies-list">';
			while ( $case_studies_query->have_posts() ) {
				$case_studies_query->the_post();

				$output .= sprintf(
					'<article id="post-%1$d" class="case-study-item"><h2><a href="%2$s">%3$s</a></h2>%4$s<div class="entry-excerpt">%5$s</div></article>',
					get_the_ID(),
					esc_url( get_permalink() ),
					esc_html( get_the_title() ),
					has_post_thumbnail() ? get_the_post_thumbnail( get_the_ID(), 'medium' ) : '',
					get_the_excerpt()
				);
			}
			$output .= '</div>';
			wp_reset_postdata();
		} else {
			$output .= '<p>' . esc_html__( 'No featured Case Studies found.', $this->text_domain ) . '</p>';
		}

		return $output;
	}

	public function modify_title( $title, $id = null ) {
		if ( ! is_admin() && $id && get_post_type( $id ) === $this->post_type && ( is_archive() || is_post_type_archive( $this->post_type ) ) ) {
			return 'Archived: ' . $title;
		}

		return $title;
	}

	// admin stylesheet.
	public function enqueue_admin_styles() {
		wp_enqueue_style(
			'twentytwentyfive-admin-style',
			get_template_directory_uri() . '/assets/css/admin-style.css',
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
}

new TwentyTwentyFive_Case_Studies();


