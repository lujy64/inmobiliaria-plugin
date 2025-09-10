<?php
/*
Plugin Name: Inmobiliaria Plugin
Plugin URI:  
Description: Plugin para gestionar inmuebles y mostrar listados en WordPress.
Version: 1.0
Author: the Panther Soft (Maria Lujan Vaira)
Author URI: https://thepanthersoft.com/
*/

// Crear el Custom Post Type para Inmuebles
function inmobiliaria_register_post_type() {
    $labels = array(
        'name' => 'Inmuebles',
        'singular_name' => 'Inmueble',
        'add_new' => 'Agregar Nuevo',
        'add_new_item' => 'Agregar Nuevo Inmueble',
        'edit_item' => 'Editar Inmueble',
        'new_item' => 'Nuevo Inmueble',
        'view_item' => 'Ver Inmueble',
        'search_items' => 'Buscar Inmuebles',
        'not_found' => 'No se encontraron inmuebles',
        'not_found_in_trash' => 'No hay inmuebles en la papelera',
    );

    $args = array(
        'labels' => $labels,
        'public' => true, // Hacer público el CPT
        'has_archive' => true, // Habilitar archivo de inmuebles (por ejemplo, /inmuebles/)
        'rewrite' => array('slug' => 'inmuebles', 'with_front' => true), // Configuración del slug
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
    );

    register_post_type('inmueble', $args);
}
add_action('init', 'inmobiliaria_register_post_type');
?>
