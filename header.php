<?php 
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style('woocommerce_stylesheet', WP_PLUGIN_URL. '/woocommerce/assets/css/woocommerce.css', false, '1.0', "all");

    // Remove border from header on certain pages.
    if(is_product()){
        $headerClass = "nb";
    }
?>
<html>
<head>
    <?php wp_head(); ?>
    <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri().'/js/store.js'; ?>"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;400;500;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/69ebd03f48.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="sale_info">
        <p>Free shipping for orders above £40</p>
    </div>
    <header class="<?= $headerClass ?>">
        <a class="site_title" href="<?= site_url('/') ?>"><h2 class="siteTitle">Quinn</h2></a>
        <nav>
            <a href="<?= site_url('/shop') ?>">Shop</a>
            <a style="color: rgba(0, 0, 0, 0.4)" href="#">Fabric</a>
            <a style="color: rgba(0, 0, 0, 0.4)" href="#">Journal</a>
            <a style="color: rgba(0, 0, 0, 0.4)" href="#">About</a>
        </nav>
        <div class="quick_nav">
            <?php if(is_user_logged_in()){
                $user = wp_get_current_user();    
            ?>
                <span style="margin-right: 5px">Hi, </span><a href="#"><?= $user->user_login ?></a>
            <?php } else { ?>
                <a href="<?= site_url('/wp-login.php') ?>">Login</a>
            <?php } ?>
            <ul>
                <li><i class="fa fa-search"></i></li>
                <li><i class="fa fa-heart-o"></i></li>
                <li><i class="fa fa-shopping-bag"></i></li>
            </ul>
        </div>
    </header>