
<?php

/*
Plugin Name: Inmobiliaria Plugin
Plugin URI:  
Description: Plugin para gestionar inmuebles y mostrar listados en WordPress.
Version: 1.0
Author: the Panther Soft (Maria Lujan Vaira)
Author URI: https://thepanthersoft.com/
*/



function ajax_listado_inmuebles() {
    $condicion = isset($_POST['condicion']) ? sanitize_text_field($_POST['condicion']) : '';
    $tipo = isset($_POST['tipo']) ? sanitize_text_field($_POST['tipo']) : '';
    $provincia = isset($_POST['provincia']) ? sanitize_text_field($_POST['provincia']) : '';
    $departamento = isset($_POST['departamento']) ? sanitize_text_field($_POST['departamento']) : '';
    $precio_desde = isset($_POST['precio_desde']) ? intval($_POST['precio_desde']) : '';
    $precio_hasta = isset($_POST['precio_hasta']) ? intval($_POST['precio_hasta']) : '';

    $meta_query = ['relation' => 'AND'];

    if (!empty($condicion)) {
        $meta_query[] = ['key' => '_property_condicion', 'value' => $condicion, 'compare' => '='];
    }
    if (!empty($tipo)) {
        $meta_query[] = ['key' => '_property_tipo', 'value' => $tipo, 'compare' => '='];
    }
    if (!empty($provincia)) {
        $meta_query[] = ['key' => '_inmueble_provincia', 'value' => $provincia, 'compare' => '='];
    }
    if (!empty($departamento)) {
        $meta_query[] = ['key' => '_inmueble_departamento', 'value' => $departamento, 'compare' => '='];
    }
    if (!empty($precio_desde)) {
        $meta_query[] = ['key' => '_property_precio_usd', 'value' => $precio_desde, 'type' => 'NUMERIC', 'compare' => '>='];
    }
    if (!empty($precio_hasta)) {
        $meta_query[] = ['key' => '_property_precio_usd', 'value' => $precio_hasta, 'type' => 'NUMERIC', 'compare' => '<='];
    }

    $query = new WP_Query([
        'post_type' => 'inmueble',
        'posts_per_page' => 8,
        'meta_query' => $meta_query,
    ]);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo render_inmueble_card(get_the_ID()); // Usamos la misma función para renderizar las tarjetas
        }
    } else {
        echo '<p>No se encontraron inmuebles con estos filtros.</p>';
    }
    wp_reset_postdata();

    wp_send_json(['html' => ob_get_clean()]);
}
add_action('wp_ajax_listado_inmuebles', 'ajax_listado_inmuebles');
add_action('wp_ajax_nopriv_listado_inmuebles', 'ajax_listado_inmuebles');
