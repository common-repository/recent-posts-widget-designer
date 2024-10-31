<?php
/**
 * Widget API: Recent Post Widget
 *
 * @package recent-posts-widget-designer
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function rpwd_recent_posts_widget() {
    register_widget( 'Rpwd_Recent_Posts_Widget' );
}

// Action to register widget
add_action( 'widgets_init', 'rpwd_recent_posts_widget' );

/**
 * Recent posts class.
 */
class Rpwd_Recent_Posts_Widget extends WP_Widget {
	
	/**
	 * Default widget options.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Widget setup.
	 */
	public function __construct() {

		$widget_ops = array('classname' => 'rpwd-recent-post-widget', 'description' => __('Displayed recent Post items with multiple layouts and designs.', 'recent-posts-widget-designer') );
        parent::__construct( 'rpwd_rpw', __('Designer - Recent Post Widget', 'recent-posts-widget-designer'), $widget_ops );

		$this->defaults = array(
			'title'    				 => __( 'Recent Posts', 'recent-posts-widget-designer' ),
			'category'  			 => 0,
			'number'    			 => 5,
			'show_date' 			 => true,
			'show_cate' 			 => false,
			'show_excerpt' 			 => false,
			'show_author' 			 => false,
			'order'       			 => 'DESC',
			'order_by'    			 => 'date',
			'design'      			 => 'design-1', 
			
		);
	}

	/**
	 * Update the widget settings.
	 *
	 * @param array $new_instance New widget instance.
	 * @param array $old_instance Old widget instance.
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']  			= sanitize_text_field( $new_instance['title'] );
		$instance['category']   		= $new_instance['category'];		
		$instance['number'] 			= absint( $new_instance['number'] );
		$instance['show_date']			= !empty($new_instance['show_date']) ? 1 : 0;
        $instance['show_cate']			= !empty($new_instance['show_cate']) ? 1 : 0;
		$instance['show_author']		= !empty($new_instance['show_author']) ? 1 : 0;
        $instance['show_excerpt']		= !empty($new_instance['show_excerpt']) ? 1 : 0;
		$instance['order']  			= sanitize_text_field( $new_instance['order'] );
		$instance['order_by']  			= sanitize_text_field( $new_instance['order_by'] );
		$instance['design']   			= $new_instance['design'];		

		return $instance;
	}

	/**
	 * Widget form.
	 *
	 * @param array $instance Widget instance.
	 *
	 * @return void
	 */
	public function form( $instance ) {

		$instance = wp_parse_args( $instance, $this->defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title', 'recent-posts-widget-designer' ); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo rpwd_esc_attr( $instance['title'] ); ?>" />
		</p>

		 <!-- Category -->
        <p>
            <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category', 'recent-posts-widget-designer' ); ?>:</label>
            <?php
                $dropdown_args = array(
                                    'taxonomy'          => 'category',
                                    'class'             => 'widefat',
                                    'show_option_all'   => __( 'All', 'recent-posts-widget-designer' ),
                                    'id'                => $this->get_field_id( 'category' ),
                                    'name'              => $this->get_field_name( 'category' ),
                                    'selected'          => $instance['category']
                                );
                wp_dropdown_categories( $dropdown_args );
            ?>
        </p>

        <p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts to show', 'recent-posts-widget-designer' ); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo absint( $instance['number'] ); ?>" size="3" />
		</p>

        <p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php esc_html_e( 'Order', 'recent-posts-widget-designer' ); ?></label>
			<select class="widefat"  id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
				<option value="DESC" <?php selected( $instance['order'], 'DESC' ); ?> ><?php esc_html_e( 'Descending', 'recent-posts-widget-designer' ); ?></option>
				<option value="ASC" <?php selected( $instance['order'], 'ASC' ); ?> ><?php esc_html_e( 'Ascending', 'recent-posts-widget-designer' ); ?></option>
			</select>	
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'order_by' ); ?>"><?php esc_html_e( 'Order By', 'recent-posts-widget-designer' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'order_by' ); ?>" name="<?php echo $this->get_field_name( 'order_by' ); ?>">
				<option value="ID" <?php selected( $instance['order_by'], 'ID' ); ?> ><?php esc_html_e( 'Post ID', 'recent-posts-widget-designer' ); ?></option>
				<option value="author" <?php selected( $instance['order_by'], 'author' ); ?> ><?php esc_html_e( 'Author', 'recent-posts-widget-designer' ); ?></option>
				<option value="title" <?php selected( $instance['order_by'], 'title' ); ?> ><?php esc_html_e( 'Title', 'recent-posts-widget-designer' ); ?></option>
				<option value="date" <?php selected( $instance['order_by'], 'date' ); ?> ><?php esc_html_e( 'Date', 'recent-posts-widget-designer' ); ?></option>
				<option value="rand" <?php selected( $instance['order_by'], 'rand' ); ?> ><?php esc_html_e( 'Rand', 'recent-posts-widget-designer' ); ?></option>
			</select>
			
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'design' ); ?>"><?php esc_html_e( 'Select Design', 'recent-posts-widget-designer' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'design' ); ?>" name="<?php echo $this->get_field_name( 'design' ); ?>">
				<option value="design-1" <?php selected( $instance['design'], 'design-1' ); ?> ><?php esc_html_e( 'Design-1', 'recent-posts-widget-designer' ); ?></option>
				<option value="design-2" <?php selected( $instance['design'], 'design-2' ); ?> ><?php esc_html_e( 'Design-2', 'recent-posts-widget-designer' ); ?></option>
				<option value="design-3" <?php selected( $instance['design'], 'design-3' ); ?> ><?php esc_html_e( 'Design-3', 'recent-posts-widget-designer' ); ?></option>
			</select>	
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_cate'] ); ?> id="<?php echo $this->get_field_id( 'show_cate' ); ?>" name="<?php echo $this->get_field_name( 'show_cate' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_cate' ); ?>"><?php esc_html_e( 'Display Post Category?', 'recent-posts-widget-designer' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_date'] ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php esc_html_e( 'Display Post Date?', 'recent-posts-widget-designer' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_author'] ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_author' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php esc_html_e( 'Display Post Author?', 'recent-posts-widget-designer' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_excerpt'] ); ?> id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php esc_html_e( 'Display Excerpt?', 'recent-posts-widget-designer' ); ?></label>
		</p>

