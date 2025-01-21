<?php

 /* Add theme style to Theme */
function my_theme_enqueue_styles() {
    wp_register_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'parent-style' ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


/* font-awesome */
$role = get_role('editor');
$role->add_cap('edit_theme_options');


// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

  global $wp_version;
  if ( $wp_version !== '4.7.1' ) {
     return $data;
  }

  $filetype = wp_check_filetype( $filename, $mimes );

  return [
      'ext'             => $filetype['ext'],
      'type'            => $filetype['type'],
      'proper_filename' => $data['proper_filename']
  ];

}, 10, 4 );

function cc_mime_types( $mimes ){
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
  echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );


function site_block_editor_styles() {
  wp_enqueue_style( 'site-block-editor-styles', get_theme_file_uri( '/style-editor.css' ), false, '1.0', 'all' );
}
add_action( 'enqueue_block_editor_assets', 'site_block_editor_styles' );

function fire_theme_support() {
  remove_theme_support('core-block-patterns');
}
add_action('after_setup_theme', 'fire_theme_support');


/* Add js */
function add_js() {
  /* wp_enqueue_script( 'flickity-script', get_stylesheet_directory_uri() . '/assets/flickity/flickity.pkgd.min.js', array('jquery'), '1.0.0', true ); */
  /* wp_enqueue_script( 'isotope-script', get_stylesheet_directory_uri() . '/assets/isotope/isotope.pkgd.min.js', array('jquery'), '1.0.0', true ); */
  wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/scripts.js', array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'add_js' );

/* Add CSS */
function add_css() {
  /* wp_enqueue_style( 'style', get_stylesheet_directory_uri().'/assets/flickity/flickity.css' ); */
  wp_enqueue_style( 'style', get_stylesheet_directory_uri().'/fonts/font-awesome.css' );
}
add_action( 'wp_enqueue_scripts', 'add_css' );
