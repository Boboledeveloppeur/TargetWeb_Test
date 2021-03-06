<?php

 
// Add excerpts to pages
// -------------------------------------------------------------
add_post_type_support( 'page', 'excerpt' );

// Add post thumbnails
// -------------------------------------------------------------
add_theme_support( 'post-thumbnails' );
add_image_size( 'thumb', 150, 150, true );
add_image_size( 'single', 300, 300, true ); 

// Output cleaner, linked post thumbnails
// -------------------------------------------------------------
function my_the_post_thumbnail($post_id, $linked = 1, $type = 'thumbnail') {
	$attr = array( 'title' => '', 'alt' => get_the_title($post_id), 'class' => 'entry-thumb' );
	if($linked) {
		echo '<a href="'.get_permalink($post_id).'" title="'.get_the_title($post_id).'" rel="bookmark">'.get_the_post_thumbnail($post_id, $type, $attr).'</a>';
	}
	else {
		echo get_the_post_thumbnail($post_id, $type, $attr);
	}
}

// Test for pagination
// -------------------------------------------------------------
function show_posts_nav() {
	global $wp_query;
	return ($wp_query->max_num_pages > 1);
}

/**
 * NAVIGATION HELPER FUNCTIONS
 *
 * These are helper theme functions used to generate navigation / section indexes more easily
 * They are used by the Products post type below (do NOT remove if you are using this post type)
 * If you are NOT using the Products post type, you may find them useful anyway! 
 * They are also used by Boon's In-section Navigation below (do NOT remove if you are using this)
 */

// Output link by post ID
// -------------------------------------------------------------
function link_by_id($post_id) {
	echo '<a href="'.get_permalink($post_id).'">'.get_the_title($post_id).'</a>';
}

// Return the root parent ID of a given post
// -------------------------------------------------------------
function get_root_parent_id($post_id = null) {
	if(!$post_id) {
		global $post;
		$post_id = $post->ID;
	}
	global $wpdb;
	$parent = $wpdb->get_var("SELECT post_parent FROM $wpdb->posts WHERE post_type='page' AND post_status='publish' AND ID = '$post_id'");
	if ($parent == 0) return $post_id;
	else return root_parent_id($parent);
}

// Return all sub pages of a given post
// -------------------------------------------------------------
function get_sub_pages($post_id, $post_type = 'page') {
	$args = array(
		'post_type' => $post_type,
		'child_of' => $post_id,
		'parent' => $post_id,
		'sort_order' => 'ASC',
		'sort_column' => 'menu_order'
	);	
	return get_pages($args);
}

// Return all root (top-level) posts of any given post type
// -------------------------------------------------------------
function get_root_pages($post_type = 'page') {
	$args = array(
		'post_type' => $post_type,
		'parent' => 0,
		'order' => 'ASC',
		'orderby' => 'menu_order',
		'numberposts' => -1
	);	
	return get_pages($args);
}

/**
 * PLUGIN - BOON'S IN-SECTION NAVIGATION
 *
 * This is a function to generate an "in this section" navigation which shows sub pages of the section you're in
 * It allows you to target any given post type (the post type MUST be hierarchical )
 * It is used by the Products post type below (do NOT remove if you are using this post type )
 * It also uses the navigation helper functions above
 * If you are NOT using the Products post type you may find this useful anyway, even just for pages!
 *
 * Call the sub navigation as follows: <?php boons_insection_subnav( 'current', 'product' ); ?>
 * Attributes: 'current' = current class for <li>'s and 'product' = post type
 */
 
// Navigation function
// -------------------------------------------------------------
function get_insection_subnav( $post_type = 'page' ) {
	global $post;
	// test for subnav
	if ( $post_type == 'page' ) {
		$sub_level_1 = get_sub_pages( get_root_parent_id( $post->ID ) );
	} else {
		$sub_level_1 = get_root_pages( $post_type );
	}
	// if pages to display
	if ( $sub_level_1 ) {
		return $sub_level_1;
	}
	else {
		return false;
	}
}

