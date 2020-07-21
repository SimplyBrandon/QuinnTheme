<?php

    // Get the product.
    $product = wc_get_product(get_the_id());

    // Gather the category to display in the breadcrumb.
    if(!isset($_GET['category'])){
        $categories = get_the_terms(get_the_id(), 'product_cat');
        $category = $categories[1];
    } else {
        $category = get_term_by('slug', $_GET['category'], 'product_cat');
    }

    // Fetch the products gallery and include the product image, if there is one.
    $gallery_ids = $product->get_gallery_image_ids();
    $gallery = array();

    $productImage = array(
        'attachment_id' => get_post_thumbnail_id(get_the_id()),
        'attachment_url' => wp_get_attachment_url(get_post_thumbnail_id(get_the_id()))
    );
    array_push($gallery, $productImage);

    foreach($gallery_ids as $gallery_id){
        $putGallery = array(
            'attachment_id' => $gallery_id,
            'attachment_url' => wp_get_attachment_url($gallery_id)
        );
        array_push($gallery, $putGallery);
    }


    // Enlist the styles!
    wp_enqueue_style('store', get_stylesheet_directory_uri() . '/css/product.css');

    
?>

<?php get_header(); ?>
<?php if(is_product()){ ?>
    <!-- Single Product View -->
    <ul class="product_breadcrumb">
        <li><a href="<?php echo add_query_arg('category', 'Womens', site_url('/shop')); ?>">Womens</a></li>
        <li><a href="<?php echo add_query_arg('category', $category->name, site_url('/shop')); ?>"><?= $category->name ?></a></li>
        <li><?= $product->name ?></li>
    </ul>
    <div class="product_container">
        <div class="product_image">
            <div class="image_selection">
                <?php 
                    foreach($gallery as $index => $gallery_img){ 
                        if($index == 0){ $imageClass = "active"; } else { $imageClass = ''; } ?>
                        <div class="image <?= $imageClass ?>" style="background-image: url('<?= $gallery_img['attachment_url'] ?>')"></div>
                <?php } ?>
            </div>
            <div class="big_view">
                <img class="big_view" src="<?= $gallery[0]['attachment_url'] ?>">
                <div class="share_product">
                    <p>Share this product</p> <a href="#"><i class="fab fa-facebook"></i></a> <a href="#"><i class="fab fa-linkedin"></i></a> <a href="#"><i class="fa fa-envelope"></i></a> <a href="#"><i class="fa fa-link"></i></a>
                </div>
            </div>
        </div>
        <div class="product_content">
            <div class="product_header">
                <h2><?= get_the_title() ?></h2>
                <div class="price_and_rating">
                    <p>GBP <?= $product->get_price(); ?></p>
                    <ul class="rating">
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <p style="font-size: 1em">4.8 of 5</p>
                    </ul>
                </div>
            </div>
            <div class="product_description">
                <h2>Description</h2>
                <p><?= $product->get_short_description() ?></p>
                <a href="#">See More</a>
            </div>
            <ul class="product_attributes">
                <?= render_product_attrs($product->id) ?>
            </ul>
            <div class="product_sizes">
                <h2>Size</h2>
                <div class="sizings">
                    <ul>
                        <?= render_product_sizes($product->id) ?>
                    </ul>
                    <a href="#">Size Guidelines</a>
                </div>
                <p>Model is a US Size 2-4, wears Quinn Size 1, 175cm tall.</p>
            </div>
            <div class="product_footer">
                <h2>Quantity</h2>
                <div class="footer_options">
                    <div class="quantity">
                        <span class="less_quantity"><i class="fa fa-minus"></i></span>
                        <input type="number" min="1" step="1" value="1">
                        <span class="more_quantity"><i class="fa fa-plus"></i></span>
                    </div>
                    <button type="button" id="add-to-cart">Add To Cart</button>
                    <button type="button" id="add-to-wishlist">Add To Wishlist</button>
                </div>
            </div>
            <div class="product_features">
                <div class="collapse_header">
                    <h2>Features</h2>
                    <i class="fa fa-minus"></i>
                </div>
                <ul>
                    <li>Gently curved waistband</li>
                    <li>Long self fabric waist belt</li>
                    <li>Seamless side profile</li>
                    <li>Back welt pocket with button</li>
                </ul>
            </div>
            <div class="product_fabric">
                <div class="collapse_header">
                    <h2>Fabric Care</h2>
                    <i class="fa fa-minus"></i>
                </div>
                <h3>Fabric Notes</h3>
                <p>Hand block printed with azo-free dyes. 90% Cotton, 10% Linen.</p>
                <h3>Care Instructions</h3>
                <p>Keep this garment separate in the first few washes to prevent colour runs. When washed garment runs clear, you can throw it into the machine with other like-coloured clothing. Always use delicate machine wash with cold water, or handwash cold for best results. Do not tumble dry. Line dry inside out. Iron inside out using a moderate temperature.</p>
            </div>
        </div>
    </div>
    <div class="external_content">
        <div class="img_parallax"></div>
        <div class="typography">
            <p>I have tasted grilled meats around the world. Before I will guide you to the various technologies (gas barbecues, charcoal barbecues, Mongolian, sauces, recipes) I will tell you about the Greek.</p>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        </div>
        <div class="external_gallery">
            <div class="gallery_image">
                <img src="<?php echo get_stylesheet_directory_uri() . '/image/external_gallery_1.jpg'; ?>"/>
                <p>Lorem Ipsum</p>
            </div>
            <div class="gallery_image">
                <img src="<?php echo get_stylesheet_directory_uri() . '/image/external_gallery_2.jpg'; ?>"/>
                <p>Dolor Sit</p>
            </div>
            <div class="gallery_image">
                <img src="<?php echo get_stylesheet_directory_uri() . '/image/external_gallery_3.jpg'; ?>"/>
                <p>Amet Consecatur</p>
            </div>
        </div>
        <div class="jumbo_text">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos.</p>
        </div>
        <div class="as_seen_on">
            <h2>As Seen On Instagram</h2>
            <div class="instagram_gallery">
                <img src="<?php echo get_stylesheet_directory_uri() . '/image/external_gallery_1.jpg'; ?>"/>
                <img src="<?php echo get_stylesheet_directory_uri() . '/image/external_gallery_2.jpg'; ?>"/>
                <img src="<?php echo get_stylesheet_directory_uri() . '/image/external_gallery_3.jpg'; ?>"/>
                <img src="<?php echo get_stylesheet_directory_uri() . '/image/external_gallery_1.jpg'; ?>"/>
            </div>
        </div>
        <div class="customer_reviews">
            <h2>Customer Reviews</h2>
            <div class="review_header">
                <ul class="rating">
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <p>4.8 of 5</p>
                </ul>
                <div class="review_this">
                    <p>Share your thoughts with other customers</p>
                    <button type="button" id="add-new-review">Write A Review</button>
                </div>
            </div>
            <h1>Top Customer Reviews</h1>
            <div class="reviews">
                <div class="review">
                    <ul class="rating">
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <p>4.8 of 5</p>
                    </ul>
                    <span>By <a href="#">Customer Name</a> on February 19, 2017</span>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>
                </div>
                <div class="review">
                    <ul class="rating">
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <p>4.8 of 5</p>
                    </ul>
                    <span>By <a href="#">Customer Name</a> on February 19, 2017</span>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>
                </div>
                <div class="review">
                    <ul class="rating">
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <p>4.8 of 5</p>
                    </ul>
                    <span>By <a href="#">Customer Name</a> on February 19, 2017</span>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>
                </div>
                <span id="more-reviews">Show more reviews</span>
            </div>
        </div>
        <div class="similar_products">
            <h2 class="section_title">You May Also Like</h2>
            <div class="product_list">
                <?php 
                    $similarProducts = array_slice(get_similar_products($category, $product->id), 0, 4);

                    foreach($similarProducts as $similarProduct){
                        render_product($similarProduct, 'id');
                    }
                ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php get_footer(); ?>