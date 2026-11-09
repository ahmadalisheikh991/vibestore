<?php
/**
 * Vibe Store Custom Theme Functions and Definitions
 *
 * @package VibeStore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'VIBESTORE_VERSION', (string) filemtime( get_template_directory() . '/css/style.css' ) . '.' . (string) filemtime( get_template_directory() . '/js/script.js' ) . '.' . (string) filemtime( get_template_directory() . '/js/cart.js' ) );
define( 'VIBESTORE_DIR', get_template_directory() );
define( 'VIBESTORE_URI', get_template_directory_uri() );

/**
 * 1. Theme Setup
 */
function vibestore_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
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
	add_theme_support( 'custom-logo' );
	add_theme_support( 'woocommerce' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'vibestore' ),
			'footer'  => __( 'Footer Navigation', 'vibestore' ),
		)
	);
}
add_action( 'after_setup_theme', 'vibestore_setup' );

/**
 * 2. Helper Functions for Theme Assets and Page URLs
 */
function vibestore_asset( $relative_path ) {
	if ( empty( $relative_path ) ) {
		return '';
	}
	if ( 0 === strpos( $relative_path, 'http://' ) || 0 === strpos( $relative_path, 'https://' ) || 0 === strpos( $relative_path, '/' ) ) {
		return esc_url( $relative_path );
	}
	return esc_url( VIBESTORE_URI . '/' . ltrim( $relative_path, '/' ) );
}

function vibestore_page_url( $slug = '', $extra = '' ) {
	if ( empty( $slug ) || 'index' === $slug || 'home' === $slug ) {
		$base = home_url( '/' );
	} else {
		$page = get_page_by_path( $slug );
		if ( $page ) {
			$base = get_permalink( $page->ID );
		} else {
			$base = home_url( '/' . trim( $slug, '/' ) . '/' );
		}
	}

	if ( ! empty( $extra ) ) {
		if ( 0 === strpos( $extra, '?' ) ) {
			$sep  = ( false !== strpos( $base, '?' ) ) ? '&' : '?';
			$base = $base . $sep . ltrim( $extra, '?' );
		} elseif ( 0 === strpos( $extra, '#' ) ) {
			$base = $base . $extra;
		} else {
			$base = $base . $extra;
		}
	}

	return esc_url( $base );
}

/**
 * Detect current active route slug
 */
function vibestore_current_route() {
	if ( is_front_page() || is_home() ) {
		$req       = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
		$path      = trim( (string) wp_parse_url( $req, PHP_URL_PATH ), '/' );
		$base_slug = preg_replace( '/\.html$/i', '', basename( $path ) );
		$known     = array( 'shop', 'product-details', 'cart', 'checkout', 'wishlist', 'about', 'contact', 'faq', 'login', 'register' );
		if ( in_array( $base_slug, $known, true ) ) {
			return $base_slug;
		}
		return 'home';
	}

	if ( is_page() ) {
		$post = get_post();
		if ( $post ) {
			return $post->post_name;
		}
	}

	$req       = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	$path      = trim( (string) wp_parse_url( $req, PHP_URL_PATH ), '/' );
	$base_slug = preg_replace( '/\.html$/i', '', basename( $path ) );
	if ( empty( $base_slug ) || 'index' === $base_slug ) {
		return 'home';
	}
	return $base_slug;
}

/**
 * 3. Default 12 Luxury Atelier Products Data
 */
