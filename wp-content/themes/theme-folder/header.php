<!DOCTYPE html>
<html lang="<?php language_attributes() ?>">


	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport"
			content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="pingback"
			href="<?php bloginfo('pingback_url'); ?>" />
		<?php wp_head() ?>


	</head>

	<body <?php body_class(); ?>>

		<?php get_template_part('template-parts/menu'); ?>
