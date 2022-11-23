<?php

if (!defined('WP_DEBUG')) {
	die('Direct access forbidden.');
}

add_action('wp_enqueue_scripts', function () {
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
});

?>

<!DOCTYPE html>
<html>

<head>
	<title>The Complete Guide To The Settings API | Sandbox Theme</title>
</head>


<body>

	<div id="header">
		<h1>Sandbox Header</h1>
	</div><!-- /#header -->

	<div id="content">
		<p>This is theme content.</p>
	</div><!-- /#content -->

	<div id="footer">
		<p>&copy;
			<?php echo date('Y'); ?> All Rights Reserved.
		</p>
	</div><!-- /#footer -->

</body>

</html>

<?php

/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */

/**
 * Initializes the theme options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
add_action('admin_init', 'sandbox_initialize_theme_options');
function sandbox_initialize_theme_options()
{

	// First, we register a section. This is necessary since all future options must belong to one.
	add_settings_section(
		'general_settings_section',
		// ID used to identify this section and with which to register options
		'Sandbox Options',
		// Title to be displayed on the administration page
		'sandbox_general_options_callback',
		// Callback used to render the description of the section
		'general' // Page on which to add this section of options

	);

	// Next, we will introduce the fields for toggling the visibility of content elements.
	add_settings_field(
		'show_header',
		// ID used to identify the field throughout the theme
		'Header',
		// The label to the left of the option interface element
		'sandbox_toggle_header_callback',
		// The name of the function responsible for rendering the option interface
		'general',
		// The page on which this option will be displayed
		'general_settings_section',
		// The name of the section to which this field belongs
		array(
			// The array of arguments to pass to the callback. In this case,just a description.
			'Activate this setting to display the header.'
		)
	);

	add_settings_field(
		'show_content',
		'Content',
		'sandbox_toggle_content_callback',
		'general',
		'general_settings_section',
		array(
			'Activate this setting to display the content.'
		)
	);

	add_settings_field(
		'show_footer',
		'Footer',
		'sandbox_toggle_footer_callback',
		'general',
		'general_settings_section',
		array(
			'Activate this setting to display the footer.'
		)
	);

	// Finally, we register the fields with WordPress
	register_setting(
		'general',
		'show_header'
	);

	register_setting(
		'general',
		'show_content'
	);

	register_setting(
		'general',
		'show_footer'
	);

} // end sandbox_initialize_theme_options

/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */

/**
 * This function provides a simple description for the General Options page. 
 *
 * It is called from the 'sandbox_initialize_theme_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function sandbox_general_options_callback()
{
	echo '<p>Select which areas of content you wish to display.</p>';

} // end sandbox_general_options_callback

/**
 * This function renders the interface elements for toggling the visibility of the header element.
 * 
 * It accepts an array of arguments and expects the first element in the array to be the description
 * to be displayed next to the checkbox.
 */
function sandbox_toggle_header_callback($args)
{
	// Note the ID and the name attribute of the element should match that of the ID in the call to add_settings_field
	$html = '<input type="checkbox" id="show_header" name="show_header" value="1" ' . checked(1, get_option('show_header'), false) . '/>';

	// Here, we will take the first argument of the array and add it to a label next to the checkbox
	$html .= '<label for="show_header">' . $args[0] . '</label>';

	echo $html;

} // end sandbox_toggle_header_callback


function sandbox_toggle_content_callback($args)
{

	$html = '<input type="checkbox" id="show_content" name="show_content" value="1" ' . checked(1, get_option('show_content'), false) . '/>';
	$html .= '<label for="show_content"> ' . $args[0] . '</label>';

	echo $html;

} // end sandbox_toggle_content_callback

function sandbox_toggle_footer_callback($args)
{

	$html = '<input type="checkbox" id="show_footer" name="show_footer" value="1" ' . checked(1, get_option('show_footer'), false) . '/>';
	$html .= '<label for="show_footer"> ' . $args[0] . '</label>';

	echo $html;

} // end sandbox_toggle_footer_callback


if(get_option('show_header')) { ?>
	<div id="header">
	<h1>Sandbox Header</h1>
	</div><!-- /#header -->
	<?php } // end if ?>

	<?php if(get_option('show_content')) { ?>
<div id="content">
<p>This is theme content.</p>
</div><!-- /#content -->
<?php } // end if ?>

<?php if(get_option('show_footer')) { ?>
<div id="footer">
<p>&copy; <?php echo date('Y'); ?> All Rights Reserved.</p>
</div><!-- /#footer -->
<?php } // end if ?>