function vibestore_get_default_catalog() {
	return array(
		array(
			'id'               => 'vibe-001',
			'slug'             => 'atelier-cashmere-trench-coat',
			'name'             => 'Atelier Double-Faced Cashmere Trench',
			'category'         => 'Outerwear',
			'price'            => 680,
			'originalPrice'    => 790,
			'rating'           => 4.9,
			'reviewsCount'     => 42,
			'badge'            => 'Best Seller',
			'images'           => array( 'images/products/trench-1.jpg', 'images/products/trench-2.jpg' ),
			'colors'           => array(
				array( 'name' => 'Warm Sand', 'hex' => '#D8CFC2' ),
				array( 'name' => 'Obsidian Black', 'hex' => '#0A0A0A' ),
				array( 'name' => 'Espresso', 'hex' => '#3B2F2F' ),
			),
			'sizes'            => array( 'XS', 'S', 'M', 'L', 'XL' ),
			'shortDescription' => 'Hand-finished double-faced wool & cashmere blend with relaxed tailoring.',
			'description'      => 'Crafted in Milan from an ultra-soft 90% virgin wool and 10% Inner Mongolian cashmere blend. Features hand-stitched double-faced seams, horn buttons, and a tonal waist belt for effortless draping.',
			'featured'         => true,
			'trending'         => true,
			'bestSeller'       => true,
			'newArrival'       => false,
		),
		array(
			'id'               => 'vibe-002',
			'slug'             => 'sculpted-leather-crossbody-tote',
			'name'             => 'Sculpted Calfskin Architectural Tote',
			'category'         => 'Leather Goods',
			'price'            => 420,
			'originalPrice'    => 0,
			'rating'           => 4.8,
			'reviewsCount'     => 31,
			'badge'            => 'New Arrival',
			'images'           => array( 'images/products/tote-1.jpg', 'images/products/tote-2.jpg' ),
			'colors'           => array(
				array( 'name' => 'Obsidian', 'hex' => '#0A0A0A' ),
				array( 'name' => 'Alabaster Cream', 'hex' => '#F3EFEA' ),
				array( 'name' => 'Cognac', 'hex' => '#8A5A36' ),
			),
			'sizes'            => array( 'One Size' ),
			'shortDescription' => 'Full-grain vegetable-tanned Italian calfskin with brushed gold hardware.',
			'description'      => 'Designed with minimalist geometric precision, our Architectural Tote transitions seamlessly from studio to evening with a raw suede interior, internal zippered pocket, and concealed magnetic closure.',
			'featured'         => true,
			'trending'         => true,
			'bestSeller'       => false,
			'newArrival'       => true,
		),
		array(
			'id'               => 'vibe-003',
			'slug'             => 'merino-ribbed-column-knit-dress',
			'name'             => 'Merino Fine-Rib Column Knit Dress',
			'category'         => 'Knitwear',
			'price'            => 295,
			'originalPrice'    => 0,
			'rating'           => 4.9,
			'reviewsCount'     => 58,
			'badge'            => 'Best Seller',
			'images'           => array( 'images/products/knit-1.jpg', 'images/products/knit-2.jpg' ),
			'colors'           => array(
				array( 'name' => 'Oatmeal Beige', 'hex' => '#E6DFD3' ),
				array( 'name' => 'Charcoal', 'hex' => '#3A3A38' ),
				array( 'name' => 'Obsidian', 'hex' => '#0A0A0A' ),
			),
			'sizes'            => array( 'XS', 'S', 'M', 'L' ),
			'shortDescription' => 'Extra-fine Australian merino wool sculpted in an elongated column silhouette.',
			'description'      => 'Knitted in a seamless variegated rib that contours softly without restriction. Breathable, pill-resistant, and finished with architectural split cuffs.',
			'featured'         => true,
			'trending'         => false,
			'bestSeller'       => true,
			'newArrival'       => false,
		),
		array(
			'id'               => 'vibe-004',
			'slug'             => 'minimalist-acetate-sunglasses',
			'name'             => 'Le Noir Mazzucchelli Acetate Frames',
			'category'         => 'Accessories',
			'price'            => 210,
			'originalPrice'    => 0,
			'rating'           => 4.7,
			'reviewsCount'     => 19,
			'badge'            => 'Limited Edition',
			'images'           => array( 'images/products/eyewear-1.jpg', 'images/products/eyewear-2.jpg' ),
			'colors'           => array(
				array( 'name' => 'Obsidian Gloss', 'hex' => '#0A0A0A' ),
				array( 'name' => 'Warm Tortoise', 'hex' => '#6E4726' ),
			),
			'sizes'            => array( 'One Size' ),
			'shortDescription' => 'Hand-polished bio-acetate frames with 100% UV400 CR-39 nylon lenses.',
			'description'      => 'Engineered with five-barrel silver rivets and sculpted nose bridges for weightless all-day comfort and unmistakable architectural presence.',
			'featured'         => true,
			'trending'         => true,
			'bestSeller'       => false,
			'newArrival'       => true,
		),
		array(
			'id'               => 'vibe-005',
			'slug'             => 'tailored-virgin-wool-atelier-blazer',
			'name'             => 'Tailored Virgin Wool Atelier Blazer',
			'category'         => 'Outerwear',
			'price'            => 540,
			'originalPrice'    => 620,
			'rating'           => 4.9,
			'reviewsCount'     => 37,
			'badge'            => 'Best Seller',
			'images'           => array( 'images/products/blazer-1.jpg', 'images/products/blazer-2.jpg' ),
			'colors'           => array(
				array( 'name' => 'Obsidian Black', 'hex' => '#0A0A0A' ),
				array( 'name' => 'Warm Stone', 'hex' => '#C8C2B8' ),
			),
			'sizes'            => array( 'XS', 'S', 'M', 'L', 'XL' ),
			'shortDescription' => 'Single-breasted architectural blazer in breathable Italian virgin wool.',
			'description'      => 'Cut with a slightly elongated silhouette, padded shoulders, and breathable cupro lining. Designed to layer effortlessly over fine knitwear or silk trousers.',
			'featured'         => false,
			'trending'         => true,
			'bestSeller'       => true,
			'newArrival'       => false,
		),
		array(
			'id'               => 'vibe-006',
			'slug'             => 'organic-cashmere-relaxed-cardigan',
			'name'             => 'Organic Cashmere Relaxed Cardigan',
			'category'         => 'Knitwear',
			'price'            => 360,
			'originalPrice'    => 0,
			'rating'           => 4.8,
			'reviewsCount'     => 29,
			'badge'            => 'New Arrival',
			'images'           => array( 'images/products/cardigan-1.jpg', 'images/products/cardigan-2.jpg' ),
			'colors'           => array(
				array( 'name' => 'Alabaster Ivory', 'hex' => '#F4F1EA' ),
				array( 'name' => 'Warm Sand', 'hex' => '#D6CBB9' ),
				array( 'name' => 'Charcoal', 'hex' => '#444340' ),
			),
			'sizes'            => array( 'XS', 'S', 'M', 'L' ),
			'shortDescription' => '7-gauge plush organic cashmere with mother-of-pearl closures.',
			'description'      => 'Lofty, cloud-soft 100% GOTS-certified organic cashmere knitted in a relaxed boxy proportion with deep ribbed trims and welt pockets.',
			'featured'         => false,
			'trending'         => false,
			'bestSeller'       => true,
			'newArrival'       => true,
		),
		array(
			'id'               => 'vibe-007',
			'slug'             => 'vitello-leather-Chelsea-ankle-boots',
			'name'             => 'Vitello Leather Architectural Boots',
			'category'         => 'Leather Goods',
			'price'            => 490,
			'originalPrice'    => 0,
			'rating'           => 4.9,
			'reviewsCount'     => 46,
			'badge'            => 'Best Seller',
			'images'           => array( 'images/products/boots-1.jpg', 'images/products/boots-2.jpg' ),
			'colors'           => array(
				array( 'name' => 'Obsidian Calf', 'hex' => '#0A0A0A' ),
				array( 'name' => 'Dark Espresso', 'hex' => '#2E211B' ),
			),
			'sizes'            => array( '36', '37', '38', '39', '40', '41' ),
			'shortDescription' => 'Blake-stitched Italian calfskin boots with sculpted square-round toe.',
			'description'      => 'Handcrafted in Tuscany with supple calfskin lining, cushioned leather insoles, and a stacked 45mm architectural block heel.',
			'featured'         => false,
			'trending'         => true,
			'bestSeller'       => true,
			'newArrival'       => false,
		),
		array(
			'id'               => 'vibe-008',
			'slug'             => 'chronographe-minimal-steel-timepiece',
			'name'             => "L'Heure Minimalist Brushed Timepiece",
			'category'         => 'Accessories',
			'price'            => 385,
			'originalPrice'    => 0,
			'rating'           => 4.8,
			'reviewsCount'     => 24,
			'badge'            => 'New Arrival',
			'images'           => array( 'images/products/timepiece-1.jpg', 'images/products/timepiece-2.jpg' ),
			'colors'           => array(
				array( 'name' => 'Champagne Dial', 'hex' => '#C5A880' ),
				array( 'name' => 'Obsidian Dial', 'hex' => '#0A0A0A' ),
			),
			'sizes'            => array( '38mm' ),
			'shortDescription' => 'Swiss quartz movement housed in surgical-grade 316L brushed steel.',
			'description'      => 'Scratch-resistant sapphire crystal glass with an ultra-thin 6.8mm case profile and interchangeable Italian vegetable-tanned leather strap.',
			'featured'         => false,
			'trending'         => false,
			'bestSeller'       => false,
			'newArrival'       => true,
		),
		array(
			'id'               => 'vibe-009',
			'slug'             => 'belted-alpaca-wool-overcoat',
			'name'             => 'Belted Suri Alpaca & Wool Overcoat',
			'category'         => 'Outerwear',
			'price'            => 740,
			'originalPrice'    => 0,
			'rating'           => 5.0,
			'reviewsCount'     => 18,
			'badge'            => 'Limited Edition',
			'images'           => array( 'images/products/trench-2.jpg', 'images/products/trench-1.jpg' ),
			'colors'           => array(
				array( 'name' => 'Espresso Brown', 'hex' => '#3B2F2F' ),
				array( 'name' => 'Warm Sand', 'hex' => '#D8CFC2' ),
			),
			'sizes'            => array( 'XS', 'S', 'M', 'L' ),
			'shortDescription' => 'Brushed Peruvian Suri alpaca and virgin wool with storm lapel.',
			'description'      => 'Tailored with generous volume and a wrap-around self-belt, offering plush texture and exceptional thermal insulation without weight.',
			'featured'         => false,
			'trending'         => true,
			'bestSeller'       => false,
			'newArrival'       => true,
		),
		array(
			'id'               => 'vibe-010',
			'slug'             => 'fine-merino-mockneck-pullover',
			'name'             => 'Fine Merino Architectural Mockneck',
			'category'         => 'Knitwear',
			'price'            => 245,
			'originalPrice'    => 0,
			'rating'           => 4.8,
			'reviewsCount'     => 34,
			'badge'            => '',
			'images'           => array( 'images/products/cardigan-2.jpg', 'images/products/cardigan-1.jpg' ),
			'colors'           => array(
				array( 'name' => 'Obsidian', 'hex' => '#0A0A0A' ),
				array( 'name' => 'Alabaster', 'hex' => '#F4F1EA' ),
				array( 'name' => 'Warm Sand', 'hex' => '#D6CBB9' ),
			),
			'sizes'            => array( 'XS', 'S', 'M', 'L', 'XL' ),
			'shortDescription' => '18-gauge superfine merino wool knitted for second-skin layering.',
			'description'      => 'Designed as the foundational layer of a minimalist wardrobe, featuring fully-fashioned raglan shoulders and clean tubular hems.',
			'featured'         => false,
			'trending'         => false,
			'bestSeller'       => true,
			'newArrival'       => false,
		),
		array(
			'id'               => 'vibe-011',
			'slug'             => 'mini-geometric-calfskin-shoulder-bag',
			'name'             => 'Geometric Calfskin Shoulder Bag',
			'category'         => 'Leather Goods',
			'price'            => 365,
			'originalPrice'    => 0,
			'rating'           => 4.9,
			'reviewsCount'     => 27,
			'badge'            => 'New Arrival',
			'images'           => array( 'images/products/tote-2.jpg', 'images/products/tote-1.jpg' ),
			'colors'           => array(
				array( 'name' => 'Cognac', 'hex' => '#8A5A36' ),
				array( 'name' => 'Obsidian', 'hex' => '#0A0A0A' ),
			),
			'sizes'            => array( 'One Size' ),
			'shortDescription' => 'Structured demi-lune silhouette in smooth vegetable-tanned leather.',
			'description'      => 'Equipped with an adjustable shoulder strap, hand-painted edges, and tonal calfskin lining sized for daily essentials.',
			'featured'         => false,
			'trending'         => true,
			'bestSeller'       => false,
			'newArrival'       => true,
		),
		array(
			'id'               => 'vibe-012',
			'slug'             => 'pure-mulberry-silk-atelier-scarf',
			'name'             => '16-Momme Mulberry Silk Twill Scarf',
			'category'         => 'Accessories',
			'price'            => 175,
			'originalPrice'    => 0,
			'rating'           => 4.8,
			'reviewsCount'     => 22,
			'badge'            => '',
			'images'           => array( 'images/products/eyewear-2.jpg', 'images/products/eyewear-1.jpg' ),
			'colors'           => array(
				array( 'name' => 'Champagne / Obsidian', 'hex' => '#C5A880' ),
				array( 'name' => 'Warm Beige', 'hex' => '#E6DFD3' ),
			),
			'sizes'            => array( '90cm x 90cm' ),
			'shortDescription' => 'Hand-rolled edges printed in Como, Italy on organic mulberry silk.',
			'description'      => 'An heirloom square scarf featuring minimalist architectural linework inspired by mid-century Milanese facades.',
			'featured'         => false,
			'trending'         => false,
			'bestSeller'       => false,
			'newArrival'       => false,
		),
	);
}

/**
 * 4. Register Custom Post Type: Atelier Products (vibe_product)
 */
