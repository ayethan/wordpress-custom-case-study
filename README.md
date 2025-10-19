# Custom Case Study Feature

This guide explains the custom "Case Study" feature, implemented within the `TwentyTwentyFive_Case_Studies` class in `wp-content/themes/twentytwentyfive/functions.php`.

## 1. A New "Case Study" Post Type

We've added a new type of post called "Case Study." This lets you create and manage case studies just like you do with regular posts and pages in WordPress.

```php
// The code that creates the "Case Study" post type.
function register_case_study()
{
	$labels = array(
        'name'                  => _x( 'Case Studies', 'Post Type General Name', 'textdomain' ),
        'singular_name'         => _x( 'Case Study', 'Post Type Singular Name', 'textdomain' ),
        'menu_name'             => __( 'Case Studies', 'textdomain' ),
        'all_items'             => __( 'All Case Studies', 'textdomain' ),
        'add_new_item'          => __( 'Add New Case Study', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'new_item'              => __( 'New Case Study', 'textdomain' ),
        'edit_item'             => __( 'Edit Case Study', 'textdomain' ),
    );
    $args = array(
        'label'                 => __( 'Case Study', 'textdomain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'menu_position'         => 5,
        'has_archive'           => true,
        'publicly_queryable'    => true,
        'show_in_rest'          => true,
        'menu_icon'             => 'dashicons-book-alt',
    );
	register_post_type('case-study', $args);

}
add_action('init', 'register_case_study');
```

## 2. Show Your Latest Case Studies

You can now use the shortcode `[featured_case_studies]` in your pages or posts. This will automatically display a list of your three most recent case studies.

```php
// The code for the [featured_case_studies] shortcode.
function featured_case_studies_shortcode( $atts ) {
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
    $output = '';

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
add_shortcode( 'featured_case_studies', 'featured_case_studies_shortcode' );
```

## 3. "Archived" Title for Old Case Studies

When you look at the archive page for case studies, you'll see "Archived: " before each title. This helps you know you're looking at older case studies.

```php
// The code that adds "Archived: " to the title.
function modify_case_study_title( $title, $id = null ) {
    if ( is_admin() || !$id ) {
        return $title;
    }

    if ( get_post_type( $id ) === 'case-study' ) {

        if ( is_archive() || is_post_type_archive( 'case-study' ) ) {
            $title = 'Archived: ' . $title;
        }
    }

    return $title;
}
add_filter( 'the_title', 'modify_case_study_title', 10, 2 );
```

## 4. How to Change a Plugin's Look

To override a plugin's layout.
First, you identify the template file the plugin uses to render its output.
Then, you copy that file into a specific directory within your active theme, and WordPress will automatically use your theme's version instead of the plugin's default.
For instance, to override a template from a plugin named 'my-plugin' located at `wp-content/plugins/my-plugin/templates/layout.php`, you would copy it to `wp-content/themes/your-theme/my-plugin/layout.php`.