function insection_subnav( $post_type = 'page', $current_class = 'current_page_item' ) {

	// Test if current page in sub navigation
	// -------------------------------------------------------------
	function subnav_is_current( $post_id ) {
		global $post;
		return ( $post_id == $post->ID );
	}

	// Test next level in sub navigation
	// -------------------------------------------------------------
	function subnav_next_level( $post_id, $next_level ) {
		global $post;
		if ( $post->ancestors == null ) {
			$post_ancestors = array();
		}
		else {
			$post_ancestors = $post->ancestors; 
		}
		return ( $next_level && subnav_is_current( $post_id ) || in_array( $post_id, $post_ancestors ) );
	}

	// Test for subnav
	// -------------------------------------------------------------
	$sub_level_1 = get_insection_subnav( $post_type );

	// Output subnav
	// -------------------------------------------------------------
	// level 1
	if ( $sub_level_1 ) : ?>
	<ul class="nav-secondary level-1">
		<?php
		// level 1 items
		foreach ( $sub_level_1 as $level_1_page ) :
		$level_1_page_id = $level_1_page->ID;
		?>
		<li class="level-1-item<?php echo subnav_is_current( $level_1_page_id ) ? ' ' . $current_class . '' : ''; ?>">
			<?php link_by_id( $level_1_page_id ); ?>
			<?php
			// level 2
			$sub_level_2 = get_sub_pages( $level_1_page_id, $post_type );
			if ( subnav_next_level( $level_1_page_id, $sub_level_2 ) ) : ?>
			<ul class="level-2">
				<?php
				// level 2 items
				foreach ( $sub_level_2 as $level_2_page ) :
				$level_2_page_id = $level_2_page->ID;
				?>
				<li class="level-2-item<?php echo subnav_is_current( $level_2_page_id ) ? ' ' . $current_class . '' : ''; ?>">
					<?php link_by_id( $level_2_page_id ); ?>
					<?php
					// level 3
					$sub_level_3 = get_sub_pages( $level_2_page_id, $post_type );
					if ( subnav_next_level( $level_2_page_id, $sub_level_3 ) ) : ?>
					<ul class="level-3">
						<?php
						// level 3 items
						foreach ( $sub_level_3 as $level_3_page ) :
						$level_3_page_id = $level_3_page->ID;
						?>
						<li class="level-3-item<?php echo subnav_is_current( $level_3_page_id ) ? ' ' . $current_class . '' : ''; ?>">
							<?php link_by_id( $level_3_page_id ); ?>
						</li>
						<?php
						// level 3 items
						endforeach; ?>
					</ul>
					<?php
					// level 3
					endif; ?>
				</li>
				<?php
				// level 2 items
				endforeach; ?>
			</ul>
			<?php
			// level 2
			endif; ?>
		</li>
		<?php
		// level 1 items
		endforeach; ?>
	</ul>
	<?php endif; ?>
<?php
}


/**
 * BEGIN CUSTOM POST TYPE - RECIPES
 *
 * Recipes have been created as non-hierarchical and are an exact replica of posts (chronological)
 * This is a more typical implementation of a custom post type
 * The post type contains two custom taxonomies - Ingredients and Cuisines
 * Ingredients acts as tags, Cuisines act as categories
 * We ditch the archive-recipe.php page template in favour of creating our own page called Recipes
 * On the Recipes page we assign the recipes.php page template to call our custom posts 
 * Permalinks are clean and contain the Cuisine e.g. /recipes/indian/recipe-name
 * Cuisine taxonomy permalinks must contain a category base e.g. /recipes/type/indian
 * Ingredients taxonomy permalinks must contain a tag base e.g. /recipes/with/paprika
 */
 
 /**
 * FOR DEMO ONLY
 
 * This section automatially creates the Recipes page and assigns the correct template (recipes.php)
 */
$recipes_page_title = 'Recipes';
$recipes_page_permalink = 'recipes';

// Define Recipes page content
// -------------------------------------------------------------
$recipes_page_content = array(
	'post_type' => 'page',
	'post_title' => $recipes_page_title,
	'post_name' => $recipes_page_permalink,
	'post_status' => 'publish',
	'post_content' => '',
	'post_author' => 1,
);

// Check if the Recipes page exists
// -------------------------------------------------------------
$recipes_page_data = get_page_by_title($recipes_page_title);
$recipes_page_id = $recipes_page_data->ID;


// Create Recipes page if it does't exist
// -------------------------------------------------------------
if(!isset($recipes_page_data)){
	wp_insert_post($recipes_page_content);
	$recipes_page_data = get_page_by_title($recipes_page_title);
	$recipes_page_id = $recipes_page_data->ID;
	update_post_meta($recipes_page_id, '_wp_page_template','recipes.php');
}

/**
 * RECIPES HELPER FUNCTIONS
 *
 * These are theme functions used within the Recipes custom post type
 */
// Return the current taxonomy title
// -------------------------------------------------------------
function current_tax_title() {
	echo get_queried_object()->name;
}

// Return the Recipes page ID
// -------------------------------------------------------------
function page_recipes() {
	$recipes_page_data = get_page_by_title('Recipes');
	$recipes_page_id = $recipes_page_data->ID;
	return $recipes_page_id;
}

// Test if we're in the Recipes section (useful for highlighting navigation)
// -------------------------------------------------------------
function is_recipes() {
	return (is_page('recipes') || is_singular('recipe') || is_tax('recipe_ingredient') || is_tax('recipe_cuisine'));
}

 /**
 * CREATE CUSTOM POST TYPE - RECIPE
 *
 * We define the post type name in singular form (recipe)
 * Recipes are chronological and function like posts
 * Also creates the two custom taxonomies
 */
add_action('init', '_init_recipe_post_type');