function vibestore_register_product_cpt() {
	register_post_type(
		'vibe_product',
		array(
			'labels'       => array(
				'name'               => __( 'Atelier Products', 'vibestore' ),
				'singular_name'      => __( 'Atelier Product', 'vibestore' ),
				'add_new'            => __( 'Add New Piece', 'vibestore' ),
				'add_new_item'       => __( 'Add New Atelier Piece', 'vibestore' ),
				'edit_item'          => __( 'Edit Atelier Piece', 'vibestore' ),
				'new_item'           => __( 'New Atelier Piece', 'vibestore' ),
				'view_item'          => __( 'View Atelier Piece', 'vibestore' ),
				'search_items'       => __( 'Search Atelier Pieces', 'vibestore' ),
				'not_found'          => __( 'No atelier pieces found', 'vibestore' ),
				'not_found_in_trash' => __( 'No atelier pieces found in Trash', 'vibestore' ),
				'menu_name'          => __( 'Atelier Products', 'vibestore' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'menu_icon'    => 'dashicons-products',
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'vibestore_register_product_cpt' );

/**
 * Add Meta Box for Atelier Product Specifications in WP Admin
 */
function vibestore_add_product_meta_boxes() {
	add_meta_box(
		'vibestore_product_specs',
		__( 'Atelier Product & Variation Specifications', 'vibestore' ),
		'vibestore_render_product_meta_box',
		array( 'vibe_product', 'product' ),
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'vibestore_add_product_meta_boxes' );

function vibestore_render_product_meta_box( $post ) {
	wp_nonce_field( 'vibestore_save_product_meta', 'vibestore_product_meta_nonce' );

	$sku            = get_post_meta( $post->ID, '_vibe_sku', true );
	$category       = get_post_meta( $post->ID, '_vibe_category', true );
	$price          = get_post_meta( $post->ID, '_vibe_price', true );
	$original_price = get_post_meta( $post->ID, '_vibe_original_price', true );
	$badge          = get_post_meta( $post->ID, '_vibe_badge', true );
	$rating         = get_post_meta( $post->ID, '_vibe_rating', true );
	$reviews_count  = get_post_meta( $post->ID, '_vibe_reviews_count', true );
	$img_primary    = get_post_meta( $post->ID, '_vibe_image_1', true );
	$img_secondary  = get_post_meta( $post->ID, '_vibe_image_2', true );
	$sizes_csv      = get_post_meta( $post->ID, '_vibe_sizes_csv', true );
	$trending       = get_post_meta( $post->ID, '_vibe_trending', true );
	$bestseller     = get_post_meta( $post->ID, '_vibe_bestseller', true );
	$new_arrival    = get_post_meta( $post->ID, '_vibe_new_arrival', true );
	?>
	<style>
		.vibe-admin-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 16px; }
		.vibe-admin-field label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 12px; text-transform: uppercase; }
		.vibe-admin-field input[type="text"], .vibe-admin-field input[type="number"], .vibe-admin-field select { width: 100%; padding: 6px 10px; }
	</style>
	<div class="vibe-admin-grid">
		<div class="vibe-admin-field">
			<label for="vibe_sku">Product ID / SKU</label>
			<input type="text" id="vibe_sku" name="vibe_sku" value="<?php echo esc_attr( $sku ? $sku : 'vibe-' . $post->ID ); ?>" />
		</div>
		<div class="vibe-admin-field">
			<label for="vibe_category">Category</label>
			<select id="vibe_category" name="vibe_category">
				<?php
				$cats = array( 'Outerwear', 'Knitwear', 'Leather Goods', 'Accessories' );
				foreach ( $cats as $c ) {
					printf(
						'<option value="%s" %s>%s</option>',
						esc_attr( $c ),
						selected( $category, $c, false ),
						esc_html( $c )
					);
				}
				?>
			</select>
		</div>
		<div class="vibe-admin-field">
			<label for="vibe_badge">Badge (e.g. Best Seller, New Arrival, Limited Edition)</label>
			<input type="text" id="vibe_badge" name="vibe_badge" value="<?php echo esc_attr( $badge ); ?>" />
		</div>
	</div>

	<div class="vibe-admin-grid">
		<div class="vibe-admin-field">
			<label for="vibe_price">Price ($ USD)</label>
			<input type="number" step="1" id="vibe_price" name="vibe_price" value="<?php echo esc_attr( $price ? $price : 350 ); ?>" />
		</div>
		<div class="vibe-admin-field">
			<label for="vibe_original_price">Original Price ($ USD, optional)</label>
			<input type="number" step="1" id="vibe_original_price" name="vibe_original_price" value="<?php echo esc_attr( $original_price ); ?>" />
		</div>
		<div class="vibe-admin-field">
			<label for="vibe_sizes_csv">Available Sizes (comma-separated)</label>
			<input type="text" id="vibe_sizes_csv" name="vibe_sizes_csv" value="<?php echo esc_attr( $sizes_csv ? $sizes_csv : 'XS, S, M, L, XL' ); ?>" />
		</div>
	</div>

	<div class="vibe-admin-grid">
		<div class="vibe-admin-field">
			<label for="vibe_image_1">Primary Image Path or URL</label>
			<input type="text" id="vibe_image_1" name="vibe_image_1" value="<?php echo esc_attr( $img_primary ? $img_primary : 'images/products/trench-1.jpg' ); ?>" />
		</div>
		<div class="vibe-admin-field">
			<label for="vibe_image_2">Secondary Hover Image Path or URL</label>
			<input type="text" id="vibe_image_2" name="vibe_image_2" value="<?php echo esc_attr( $img_secondary ? $img_secondary : 'images/products/trench-2.jpg' ); ?>" />
		</div>
		<div class="vibe-admin-field">
			<label for="vibe_rating">Client Rating (e.g. 4.9) &amp; Review Count</label>
			<div style="display:flex;gap:8px;">
				<input type="number" step="0.1" min="1" max="5" id="vibe_rating" name="vibe_rating" value="<?php echo esc_attr( $rating ? $rating : 4.9 ); ?>" />
				<input type="number" step="1" id="vibe_reviews_count" name="vibe_reviews_count" value="<?php echo esc_attr( $reviews_count ? $reviews_count : 24 ); ?>" />
			</div>
		</div>
	</div>

	<div style="display:flex;gap:24px;padding-top:8px;">
		<label><input type="checkbox" name="vibe_trending" value="1" <?php checked( $trending, '1' ); ?> /> <strong>Trending Now</strong></label>
		<label><input type="checkbox" name="vibe_bestseller" value="1" <?php checked( $bestseller, '1' ); ?> /> <strong>Best-Selling Icon</strong></label>
		<label><input type="checkbox" name="vibe_new_arrival" value="1" <?php checked( $new_arrival, '1' ); ?> /> <strong>New Arrival</strong></label>
	</div>
	<?php
}

function vibestore_save_product_meta( $post_id ) {
	if ( ! isset( $_POST['vibestore_product_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['vibestore_product_meta_nonce'] ) ), 'vibestore_save_product_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$text_fields = array(
		'vibe_sku'            => '_vibe_sku',
		'vibe_category'       => '_vibe_category',
		'vibe_price'          => '_vibe_price',
		'vibe_original_price' => '_vibe_original_price',
		'vibe_badge'          => '_vibe_badge',
		'vibe_rating'         => '_vibe_rating',
		'vibe_reviews_count'  => '_vibe_reviews_count',
		'vibe_image_1'        => '_vibe_image_1',
		'vibe_image_2'        => '_vibe_image_2',
		'vibe_sizes_csv'      => '_vibe_sizes_csv',
	);

	foreach ( $text_fields as $input_name => $meta_key ) {
		if ( isset( $_POST[ $input_name ] ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $input_name ] ) ) );
		}
	}

	update_post_meta( $post_id, '_vibe_trending', isset( $_POST['vibe_trending'] ) ? '1' : '0' );
	update_post_meta( $post_id, '_vibe_bestseller', isset( $_POST['vibe_bestseller'] ) ? '1' : '0' );
	update_post_meta( $post_id, '_vibe_new_arrival', isset( $_POST['vibe_new_arrival'] ) ? '1' : '0' );
}
add_action( 'save_post_vibe_product', 'vibestore_save_product_meta' );
add_action( 'save_post_product', 'vibestore_save_product_meta' );

/**
 * Helper: Map a Color Name to a Luxury Hex Swatch Code
 */
function vibestore_color_name_to_hex( $color_name ) {
	$clean = strtolower( trim( (string) $color_name ) );
	if ( preg_match( '/^#[0-9a-f]{3,6}$/i', $clean ) ) {
		return $clean;
	}
	$map = array(
		'black'     => '#0A0A0A',
		'obsidian'  => '#0A0A0A',
		'noir'      => '#0A0A0A',
		'sand'      => '#D8CFC2',
		'beige'     => '#E6DFD3',
		'oatmeal'   => '#E6DFD3',
		'cream'     => '#F3EFEA',
		'alabaster' => '#F4F1EA',
		'ivory'     => '#F4F1EA',
		'white'     => '#FAFAFA',
		'espresso'  => '#3B2F2F',
		'brown'     => '#4A3728',
		'cognac'    => '#8A5A36',
		'tortoise'  => '#6E4726',
		'camel'     => '#C19A6B',
		'tan'       => '#D2B48C',
		'charcoal'  => '#3A3A38',
		'grey'      => '#7A7A76',
		'gray'      => '#7A7A76',
		'stone'     => '#C8C2B8',
		'champagne' => '#C5A880',
		'gold'      => '#C5A880',
		'silver'    => '#C0C0C0',
		'navy'      => '#1B2432',
		'blue'      => '#2C4251',
		'olive'     => '#4B5338',
		'green'     => '#2E4033',
		'sage'      => '#9CAF88',
		'burgundy'  => '#4A1C24',
		'wine'      => '#58181F',
		'red'       => '#7C1D1D',
	);
	foreach ( $map as $key => $hex ) {
		if ( false !== strpos( $clean, $key ) ) {
			return $hex;
		}
	}
	return '#C8C2B8';
}

/**
 * Helper: Split WooCommerce Attribute Options (Handles arrays, taxonomy terms, and pipe/comma strings)
 */
function vibestore_parse_attribute_options( $raw_options ) {
	$parsed = array();
	if ( ! is_array( $raw_options ) ) {
		$raw_options = array( (string) $raw_options );
	}
	foreach ( $raw_options as $opt ) {
		$pieces = preg_split( '/[\|,]+/', (string) $opt );
		foreach ( $pieces as $piece ) {
			$trimmed = trim( $piece );
			if ( '' !== $trimmed && ! in_array( $trimmed, $parsed, true ) ) {
				$parsed[] = $trimmed;
			}
		}
	}
	return $parsed;
}

/**
 * Retrieve Dynamic Catalog from WooCommerce ('product') & Atelier CPT ('vibe_product')
 */
function vibestore_get_active_catalog() {
	$catalog       = array();
	$seen_slugs    = array();
	$seen_ids      = array();
	$post_statuses = current_user_can( 'edit_posts' )
		? array( 'publish', 'private', 'draft', 'pending' )
		: array( 'publish' );

	// 1. Fetch WooCommerce Products ('product' post type) first so user-added WC products appear at the top
	$wc_posts = get_posts(
		array(
			'post_type'      => 'product',
			'post_status'    => $post_statuses,
			'posts_per_page' => -1,
			'orderby'        => 'date ID',
			'order'          => 'DESC',
		)
	);

	foreach ( $wc_posts as $wc_post ) {
		$wc_product = function_exists( 'wc_get_product' ) ? wc_get_product( $wc_post->ID ) : null;

		$sku     = get_post_meta( $wc_post->ID, '_sku', true );
		$prod_id = ( $sku && ! isset( $seen_ids[ (string) $sku ] ) ) ? (string) $sku : 'wc-' . $wc_post->ID;
		$slug    = $wc_post->post_name ? $wc_post->post_name : sanitize_title( $wc_post->post_title ?: $prod_id );

		// Category resolution from WooCommerce 'product_cat'
		$category = 'Outerwear';
		$terms    = get_the_terms( $wc_post->ID, 'product_cat' );
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				if ( 'uncategorized' !== strtolower( $term->slug ) && 'uncategorized' !== strtolower( $term->name ) ) {
					$category = wp_specialchars_decode( $term->name, ENT_QUOTES );
					break;
				}
			}
		}

		// Price resolution
		$raw_price     = $wc_product ? $wc_product->get_price() : get_post_meta( $wc_post->ID, '_price', true );
		$regular_price = $wc_product ? $wc_product->get_regular_price() : get_post_meta( $wc_post->ID, '_regular_price', true );
		$sale_price    = $wc_product ? $wc_product->get_sale_price() : get_post_meta( $wc_post->ID, '_sale_price', true );

		if ( '' === (string) $raw_price && '' !== (string) $regular_price ) {
			$raw_price = $regular_price;
		}
		$price      = '' !== (string) $raw_price ? (float) $raw_price : 0;
		$orig_price = ( '' !== (string) $sale_price && (float) $regular_price > (float) $sale_price )
			? (float) $regular_price
			: 0;

		// Images resolution (Featured Image + Product Gallery + Content Image fallback)
		$images    = array();
		$thumb_url = get_the_post_thumbnail_url( $wc_post->ID, 'full' );
		if ( $thumb_url ) {
			$images[] = esc_url( $thumb_url );
		}

		$gallery_ids = $wc_product
			? $wc_product->get_gallery_image_ids()
			: array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $wc_post->ID, '_product_image_gallery', true ) ) ) );

		if ( ! empty( $gallery_ids ) ) {
			foreach ( $gallery_ids as $att_id ) {
				$gal_url = wp_get_attachment_image_url( (int) $att_id, 'full' );
				if ( $gal_url && ! in_array( esc_url( $gal_url ), $images, true ) ) {
					$images[] = esc_url( $gal_url );
				}
			}
		}

		if ( empty( $images ) && ! empty( $wc_post->post_content ) ) {
			if ( preg_match( '/<img[^>]+src=[\'"]([^\'"]+)[\'"]/i', $wc_post->post_content, $matches ) ) {
				$images[] = esc_url( $matches[1] );
			}
		}

		if ( empty( $images ) ) {
			$images[] = vibestore_asset( 'images/products/trench-1.jpg' );
			$images[] = vibestore_asset( 'images/products/trench-2.jpg' );
		} elseif ( count( $images ) === 1 ) {
			$images[] = $images[0];
		}

		// Sizes, Colors & Custom Variation Attributes resolution from WC attributes & Variable Product variations
		$sizes            = array();
		$colors           = array();
		$extra_attributes = array();
		$variations_data  = array();

		if ( $wc_product && method_exists( $wc_product, 'get_attributes' ) ) {
			foreach ( $wc_product->get_attributes() as $attr_name => $attr ) {
				$clean_name = strtolower( (string) $attr_name );
				$label      = function_exists( 'wc_attribute_label' ) ? wc_attribute_label( $attr_name, $wc_product ) : ucwords( str_replace( array( 'pa_', '-', '_' ), ' ', $clean_name ) );

				$raw_opts = array();
				if ( is_object( $attr ) && method_exists( $attr, 'get_options' ) ) {
					$raw_opts = $attr->is_taxonomy()
						? wc_get_product_terms( $wc_post->ID, $attr->get_name(), array( 'fields' => 'names' ) )
						: $attr->get_options();
				}
				$opts = vibestore_parse_attribute_options( $raw_opts );
				if ( empty( $opts ) ) {
					continue;
				}

				if ( false !== strpos( $clean_name, 'size' ) ) {
					$sizes = $opts;
				} elseif ( false !== strpos( $clean_name, 'color' ) || false !== strpos( $clean_name, 'colour' ) || false !== strpos( $clean_name, 'shade' ) ) {
					foreach ( $opts as $c_name ) {
						$colors[] = array(
							'name' => $c_name,
							'hex'  => vibestore_color_name_to_hex( $c_name ),
						);
					}
				} else {
					$extra_attributes[] = array(
						'name'    => $label,
						'slug'    => sanitize_title( $clean_name ),
						'options' => $opts,
					);
				}
			}
		}

		// Extract Variable Product Variations if applicable
		if ( $wc_product && method_exists( $wc_product, 'is_type' ) && $wc_product->is_type( 'variable' ) ) {
			$child_ids = $wc_product->get_children();
			foreach ( $child_ids as $var_id ) {
				$var_obj = wc_get_product( $var_id );
				if ( ! $var_obj ) {
					continue;
				}
				$var_attrs = array();
				foreach ( (array) $var_obj->get_variation_attributes() as $k => $v ) {
					$clean_k               = str_replace( array( 'attribute_pa_', 'attribute_' ), '', strtolower( (string) $k ) );
					$var_attrs[ $clean_k ] = (string) $v;

					if ( false !== strpos( $clean_k, 'size' ) && '' !== (string) $v && ! in_array( (string) $v, $sizes, true ) ) {
						$sizes[] = strtoupper( (string) $v );
					}
					if ( ( false !== strpos( $clean_k, 'color' ) || false !== strpos( $clean_k, 'colour' ) ) && '' !== (string) $v ) {
						$exists = false;
						foreach ( $colors as $existing_c ) {
							if ( strtolower( $existing_c['name'] ) === strtolower( (string) $v ) ) {
								$exists = true;
								break;
							}
						}
						if ( ! $exists ) {
							$colors[] = array(
								'name' => ucwords( str_replace( '-', ' ', (string) $v ) ),
								'hex'  => vibestore_color_name_to_hex( (string) $v ),
							);
						}
					}
				}

				$var_img_id  = $var_obj->get_image_id();
				$var_img_url = $var_img_id ? wp_get_attachment_image_url( (int) $var_img_id, 'full' ) : '';
				if ( $var_img_url && ! in_array( esc_url( $var_img_url ), $images, true ) ) {
					$images[] = esc_url( $var_img_url );
				}

				$variations_data[] = array(
					'id'           => (int) $var_id,
					'sku'          => $var_obj->get_sku() ?: ( $prod_id . '-' . $var_id ),
					'price'        => '' !== (string) $var_obj->get_price() ? (float) $var_obj->get_price() : $price,
					'regularPrice' => '' !== (string) $var_obj->get_regular_price() ? (float) $var_obj->get_regular_price() : 0,
					'inStock'      => (bool) $var_obj->is_in_stock(),
					'stockQty'     => $var_obj->get_stock_quantity(),
					'image'        => $var_img_url ? esc_url( $var_img_url ) : '',
					'attributes'   => $var_attrs,
				);
			}
		}

		if ( empty( $sizes ) ) {
			$meta_sizes = get_post_meta( $wc_post->ID, '_vibe_sizes_csv', true );
			$sizes      = $meta_sizes ? vibestore_parse_attribute_options( $meta_sizes ) : array( 'XS', 'S', 'M', 'L', 'XL' );
		}
		if ( empty( $colors ) ) {
			$colors = array(
				array( 'name' => 'Obsidian Black', 'hex' => '#0A0A0A' ),
				array( 'name' => 'Warm Sand', 'hex' => '#D8CFC2' ),
				array( 'name' => 'Alabaster', 'hex' => '#F4F1EA' ),
			);
		}
		if ( empty( $extra_attributes ) ) {
			$extra_attributes = array(
				array(
					'name'    => 'Silhouette Fit',
					'slug'    => 'fit',
					'options' => array( 'Signature Atelier Drape', 'Tailored Contour Fit' ),
				),
			);
		}

		$rating        = (float) get_post_meta( $wc_post->ID, '_wc_average_rating', true );
		$reviews_count = (int) get_post_meta( $wc_post->ID, '_wc_review_count', true );

		$short_desc = $wc_post->post_excerpt
			? wp_strip_all_tags( $wc_post->post_excerpt )
			: wp_trim_words( wp_strip_all_tags( $wc_post->post_content ), 22, '...' );
		$full_desc  = wp_strip_all_tags( $wc_post->post_content ) ?: $short_desc;

		if ( empty( $short_desc ) ) {
			$short_desc = 'Hand-finished luxury atelier piece crafted from traceable Italian fibers.';
		}
		if ( empty( $full_desc ) ) {
			$full_desc = $short_desc;
		}

		$badge = ( $orig_price > $price && $price > 0 ) ? 'Sale' : 'New Arrival';

		$wc_item = array(
			'id'               => $prod_id,
			'wcId'             => (int) $wc_post->ID,
			'slug'             => $slug,
			'name'             => $wc_post->post_title ? $wc_post->post_title : __( 'Atelier Piece', 'vibestore' ),
			'category'         => $category,
			'price'            => $price,
			'rating'           => $rating > 0 ? $rating : 5.0,
			'reviewsCount'     => $reviews_count > 0 ? $reviews_count : 12,
			'badge'            => $badge,
			'images'           => $images,
			'colors'           => $colors,
			'sizes'            => $sizes,
			'attributes'       => $extra_attributes,
			'variations'       => $variations_data,
			'shortDescription' => $short_desc,
			'description'      => $full_desc,
			'featured'         => true,
			'trending'         => true,
			'bestSeller'       => true,
			'newArrival'       => true,
		);

		if ( $orig_price > 0 ) {
			$wc_item['originalPrice'] = $orig_price;
		}

		$catalog[]              = $wc_item;
		$seen_slugs[ $slug ]    = true;
		$seen_ids[ $prod_id ]   = true;
	}

	// 2. Fetch Atelier Custom Post Type ('vibe_product')
	$posts = get_posts(
		array(
			'post_type'      => 'vibe_product',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order ID',
			'order'          => 'ASC',
		)
	);

	$defaults_by_id = array();
	foreach ( vibestore_get_default_catalog() as $item ) {
		$defaults_by_id[ $item['id'] ] = $item;
	}

	if ( ! empty( $posts ) ) {
		foreach ( $posts as $p ) {
			if ( isset( $seen_slugs[ $p->post_name ] ) ) {
				continue;
			}

			$sku      = get_post_meta( $p->ID, '_vibe_sku', true );
			$prod_id  = $sku ? $sku : 'vibe-' . $p->ID;
			$fallback = isset( $defaults_by_id[ $prod_id ] ) ? $defaults_by_id[ $prod_id ] : null;

			$img1 = get_post_meta( $p->ID, '_vibe_image_1', true );
			$img2 = get_post_meta( $p->ID, '_vibe_image_2', true );
			if ( has_post_thumbnail( $p->ID ) ) {
				$thumb_url = get_the_post_thumbnail_url( $p->ID, 'full' );
				if ( $thumb_url ) {
					$img1 = $thumb_url;
				}
			}

			$images = array();
			if ( $img1 ) {
				$images[] = vibestore_asset( $img1 );
			} elseif ( $fallback && ! empty( $fallback['images'][0] ) ) {
				$images[] = vibestore_asset( $fallback['images'][0] );
			} else {
				$images[] = vibestore_asset( 'images/products/trench-1.jpg' );
			}

			if ( $img2 ) {
				$images[] = vibestore_asset( $img2 );
			} elseif ( $fallback && ! empty( $fallback['images'][1] ) ) {
				$images[] = vibestore_asset( $fallback['images'][1] );
			}

			$sizes_csv = get_post_meta( $p->ID, '_vibe_sizes_csv', true );
			$sizes     = $sizes_csv
				? array_values( array_filter( array_map( 'trim', explode( ',', $sizes_csv ) ) ) )
				: ( $fallback ? $fallback['sizes'] : array( 'XS', 'S', 'M', 'L' ) );

			$colors_json = get_post_meta( $p->ID, '_vibe_colors_json', true );
			$colors      = $colors_json ? json_decode( $colors_json, true ) : null;
			if ( empty( $colors ) || ! is_array( $colors ) ) {
				$colors = $fallback ? $fallback['colors'] : array(
					array( 'name' => 'Obsidian Black', 'hex' => '#0A0A0A' ),
					array( 'name' => 'Warm Sand', 'hex' => '#D8CFC2' ),
				);
			}

			$orig_price = (float) get_post_meta( $p->ID, '_vibe_original_price', true );

			$item_data = array(
				'id'               => $prod_id,
				'slug'             => $p->post_name,
				'name'             => $p->post_title,
				'category'         => get_post_meta( $p->ID, '_vibe_category', true ) ?: 'Outerwear',
				'price'            => (float) ( get_post_meta( $p->ID, '_vibe_price', true ) ?: 350 ),
				'rating'           => (float) ( get_post_meta( $p->ID, '_vibe_rating', true ) ?: 4.9 ),
				'reviewsCount'     => (int) ( get_post_meta( $p->ID, '_vibe_reviews_count', true ) ?: 24 ),
				'badge'            => get_post_meta( $p->ID, '_vibe_badge', true ) ?: '',
				'images'           => $images,
				'colors'           => $colors,
				'sizes'            => $sizes,
				'shortDescription' => $p->post_excerpt ?: ( $fallback ? $fallback['shortDescription'] : '' ),
				'description'      => wp_strip_all_tags( $p->post_content ) ?: ( $fallback ? $fallback['description'] : '' ),
				'featured'         => '1' === get_post_meta( $p->ID, '_vibe_featured', true ),
				'trending'         => '1' === get_post_meta( $p->ID, '_vibe_trending', true ),
				'bestSeller'       => '1' === get_post_meta( $p->ID, '_vibe_bestseller', true ),
				'newArrival'       => '1' === get_post_meta( $p->ID, '_vibe_new_arrival', true ),
			);

			if ( $orig_price > 0 ) {
				$item_data['originalPrice'] = $orig_price;
			}

			$catalog[] = $item_data;
		}
	} else {
		foreach ( vibestore_get_default_catalog() as $def_item ) {
			$def_item['images'] = array_map( 'vibestore_asset', $def_item['images'] );
			$catalog[]          = $def_item;
		}
	}

	return $catalog;
}

