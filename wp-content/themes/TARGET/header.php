<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php wp_title('', true, 'right'); ?></title>
	<?php wp_head(); ?>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="<?= get_template_directory_uri(); ?>/style.css">
<head>
<body>
	<div class="container">
		<nav>
			<ul class="nav-primary">
				<li>
					<a href="<?= get_bloginfo('url'); ?>"<?= is_home() ? ' class="current"' : '' ?>>
						Home
					</a>
				</li>
			
					<a href="<?= get_permalink(page_recipes()); ?>"<?= is_recipes() ? ' class="current"' : '' ?>>
						<?= get_the_title(page_recipes()); ?>
					</a>
				</li>
			</ul>
		</nav>
