<?php
    /**
     * Storefront engine room
     *
     * @package quinn
     */

    function add_wc_support() {
        add_theme_support('woocommerce');
    }
    add_action('after_setup_theme', 'add_wc_support');

    /**
     * Disable the WordPress' admin bar.
     */
    show_admin_bar(false);


    if(!function_exists('fetchFeaturedPosts')){
        function fetchFeaturedPosts(){
            $meta_query  = WC()->query->get_meta_query();
            $tax_query   = WC()->query->get_tax_query();
            $tax_query[] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN',
            );
        
            $args = array(
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page'      => $atts['per_page'],
                'orderby'             => $atts['orderby'],
                'order'               => $atts['order'],
                'meta_query'          => $meta_query,
                'tax_query'           => $tax_query,
            );

            return new WP_Query($args);
        }
    }

    if(!function_exists('WC_Categories')){
        function WC_Categories() {
            $taxonomy     = 'product_cat';
            $orderby      = 'name';  
            $show_count   = 0;      
            $pad_counts   = 0;      
            $hierarchical = 1;      
            $title        = '';  
            $empty        = 0;

            $categories = array();

            $args = array(
                'taxonomy'     => $taxonomy,
                'orderby'      => $orderby,
                'show_count'   => $show_count,
                'pad_counts'   => $pad_counts,
                'hierarchical' => $hierarchical,
                'title_li'     => $title,
                'hide_empty'   => $empty
            );
            $all_categories = get_categories( $args );

            foreach ($all_categories as $cat) {
                if($cat->category_parent == 0) {
                    $category_id = $cat->term_id;
                    if($cat->name !== 'Uncategorized'){
                        $categories[$cat->name] = array();       
                    }

                    $args2 = array(
                    'taxonomy'     => $taxonomy,
                    'child_of'     => 0,
                    'parent'       => $category_id,
                    'orderby'      => $orderby,
                    'show_count'   => $show_count,
                    'pad_counts'   => $pad_counts,
                    'hierarchical' => $hierarchical,
                    'title_li'     => $title,
                    'hide_empty'   => $empty
                    );
                    $sub_cats = get_categories( $args2 );
                    if($sub_cats) {
                        foreach($sub_cats as $sub_category) {
                            array_push($categories[$cat->name], $sub_category->name);
                        }   
                    }
                }       
            }

            return $categories;
        }
    }

    if(!function_exists('get_store_filters')){
        function get_store_filters(){
            $categories = WC_Categories();
            $categoryID = 1;

            // Category Selection
            echo '<ul class="filters">';
            if(count($categories) > 0){
                foreach($categories as $parent => $child){
                    echo '<li class="parent" data-id="' . $categoryID . '">' . $parent . '<i class="fa fa-angle-down"></i></li>';

                    foreach($child as $children){
                        $uri = add_query_arg('category', $children, site_url('/shop'));
                        if(isset($_GET['size'])){
                            $uri = add_query_arg('size', $_GET['size'], $uri);
                        }
                        if(isset($_GET['sort_by'])){
                            $uri = add_query_arg('sort_by', $_GET['sort_by'], $uri);
                        }
                        echo '<a href="' . $uri . '"><li class="child" data-id="' . $categoryID . '" data-filter="category:' . $children . '"><i class="fa fa-angle-right"></i>' . $children . '</li></a>';
                    }

                    $categoryID++;
                }
            } else {
                echo '<li class="no-cats">There are no categories available.</li>';
            }
            echo '</ul>';

            // Size Selection
            $sizes = array('S', 'M', 'L', 'XL');
            echo '<h3>Sizes</h3>';
            echo '<ul class="sizes">';
                foreach($sizes as $index => $size){
                    $uri = add_query_arg('size', $size, site_url('/shop'));
                    if(isset($_GET['category'])){
                        $uri = add_query_arg('category', $_GET['category'], $uri);
                    }
                    if(isset($_GET['sort_by'])){
                        $uri = add_query_arg('sort_by', $_GET['sort_by'], $uri);
                    }

                    if(isset($_GET['size']) && $_GET['size'] == $size){
                        echo '<a href="#"><li class="active">' . $size . '</li></a>';
                    } else {
                        echo '<a href="' . $uri . '"><li>' . $size . '</li></a>';
                    }
                }
            echo '</ul>';
            
        }
    }

    if(!function_exists('get_similar_products')){
        function get_similar_products($category, $thisProduct){
            $similarProducts = array();
            $matchForSimilar = array(
                $category->name
            );

            $products = wc_get_products(array(
                'category' => $matchForSimilar,
            ));

            foreach($products as $product){
                if($product->id !== $thisProduct){
                    array_push($similarProducts, $product->id);
                }
            }


            return $similarProducts;
        }
    }

    if(!function_exists('render_product')){
        function render_product($product, $productType = 'object'){
            if($productType == 'object'){
                $WC_Product = wc_get_product($product->ID);
                if(isset($_GET['category'])){
                    $permalink = add_query_arg('category', $_GET['category'], get_permalink($product->ID));
                } else {
                    $permalink = get_permalink($product->ID);
                }
                $productImage = wp_get_attachment_image_src(get_post_thumbnail_id($product->ID), 'single-post-thumbnail');
                echo '<a href="' . $permalink . '" class="product" data-prod-id="' . $product->ID . '"><div class="product_image"><img src="' . $productImage[0] . '"></div><h2>' . $product->post_title . '</h2><p>£' . $WC_Product->get_price() . '</p></p></a>';
            } else {
                $WC_Product = wc_get_product($product);
                if(isset($_GET['category'])){
                    $permalink = add_query_arg('category', $_GET['category'], get_permalink($WC_Product->id));
                } else {
                    $permalink = get_permalink($WC_Product->id);
                }
                $productImage = wp_get_attachment_image_src(get_post_thumbnail_id($WC_Product->id), 'single-post-thumbnail');
                echo '<a href="' . $permalink . '" class="product" data-prod-id="' . $WC_Product->id . '"><div class="product_image"><img src="' . $productImage[0] . '"></div><h2>' . $WC_Product->name . '</h2><p>£' . $WC_Product->get_price() . '</p></p></a>';
            }
        }
    }

    if(!function_exists('render_product_attrs')){
        function render_product_attrs($product){
            $attributes = get_post_meta($product, '_product_attributes');
            $attributesVar = $attributes[0]['artisan']['value'];
            $attributesSplit = explode(',', $attributesVar);

            foreach($attributesSplit as $attributesCollection){
                $explodeCollection = explode(':', $attributesCollection);
                echo "<li><h1>" . $explodeCollection[0] . "</h1><h2>" . $explodeCollection[1] . "</h2></li>";
            }

        }
    }

    if(!function_exists('render_product_sizes')){
        function render_product_sizes($product){
            $attributes = get_post_meta($product, '_product_attributes');
            $attributesVar = trim($attributes[0]['sizes']['value']);
            $attributesCollection = explode(',', $attributesVar);
            $availableSizes = array('S', 'M', 'L', 'XL');

            foreach($availableSizes as $availableSize){
                if(in_array(trim($availableSize), $attributesCollection)){
                    echo '<li class="available">' . $availableSize . '</li>';
                } else {
                    echo '<li>' . $availableSize . '</li>';
                }
            }
        }
    }
?>