/**
 * Helper: Resolve Currently Viewed Product for Single Product Page (Server-Side)
 */
function vibestore_get_current_pdp_product() {
	$catalog = vibestore_get_active_catalog();
	if ( empty( $catalog ) ) {
		return null;
	}

	$target = '';
	if ( isset( $_GET['id'] ) && '' !== trim( (string) $_GET['id'] ) ) {
		$target = sanitize_text_field( wp_unslash( $_GET['id'] ) );
	} elseif ( isset( $_GET['product'] ) && '' !== trim( (string) $_GET['product'] ) ) {
		$target = sanitize_text_field( wp_unslash( $_GET['product'] ) );
	} elseif ( is_singular( array( 'product', 'vibe_product' ) ) ) {
		$q = get_queried_object();
		if ( $q && ! empty( $q->post_name ) ) {
			$target = $q->post_name;
		} elseif ( $q && ! empty( $q->ID ) ) {
			$target = 'wc-' . $q->ID;
		}
	}

	if ( $target ) {
		foreach ( $catalog as $item ) {
			if (
				(string) $item['id'] === (string) $target ||
				(string) $item['slug'] === (string) $target ||
				( isset( $item['wcId'] ) && (string) $item['wcId'] === (string) $target )
			) {
				return $item;
			}
		}
	}

	return $catalog[0];
}

