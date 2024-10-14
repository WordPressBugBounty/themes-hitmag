<?php

function hitmag_kirki_config() {
	$args = array(
        'url_path'       => get_template_directory_uri() . '/inc/kirki/',
        'disable_loader' => true
    );
	return $args;
}
add_filter( 'kirki/config', 'hitmag_kirki_config' );