<?php
	}

	/**
	 * How to display the widget on the screen.
	 *
	 * @param array $args     Widget parameters.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		extract($args, EXTR_SKIP);

        $title              = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : __( 'Recent Posts', 'recent-posts-widget-designer' ), $instance, $this->id_base );
        $category           = $instance['category'];
        $num_items          = $instance['number'];
        $show_date          = $instance['show_date'];
        $show_category      = $instance['show_cate'];
		$order      		= $instance['order'];
		$order_by      		= $instance['order_by'];
		$design      		= $instance['design'];
		$show_excerpt      	= $instance['show_excerpt'];
		$show_author      	= $instance['show_author'];

		// Taking some globals
        global $post;


        $post_args = array(
			'posts_per_page'      	=> $num_items,
			'post_type'             => 'post',
			'post_status'           => array( 'publish' ),
			'orderby'				=> $order_by,
			'order'                 => $order,
			'ignore_sticky_posts' 	=> true,
		);

		// Category Parameter
        if( !empty($category) ) {
            $post_args['tax_query'] = array(
                                        array(
                                            'taxonomy'  => 'category',
                                            'field'     => 'term_id',
                                            'terms'     => $category
                                    ));
        }

		$query = new WP_Query($post_args);

		if ( ! $query->have_posts() ) {
			return;
		}

		// Start Widget Output
        echo $before_widget;

		if ( $title ) {
            echo $before_title . $title . $after_title;
        }
		$i = 1;
?>
		<div class="rpwd-recent-post-main rpwd-<?php echo $design; ?>">
			<?php while ( $query->have_posts() ) : $query->the_post();
				 $terms = get_the_terms( $post->ID, 'category' );
				$cat_links = array();
                if($terms) {
                    foreach ( $terms as $term ) {
                        $term_link = get_term_link( $term );
                        $cat_links[] = '<a href="' . esc_url( $term_link ) . '">'.$term->name.'</a>';
                    }
                }
                $cate_name = join( ", ", $cat_links );
            ?>
				<div class="rpwd-recent-post rpwd-recent-post-<?php echo $i; ?>">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="rpwd-recent-post__image">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
								<?php if ($design == 'design-1') { 
									the_post_thumbnail( 'thumbnail' );
								 } else if ($design == 'design-2') { 
									 the_post_thumbnail( 'medium' );
								 } else if ($design == 'design-3' && $i == 1) {	
								  the_post_thumbnail( 'medium' ); 
								 } else { 
								 the_post_thumbnail( 'thumbnail' );
								 }?>
							</a>
						</div>
					<?php endif; ?>
					<div class="rpwd-recent-post__text">
						<?php if ( $show_category ) : ?>
							 <div class="rpwd-post-categories"> <?php echo $cate_name; ?></div>
						<?php endif; ?>
						<h4 class="rpwd-recent-post__title">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h4>
						<?php if ( $show_date ) : ?>
							<span class="rpwd-post-date"> <?php echo get_the_date(); ?></span> 	<?php if ( $show_date && $show_author) { ?> - <?php } ?>
						<?php endif; ?>
						<?php if ( $show_author ) : ?>
							<span class="rpwd-post-date"> <?php echo get_the_author(); ?></span>
						<?php endif; ?>
						<?php if($show_excerpt) {  ?>
						<p class="rpwd-recent-excerpt"><?php the_excerpt(); ?></p>
						<?php } ?>
					</div>
				</div>
			<?php $i++;
			endwhile; ?>
		</div>
<?php
		wp_reset_postdata(); // Reset WP Query

        echo $after_widget;
	}
}