/**
 * Helper: Country-by-Country Shipping Configuration Synced with WooCommerce Shipping Zones
 * - Pakistan (PK): Free Shipping ($0) + Priority Express ($10)
 * - Other Countries: Paid International Shipping with region-specific charges
 */
function vibestore_get_shipping_config() {
	$country_rates = array(
		'Pakistan'             => array(
			'code'          => 'PK',
			'isFree'        => true,
			'standard'      => 0,
			'express'       => 10,
			'standardLabel' => 'Free Shipping — Pakistan Nationwide Delivery (2–3 Days)',
			'expressLabel'  => 'Same-Day / Next-Day Priority Courier — Pakistan',
		),
		'United Arab Emirates' => array(
			'code'          => 'AE',
			'isFree'        => false,
			'standard'      => 15,
			'express'       => 30,
			'standardLabel' => 'DHL International Standard — UAE (3–5 Days)',
			'expressLabel'  => 'DHL Priority Air Express — UAE (24–48 Hours)',
		),
		'Saudi Arabia'         => array(
			'code'          => 'SA',
			'isFree'        => false,
			'standard'      => 18,
			'express'       => 32,
			'standardLabel' => 'DHL International Standard — Saudi Arabia (3–5 Days)',
			'expressLabel'  => 'DHL Priority Air Express — Saudi Arabia (24–48 Hours)',
		),
		'Qatar'                => array(
			'code'          => 'QA',
			'isFree'        => false,
			'standard'      => 18,
			'express'       => 32,
			'standardLabel' => 'DHL International Standard — Qatar (3–5 Days)',
			'expressLabel'  => 'DHL Priority Air Express — Qatar (24–48 Hours)',
		),
		'Turkey'               => array(
			'code'          => 'TR',
			'isFree'        => false,
			'standard'      => 22,
			'express'       => 38,
			'standardLabel' => 'DHL International Standard — Turkey (4–6 Days)',
			'expressLabel'  => 'DHL Priority Air Express — Turkey (2–3 Days)',
		),
		'United Kingdom'       => array(
			'code'          => 'GB',
			'isFree'        => false,
			'standard'      => 25,
			'express'       => 45,
			'standardLabel' => 'DHL International Standard — United Kingdom (4–6 Days)',
			'expressLabel'  => 'DHL Priority Air Express — United Kingdom (2–3 Days)',
		),
		'France'               => array(
			'code'          => 'FR',
			'isFree'        => false,
			'standard'      => 25,
			'express'       => 45,
			'standardLabel' => 'DHL Euro Standard — France (4–6 Days)',
			'expressLabel'  => 'DHL Priority Air Express — France (2–3 Days)',
		),
		'Italy'                => array(
			'code'          => 'IT',
			'isFree'        => false,
			'standard'      => 25,
			'express'       => 45,
			'standardLabel' => 'DHL Euro Standard — Italy (4–6 Days)',
			'expressLabel'  => 'DHL Priority Air Express — Italy (2–3 Days)',
		),
		'Germany'              => array(
			'code'          => 'DE',
			'isFree'        => false,
			'standard'      => 25,
			'express'       => 45,
			'standardLabel' => 'DHL Euro Standard — Germany (4–6 Days)',
			'expressLabel'  => 'DHL Priority Air Express — Germany (2–3 Days)',
		),
		'Switzerland'          => array(
			'code'          => 'CH',
			'isFree'        => false,
			'standard'      => 28,
			'express'       => 48,
			'standardLabel' => 'DHL International Standard — Switzerland (4–6 Days)',
			'expressLabel'  => 'DHL Priority Air Express — Switzerland (2–3 Days)',
		),
		'United States'        => array(
			'code'          => 'US',
			'isFree'        => false,
			'standard'      => 30,
			'express'       => 50,
			'standardLabel' => 'DHL International Standard — United States (5–7 Days)',
			'expressLabel'  => 'DHL Priority Air Express — United States (2–3 Days)',
		),
		'Canada'               => array(
			'code'          => 'CA',
			'isFree'        => false,
			'standard'      => 32,
			'express'       => 52,
			'standardLabel' => 'DHL International Standard — Canada (5–7 Days)',
			'expressLabel'  => 'DHL Priority Air Express — Canada (2–3 Days)',
		),
		'Australia'            => array(
			'code'          => 'AU',
			'isFree'        => false,
			'standard'      => 35,
			'express'       => 55,
			'standardLabel' => 'DHL International Standard — Australia (5–8 Days)',
			'expressLabel'  => 'DHL Priority Air Express — Australia (3–4 Days)',
		),
		'Japan'                => array(
			'code'          => 'JP',
			'isFree'        => false,
			'standard'      => 35,
			'express'       => 55,
			'standardLabel' => 'DHL International Standard — Japan (5–8 Days)',
			'expressLabel'  => 'DHL Priority Air Express — Japan (3–4 Days)',
		),
	);

	// Sync with live WooCommerce Shipping Zones if configured in WP Admin -> WooCommerce -> Settings -> Shipping
	if ( class_exists( 'WC_Shipping_Zones' ) ) {
		$code_to_name = array();
		foreach ( $country_rates as $c_name => $c_data ) {
			$code_to_name[ $c_data['code'] ] = $c_name;
		}

		$zones = WC_Shipping_Zones::get_zones();
		foreach ( $zones as $zone_arr ) {
			if ( empty( $zone_arr['zone_locations'] ) || empty( $zone_arr['shipping_methods'] ) ) {
				continue;
			}
			$has_free  = false;
			$flat_cost = null;
			foreach ( $zone_arr['shipping_methods'] as $method ) {
				if ( ! isset( $method->enabled ) || 'yes' !== $method->enabled ) {
					continue;
				}
				if ( 'free_shipping' === $method->id ) {
					$has_free = true;
				} elseif ( 'flat_rate' === $method->id ) {
					$cost_val = isset( $method->cost ) ? (float) $method->cost : 0.0;
					if ( $cost_val > 0 ) {
						$flat_cost = $cost_val;
					}
				}
			}

			foreach ( $zone_arr['zone_locations'] as $loc ) {
				if ( isset( $loc->type, $loc->code ) && 'country' === $loc->type && isset( $code_to_name[ $loc->code ] ) ) {
					$target_country = $code_to_name[ $loc->code ];
					if ( $has_free ) {
						$country_rates[ $target_country ]['isFree']   = true;
						$country_rates[ $target_country ]['standard'] = 0;
						if ( null !== $flat_cost ) {
							$country_rates[ $target_country ]['express'] = $flat_cost;
						}
					} elseif ( null !== $flat_cost ) {
						$country_rates[ $target_country ]['isFree']   = false;
						$country_rates[ $target_country ]['standard'] = $flat_cost;
						$country_rates[ $target_country ]['express']  = $flat_cost + 20;
					}
				}
			}
		}
	}

	return array(
		'defaultCountry' => 'Pakistan',
		'countries'      => $country_rates,
	);
}

