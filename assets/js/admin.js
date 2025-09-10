/*
Plugin Name: Inmobiliaria Plugin
Plugin URI:  
Description: Plugin para gestionar inmuebles y mostrar listados en WordPress.
Version: 1.0
Author: the Panther Soft (Maria Lujan Vaira)
Author URI: https://thepanthersoft.com/
*/

jQuery(document).ready(function($) {
    $('.toggle-visibility').on('change', function() {
        const postId = $(this).data('id');
        const visible = $(this).is(':checked');

        $.post(ajaxurl, {
            action: 'toggle_inmueble_visibility',
            post_id: postId,
            visible: visible
        });
    });
});
