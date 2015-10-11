<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * List products. One widget to rule them all.
 *
 * @author   Roman Gritsay
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.3.0
 * @extends  WC_Widget
 */
class WC_Widget_All_Products extends WC_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_all_products';
		$this->widget_description = __( 'Display a list of your products, grouped by categories on your site.', 'woocommerce' );
		$this->widget_id          = 'woocommerce_all_products';
		$this->widget_name        = __( 'WooCommerce All Products', 'woocommerce' );

		parent::__construct();
	}

	/**
	 * Query the products and return them
	 * @param  array $args
	 * @param  array $instance
	 * @return WP_Query
	 */
	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
	    global $post;
	    
		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();
	
        $args = array(
            'orderby'    => 'title',
            'order'      => 'ASC',
            'hide_empty' => TRUE,
        );
        $product_categories = get_terms( 'product_cat', $args );
        $count = count($product_categories);
        $protocol = $_SERVER['HTTPS'] ? 'https://' : 'http://';
        $current_url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if ($current_url == get_permalink( $post->ID )) {
            $current_product = $post;
        }
        $current_category = null;
        foreach (get_the_terms( $post->ID, 'product_cat' ) as $term) {
            $current_category = $term->term_id;
            break;
        }
        if ( $count > 0 ){
            foreach ( $product_categories as $product_category ) {
                $activeCategory = $product_category->term_id == $current_category ? ' active' : ''; 
                echo '<div class="all-products-category'.$activeCategory.'">';
                    echo '<h4><a href="' . get_term_link( $product_category ) . '">' . $product_category->name . '</a></h4>';
                    $args = array(
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'slug',
                                // 'terms' => 'white-wines'
                                'terms' => $product_category->slug
                            )
                        ),
                        'post_type' => 'product',
                        'orderby' => 'title,'
                    );
                    $products = new WP_Query( $args );
                    echo '<ul class="all-products-list">';
        			while ( $products->have_posts() ) {
        				$products->the_post();
        				if($current_product) {
        				    $activeProduct = $current_product->ID == get_the_ID();
        				}
        				wc_get_template( 'content-widget-product.php', array( 'show_rating' => false, 'active' => $activeProduct ) );
        			}
                    echo "</ul>";
                echo "</div>";
                
            }
        }
        
		wp_reset_postdata();

        echo $this->cache_widget( $args, ob_get_clean() );
    }
}

register_widget( 'WC_Widget_All_Products' );