/**
 * 5. Enqueue Styles & Scripts
 */
function vibestore_enqueue_scripts() {
	// Google Fonts: Cormorant Garamond + Plus Jakarta Sans
	wp_enqueue_style(
		'vibestore-google-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap',
		array(),
		null
	);

	// Main Theme Stylesheet
	wp_enqueue_style(
		'vibestore-style',
		get_stylesheet_uri(),
		array( 'vibestore-google-fonts' ),
		VIBESTORE_VERSION
	);

	// Products Catalog Script
	wp_enqueue_script(
		'vibestore-products',
		VIBESTORE_URI . '/js/products.js',
		array(),
		VIBESTORE_VERSION,
		true
	);

	// Pass WordPress URLs & Asset Base to JS before products.js runs
	$config = array(
		'themeUri' => trailingslashit( VIBESTORE_URI ),
		'homeUrl'  => trailingslashit( home_url() ),
		'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
		'shipping' => vibestore_get_shipping_config(),
		'routes'   => array(
			'home'            => vibestore_page_url( 'home' ),
			'shop'            => vibestore_page_url( 'shop' ),
			'product-details' => vibestore_page_url( 'product-details' ),
			'cart'            => vibestore_page_url( 'cart' ),
			'checkout'        => vibestore_page_url( 'checkout' ),
			'wishlist'        => vibestore_page_url( 'wishlist' ),
			'about'           => vibestore_page_url( 'about' ),
			'contact'         => vibestore_page_url( 'contact' ),
			'faq'             => vibestore_page_url( 'faq' ),
			'login'           => vibestore_page_url( 'login' ),
			'register'        => vibestore_page_url( 'register' ),
		),
	);

	$inline_init = 'window.VIBE_WP_CONFIG = ' . wp_json_encode( $config ) . ';
window.vibeAssetUrl = function(path) {
	if (!path) return "";
	if (path.indexOf("http://") === 0 || path.indexOf("https://") === 0 || path.indexOf("/") === 0) return path;
	return window.VIBE_WP_CONFIG.themeUri + path.replace(/^\/+/, "");
};
window.vibePageUrl = function(pageKey, queryOrHash) {
	var routes = (window.VIBE_WP_CONFIG && window.VIBE_WP_CONFIG.routes) || {};
	var cleanKey = (pageKey || "home").replace(/\.html$/i, "");
	if (cleanKey === "index") cleanKey = "home";
	var base = routes[cleanKey] || (window.VIBE_WP_CONFIG.homeUrl + cleanKey + "/");
	if (!queryOrHash) return base;
	if (queryOrHash.charAt(0) === "?") {
		return base + (base.indexOf("?") !== -1 ? "&" : "?") + queryOrHash.substring(1);
	}
	return base + queryOrHash;
};';

	wp_add_inline_script( 'vibestore-products', $inline_init, 'before' );

	// Sync WooCommerce & WP Admin Atelier Products
	$db_catalog  = vibestore_get_active_catalog();
	$current_pid = '';
	if ( is_singular( array( 'product', 'vibe_product' ) ) ) {
		$queried = get_queried_object();
		if ( $queried && ! empty( $queried->post_name ) ) {
			$current_pid = $queried->post_name;
		} elseif ( $queried && ! empty( $queried->ID ) ) {
			$current_pid = 'wc-' . $queried->ID;
		}
	}

	if ( ! empty( $db_catalog ) ) {
		$inline_catalog = 'window.VIBE_PRODUCTS = ' . wp_json_encode( $db_catalog ) . ';';
		if ( $current_pid ) {
			$inline_catalog .= ' window.VIBE_CURRENT_PRODUCT_ID = ' . wp_json_encode( $current_pid ) . ';';
		}
		wp_add_inline_script(
			'vibestore-products',
			$inline_catalog,
			'after'
		);
	}

	// Cart Engine
	wp_enqueue_script(
		'vibestore-cart',
		VIBESTORE_URI . '/js/cart.js',
		array( 'vibestore-products' ),
		VIBESTORE_VERSION,
		true
	);

	// Wishlist Engine
	wp_enqueue_script(
		'vibestore-wishlist',
		VIBESTORE_URI . '/js/wishlist.js',
		array( 'vibestore-products' ),
		VIBESTORE_VERSION,
		true
	);

	// Main UI & Interaction Controller
	wp_enqueue_script(
		'vibestore-script',
		VIBESTORE_URI . '/js/script.js',
		array( 'vibestore-products', 'vibestore-cart', 'vibestore-wishlist' ),
		VIBESTORE_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'vibestore_enqueue_scripts' );

/**
 * 6. Auto-Create Required Store Pages & Seed 12 Atelier Products on Theme Init / Activation
 */
function vibestore_ensure_pages_and_products() {
	if ( ! get_option( 'vibestore_pages_created_v1' ) ) {
		$pages = array(
			'shop'            => array(
				'title'    => 'Shop Collection',
				'template' => 'page-shop.php',
			),
			'product-details' => array(
				'title'    => 'Product Details',
				'template' => 'page-product-details.php',
			),
			'cart'            => array(
				'title'    => 'Shopping Bag',
				'template' => 'page-cart.php',
			),
			'checkout'        => array(
				'title'    => 'Atelier Checkout',
				'template' => 'page-checkout.php',
			),
			'wishlist'        => array(
				'title'    => 'Saved Wishlist',
				'template' => 'page-wishlist.php',
			),
			'about'           => array(
				'title'    => 'About the Maison',
				'template' => 'page-about.php',
			),
			'contact'         => array(
				'title'    => 'Contact Client Concierge',
				'template' => 'page-contact.php',
			),
			'faq'             => array(
				'title'    => 'FAQ & Policies',
				'template' => 'page-faq.php',
			),
			'login'           => array(
				'title'    => 'Client Account',
				'template' => 'page-login.php',
			),
			'register'        => array(
				'title'    => 'Create Client Account',
				'template' => 'page-register.php',
			),
		);

		foreach ( $pages as $slug => $data ) {
			$existing = get_page_by_path( $slug );
			if ( ! $existing ) {
				$page_id = wp_insert_post(
					array(
						'post_title'   => $data['title'],
						'post_name'    => $slug,
						'post_status'  => 'publish',
						'post_type'    => 'page',
						'post_content' => '',
					)
				);
				if ( $page_id && ! is_wp_error( $page_id ) ) {
					update_post_meta( $page_id, '_wp_page_template', $data['template'] );
				}
			} else {
				update_post_meta( $existing->ID, '_wp_page_template', $data['template'] );
			}
		}

		update_option( 'vibestore_pages_created_v1', 1 );
		flush_rewrite_rules( false );
	}

	if ( ! get_option( 'vibestore_products_seeded_v1' ) ) {
		$existing_products = get_posts(
			array(
				'post_type'      => 'vibe_product',
				'post_status'    => 'any',
				'posts_per_page' => 1,
			)
		);

		if ( empty( $existing_products ) ) {
			$default_catalog = vibestore_get_default_catalog();
			foreach ( $default_catalog as $idx => $item ) {
				$post_id = wp_insert_post(
					array(
						'post_title'   => $item['name'],
						'post_name'    => $item['slug'],
						'post_excerpt' => $item['shortDescription'],
						'post_content' => $item['description'],
						'post_status'  => 'publish',
						'post_type'    => 'vibe_product',
						'menu_order'   => $idx + 1,
					)
				);

				if ( $post_id && ! is_wp_error( $post_id ) ) {
					update_post_meta( $post_id, '_vibe_sku', $item['id'] );
					update_post_meta( $post_id, '_vibe_category', $item['category'] );
					update_post_meta( $post_id, '_vibe_price', $item['price'] );
					update_post_meta( $post_id, '_vibe_original_price', ! empty( $item['originalPrice'] ) ? $item['originalPrice'] : '' );
					update_post_meta( $post_id, '_vibe_rating', $item['rating'] );
					update_post_meta( $post_id, '_vibe_reviews_count', $item['reviewsCount'] );
					update_post_meta( $post_id, '_vibe_badge', $item['badge'] );
					update_post_meta( $post_id, '_vibe_image_1', isset( $item['images'][0] ) ? $item['images'][0] : '' );
					update_post_meta( $post_id, '_vibe_image_2', isset( $item['images'][1] ) ? $item['images'][1] : '' );
					update_post_meta( $post_id, '_vibe_sizes_csv', implode( ', ', $item['sizes'] ) );
					update_post_meta( $post_id, '_vibe_colors_json', wp_json_encode( $item['colors'] ) );
					update_post_meta( $post_id, '_vibe_featured', $item['featured'] ? '1' : '0' );
					update_post_meta( $post_id, '_vibe_trending', $item['trending'] ? '1' : '0' );
					update_post_meta( $post_id, '_vibe_bestseller', $item['bestSeller'] ? '1' : '0' );
					update_post_meta( $post_id, '_vibe_new_arrival', $item['newArrival'] ? '1' : '0' );
				}
			}
		}

		update_option( 'vibestore_products_seeded_v1', 1 );
	}

	// Auto-seed WooCommerce Shipping Zones (Pakistan Free Shipping + International Paid Zones)
	if ( ! get_option( 'vibestore_wc_shipping_zones_seeded_v1' ) && class_exists( 'WC_Shipping_Zone' ) && class_exists( 'WC_Shipping_Zones' ) ) {
		$existing_zones = WC_Shipping_Zones::get_zones();
		if ( empty( $existing_zones ) ) {
			// 1. Pakistan Zone -> Free Shipping
			$pk_zone = new WC_Shipping_Zone();
			$pk_zone->set_zone_name( 'Pakistan (Domestic Free Shipping)' );
			$pk_zone->set_zone_order( 1 );
			$pk_zone->add_location( 'PK', 'country' );
			$pk_zone->save();
			$pk_zone->add_shipping_method( 'free_shipping' );

			// 2. Gulf & Middle East Zone -> Flat Rate $15
			$me_zone = new WC_Shipping_Zone();
			$me_zone->set_zone_name( 'Gulf & Middle East (UAE, Saudi Arabia, Qatar)' );
			$me_zone->set_zone_order( 2 );
			$me_zone->add_location( 'AE', 'country' );
			$me_zone->add_location( 'SA', 'country' );
			$me_zone->add_location( 'QA', 'country' );
			$me_zone->save();
			$me_instance_id = $me_zone->add_shipping_method( 'flat_rate' );
			if ( $me_instance_id ) {
				update_option( 'woocommerce_flat_rate_' . $me_instance_id . '_settings', array(
					'title'      => 'DHL International Standard (Gulf)',
					'tax_status' => 'none',
					'cost'       => '15',
				) );
			}

			// 3. Europe & UK Zone -> Flat Rate $25
			$eu_zone = new WC_Shipping_Zone();
			$eu_zone->set_zone_name( 'Europe & United Kingdom' );
			$eu_zone->set_zone_order( 3 );
			foreach ( array( 'GB', 'FR', 'IT', 'DE', 'CH', 'TR' ) as $eu_code ) {
				$eu_zone->add_location( $eu_code, 'country' );
			}
			$eu_zone->save();
			$eu_instance_id = $eu_zone->add_shipping_method( 'flat_rate' );
			if ( $eu_instance_id ) {
				update_option( 'woocommerce_flat_rate_' . $eu_instance_id . '_settings', array(
					'title'      => 'DHL Euro & UK International',
					'tax_status' => 'none',
					'cost'       => '25',
				) );
			}

			// 4. North America & Asia-Pacific Zone -> Flat Rate $30
			$na_zone = new WC_Shipping_Zone();
			$na_zone->set_zone_name( 'North America & Asia-Pacific (US, CA, AU, JP)' );
			$na_zone->set_zone_order( 4 );
			foreach ( array( 'US', 'CA', 'AU', 'JP' ) as $na_code ) {
				$na_zone->add_location( $na_code, 'country' );
			}
			$na_zone->save();
			$na_instance_id = $na_zone->add_shipping_method( 'flat_rate' );
			if ( $na_instance_id ) {
				update_option( 'woocommerce_flat_rate_' . $na_instance_id . '_settings', array(
					'title'      => 'DHL Global Express International',
					'tax_status' => 'none',
					'cost'       => '30',
				) );
			}
		}
		update_option( 'vibestore_wc_shipping_zones_seeded_v1', 1 );
	}
}
add_action( 'init', 'vibestore_ensure_pages_and_products', 20 );
add_action( 'after_switch_theme', 'vibestore_ensure_pages_and_products' );

/**
 * 7. Seamless Route Resolution for Clean Slugs & Legacy .html Links
 * Ensures /shop, /shop.html, /product-details, /cart, etc. always load the right template without 404.
 */
function vibestore_virtual_template_routing( $template ) {
	if ( is_singular( array( 'product', 'vibe_product' ) ) ) {
		$pdp = VIBESTORE_DIR . '/page-product-details.php';
		if ( file_exists( $pdp ) ) {
			return $pdp;
		}
	}

	if ( ( function_exists( 'is_shop' ) && is_shop() ) || ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) || is_post_type_archive( 'product' ) ) {
		$shop_tpl = VIBESTORE_DIR . '/page-shop.php';
		if ( file_exists( $shop_tpl ) ) {
			return $shop_tpl;
		}
	}

	if ( function_exists( 'is_cart' ) && is_cart() ) {
		$cart_tpl = VIBESTORE_DIR . '/page-cart.php';
		if ( file_exists( $cart_tpl ) ) {
			return $cart_tpl;
		}
	}

	if ( function_exists( 'is_checkout' ) && is_checkout() ) {
		$checkout_tpl = VIBESTORE_DIR . '/page-checkout.php';
		if ( file_exists( $checkout_tpl ) ) {
			return $checkout_tpl;
		}
	}

	if ( function_exists( 'is_account_page' ) && is_account_page() ) {
		$login_tpl = VIBESTORE_DIR . '/page-login.php';
		if ( file_exists( $login_tpl ) ) {
			return $login_tpl;
		}
	}

	$req       = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	$path      = trim( (string) wp_parse_url( $req, PHP_URL_PATH ), '/' );
	$base_slug = preg_replace( '/\.html$/i', '', basename( $path ) );

	$route_map = array(
		'index'           => 'front-page.php',
		'shop'            => 'page-shop.php',
		'product-details' => 'page-product-details.php',
		'cart'            => 'page-cart.php',
		'checkout'        => 'page-checkout.php',
		'wishlist'        => 'page-wishlist.php',
		'about'           => 'page-about.php',
		'contact'         => 'page-contact.php',
		'faq'             => 'page-faq.php',
		'login'           => 'page-login.php',
		'register'        => 'page-register.php',
	);

	if ( isset( $route_map[ $base_slug ] ) ) {
		$candidate = VIBESTORE_DIR . '/' . $route_map[ $base_slug ];
		if ( file_exists( $candidate ) ) {
			global $wp_query;
			if ( $wp_query ) {
				$wp_query->is_404 = false;
			}
			status_header( 200 );
			return $candidate;
		}
	}

	return $template;
}
add_filter( 'template_include', 'vibestore_virtual_template_routing', 9999 );