function _init_recipe_post_type() {
	
	// Create taxonomy (ingredients i.e. tags)
	// -------------------------------------------------------------
	register_taxonomy(
		'recipe_ingredient',
		array( 'recipe' ),
		array(
			'labels' => array(
				'name' => __( 'Ingredients' ),
				'singular_name' => __( 'Ingredient' ),
				'search_items' => __( 'Search Ingredients' ),
				'popular_items' => __( 'Popular Ingredients' ),
				'all_items' => __( 'All Ingredients' ),
				'edit_item' => __( 'Edit Ingredient' ),
				'update_item' => __( 'Update Ingredient' ),
				'add_new_item' => __( 'Add New Ingredient' ),
				'new_item_name' => __( 'New Ingredient' ),
			),
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'hierarchical' => false,
			'query_var' => true,
			// this sets the taxonomy view URL (must have tag base i.e. /with)
			// this can be any depth e.g. food/cooking/recipes/with
			'rewrite' => array( 'slug' => 'recipes/with', 'with_front' => false ),
		)
	);
	
	// Create taxonomy (cuisines i.e. categories)
	// -------------------------------------------------------------
	register_taxonomy(
		'recipe_cuisine',
		array( 'recipe' ),
		array(
			'labels' => array(
				'name' => __( 'Cuisines' ),
				'singular_name' => __( 'Cuisine' ),
				'search_items' => __( 'Search Cuisines' ),
				'popular_items' => __( 'Popular Cuisines' ),
				'all_items' => __( 'All Cuisines' ),
				'parent_item' => __( 'Parent Cuisine' ),
				'parent_item_colon' => __( 'Parent Cuisine:' ),
				'edit_item' => __( 'Edit Cuisine' ),
				'update_item' => __( 'Update Cuisine' ),
				'add_new_item' => __( 'Add New Cuisine' ),
				'new_item_name' => __( 'New Cuisine' ),
			),
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'hierarchical' => true,
			'query_var' => true,
			// this sets the taxonomy view URL (must have category base i.e. /type)
			// this can be any depth e.g. food/cooking/recipes/type
			'rewrite' => array( 'slug' => 'recipes/type', 'with_front' => false ),
		)
	);	


	// Create post type (recipes i.e. posts)
	// -------------------------------------------------------------
	register_post_type( 'recipe',
		array(
			'capability_type' => 'post',
			'hierarchical' => false,
			'public' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'menu_position' => 30,
			'labels' => array(
				'name' => __( 'Recipes' ),
				'singular_name' => __( 'Recipe' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New Recipe' ),
				'edit' => __( 'Edit Recipe' ),
				'edit_item' => __( 'Edit Recipe' ),
				'new_item' => __( 'New Recipe' ),
				'view' => __( 'View Recipe' ),
				'view_item' => __( 'View Recipe' ),
				'search_items' => __( 'Search Recipe' ),
				'not_found' => __( 'No Recipes found' ),
				'not_found_in_trash' => __( 'No Recipes found in Trash' )
			),
			'has_archive' => true,
			'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
			'query_var' => true,
			// this sets where the Recipes section lives and contains a tag to insert the Cuisine in URL below
			// this can be any depth e.g. food/cooking/recipes/%recipe_cuisines%
			'rewrite' => array( 'slug' => 'recipes/%recipe_cuisine%', 'with_front' => false ),
		)
	);

	// Make permalinks for Recipes pretty (add Cuisine to URL)
	// -------------------------------------------------------------
	add_filter('post_type_link', 'recipe_permalink_filter_function', 1, 3);
	function recipe_permalink_filter_function( $post_link, $id = 0, $leavename = FALSE ) {
	    if ( strpos('%recipe_cuisine%', $post_link) === 'FALSE' ) {
	      return $post_link;
	    }
	    $post = get_post($id);
	    if ( !is_object($post) || $post->post_type != 'recipe' ) {
	      return $post_link;
	    }
		// this calls the term to be added to the URL
	    $terms = wp_get_object_terms($post->ID, 'recipe_cuisine');
	    if ( !$terms ) {
	      return str_replace('recipes/%recipe_cuisine%/', '', $post_link);
	    }
	    return str_replace('%recipe_cuisine%', $terms[0]->slug, $post_link);
	}

	// -------------------------------------------------------------
	// FIX - Makes permalinks work!
	// This must come at the end of your LAST custom post type
	// REMOVE after development (when everything's working!)
	// -------------------------------------------------------------
	flush_rewrite_rules(); 
	// -------------------------------------------------------------
	
}

/**
 * FIX - Make custom post type pagination work!
 *
 * Taken from http://wordpress.stackexchange.com/a/16929/9244
 * Solves issue with /page/2/ of custom post types giving a 404 error
 * remove if you're not using the Recipes post type or not paginating
 */
add_action( 'init', 'wpse16902_init' );
function wpse16902_init() {
	$GLOBALS['wp_rewrite']->use_verbose_page_rules = true;
}

add_filter( 'page_rewrite_rules', 'wpse16902_collect_page_rewrite_rules' );
function wpse16902_collect_page_rewrite_rules( $page_rewrite_rules )
{
	$GLOBALS['wpse16902_page_rewrite_rules'] = $page_rewrite_rules;
	return array();
}

add_filter( 'rewrite_rules_array', 'wspe16902_prepend_page_rewrite_rules' );
function wspe16902_prepend_page_rewrite_rules( $rewrite_rules )
{
	return $GLOBALS['wpse16902_page_rewrite_rules'] + $rewrite_rules;
}