/**
 * Dynamic Document Title for Virtual Routes
 */
function vibestore_document_title_parts( $title ) {
	$route  = vibestore_current_route();
	$titles = array(
		'home'            => 'VIBE STORE | Modern Luxury Minimal Essentials',
		'shop'            => 'Shop Collection | VIBE STORE — Modern Luxury Minimal Essentials',
		'product-details' => 'Product Details | VIBE STORE — Modern Luxury Minimal Essentials',
		'cart'            => 'Shopping Bag | VIBE STORE — Modern Luxury Minimal Essentials',
		'checkout'        => 'Encrypted Atelier Checkout | VIBE STORE',
		'wishlist'        => 'Saved Wishlist | VIBE STORE — Modern Luxury Minimal Essentials',
		'about'           => 'About the Maison | VIBE STORE — Modern Luxury Minimal Essentials',
		'contact'         => 'Contact Client Concierge | VIBE STORE — Modern Luxury Minimal Essentials',
		'faq'             => 'FAQ, Shipping & Returns, Privacy & Terms | VIBE STORE',
		'login'           => 'Client Account & Order History | VIBE STORE',
		'register'        => 'Create Client Account | VIBE STORE — Modern Luxury Minimal Essentials',
	);

	if ( isset( $titles[ $route ] ) ) {
		$title['title'] = $titles[ $route ];
		unset( $title['site'] );
		unset( $title['tagline'] );
	}
	return $title;
}
add_filter( 'document_title_parts', 'vibestore_document_title_parts' );

/**
 * 8. Sync Storefront Checkout Orders into WooCommerce Orders (WP Admin -> WooCommerce -> Orders)
 */
function vibestore_ajax_create_wc_order() {
	if ( ! function_exists( 'wc_create_order' ) ) {
		wp_send_json_error( array( 'message' => 'WooCommerce not active' ) );
	}

	$raw_body = file_get_contents( 'php://input' );
	$payload  = json_decode( (string) $raw_body, true );
	if ( empty( $payload ) || ! is_array( $payload ) ) {
		wp_send_json_error( array( 'message' => 'Invalid order payload' ) );
	}

	try {
		$order = wc_create_order();
		if ( is_wp_error( $order ) ) {
			wp_send_json_error( array( 'message' => $order->get_error_message() ) );
		}

		$first_name = sanitize_text_field( isset( $payload['firstName'] ) ? $payload['firstName'] : 'Client' );
		$last_name  = sanitize_text_field( isset( $payload['lastName'] ) ? $payload['lastName'] : '' );
		$email      = sanitize_email( isset( $payload['email'] ) ? $payload['email'] : '' );
		$phone      = sanitize_text_field( isset( $payload['phone'] ) ? $payload['phone'] : '' );
		$address_1  = sanitize_text_field( isset( $payload['address'] ) ? $payload['address'] : '' );
		$city       = sanitize_text_field( isset( $payload['city'] ) ? $payload['city'] : '' );
		$postcode   = sanitize_text_field( isset( $payload['postal'] ) ? $payload['postal'] : '' );
		$country    = sanitize_text_field( isset( $payload['country'] ) ? $payload['country'] : 'PK' );

		$address_args = array(
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'email'      => $email,
			'phone'      => $phone,
			'address_1'  => $address_1,
			'city'       => $city,
			'postcode'   => $postcode,
			'country'    => $country,
		);

		$order->set_address( $address_args, 'billing' );
		$order->set_address( $address_args, 'shipping' );

		$items = isset( $payload['items'] ) && is_array( $payload['items'] ) ? $payload['items'] : array();
		foreach ( $items as $item_data ) {
			$qty       = max( 1, (int) ( isset( $item_data['quantity'] ) ? $item_data['quantity'] : 1 ) );
			$unit      = (float) ( isset( $item_data['price'] ) ? $item_data['price'] : 0 );
			$wc_id     = ! empty( $item_data['wcId'] ) ? (int) $item_data['wcId'] : 0;
			$prod_id   = isset( $item_data['productId'] ) ? (string) $item_data['productId'] : '';
			$item_name = sanitize_text_field( isset( $item_data['name'] ) ? $item_data['name'] : 'Atelier Piece' );
			$size      = sanitize_text_field( isset( $item_data['size'] ) ? $item_data['size'] : '' );
			$color     = sanitize_text_field( isset( $item_data['color'] ) ? $item_data['color'] : '' );

			if ( ! $wc_id && 0 === strpos( $prod_id, 'wc-' ) ) {
				$wc_id = (int) substr( $prod_id, 3 );
			}

			$wc_prod = $wc_id ? wc_get_product( $wc_id ) : null;
			if ( $wc_prod ) {
				$item_id = $order->add_product(
					$wc_prod,
					$qty,
					array(
						'subtotal' => $unit * $qty,
						'total'    => $unit * $qty,
					)
				);
			} elseif ( class_exists( 'WC_Order_Item_Product' ) ) {
				$line_item = new WC_Order_Item_Product();
				$line_item->set_name( $item_name );
				$line_item->set_quantity( $qty );
				$line_item->set_subtotal( $unit * $qty );
				$line_item->set_total( $unit * $qty );
				$order->add_item( $line_item );
				$item_id = $line_item->get_id();
			} else {
				$item_id = 0;
			}

			if ( $item_id ) {
				if ( $size ) {
					wc_add_order_item_meta( $item_id, 'Size', $size, true );
				}
				if ( $color ) {
					wc_add_order_item_meta( $item_id, 'Color / Variation', $color, true );
				}
			}
		}

		// Add Shipping Line Item (Free Domestic Shipping, Standard International, or Express Courier)
		$shipping_cost  = isset( $payload['shippingCost'] ) ? (float) $payload['shippingCost'] : 0.0;
		$shipping_title = ! empty( $payload['shippingTitle'] ) ? sanitize_text_field( $payload['shippingTitle'] ) : ( $shipping_cost <= 0 ? 'Free Shipping (Domestic)' : 'DHL Express' );
		if ( class_exists( 'WC_Order_Item_Shipping' ) ) {
			$ship_item = new WC_Order_Item_Shipping();
			$ship_item->set_method_title( $shipping_title );
			$ship_item->set_method_id( $shipping_cost <= 0 ? 'free_shipping' : 'flat_rate' );
			$ship_item->set_total( $shipping_cost );
			$order->add_item( $ship_item );
		}

		$payment_title = sanitize_text_field( isset( $payload['paymentMethod'] ) ? $payload['paymentMethod'] : 'Card' );
		$order->set_payment_method_title( $payment_title );

		$total = isset( $payload['total'] ) ? (float) $payload['total'] : 0.0;
		$order->set_total( $total );
		$order->update_status( 'processing', __( 'Order placed via Vibe Store Atelier Checkout.', 'vibestore' ) );
		$order->save();

		wp_send_json_success(
			array(
				'wcOrderId'     => $order->get_id(),
				'wcOrderNumber' => 'VB-ORD-' . $order->get_order_number(),
			)
		);
	} catch ( Exception $e ) {
		wp_send_json_error( array( 'message' => $e->getMessage() ) );
	}
}
add_action( 'wp_ajax_vibestore_create_wc_order', 'vibestore_ajax_create_wc_order' );
add_action( 'wp_ajax_nopriv_vibestore_create_wc_order', 'vibestore_ajax_create_wc_order' );
