<?php
/*
Plugin Name: Inmobiliaria Plugin
Plugin URI:  
Description: Plugin para gestionar inmuebles y mostrar listados en WordPress.
Version: 1.0
Author: the Panther Soft (Maria Lujan Vaira)
Author URI: https://thepanthersoft.com/
*/

// Seguridad: evita accesos directos al archivo.
if ( !defined('ABSPATH') ) exit;

// Incluye archivos adicionales
require_once plugin_dir_path(__FILE__) . 'includes/inmobiliaria-post-type.php';
require_once plugin_dir_path(__FILE__) . 'includes/inmobiliaria-metaboxes.php';
require_once plugin_dir_path(__FILE__) . 'includes/inmobiliaria-shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'includes/ubicaciones.php';

// Encolar scripts y estilos
function inmobiliaria_enqueue_assets() {
    wp_enqueue_style('inmobiliaria-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('inmobiliaria-script', plugin_dir_url(__FILE__) . 'assets/js/galeria.js', array('jquery'), null, true);

    wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css', [], null);
    wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'inmobiliaria_enqueue_assets');


// Ocultar campos con CSS
function ocultar_campos_inmuebles_admin() {
    global $post_type;

    if ($post_type === 'inmueble') {
        echo '<style>
            #titlediv,
            #postdivrich,
            #postcustom,
            #postimagediv {
                display: none !important;
            }
        </style>';
    }
}
add_action('admin_head', 'ocultar_campos_inmuebles_admin');



// Registrar la plantilla personalizada para el tipo de contenido "inmueble"
function inmobiliaria_register_template($template) {
    if (is_singular('inmueble')) {
        // Ruta de la plantilla personalizada
        $plugin_template = plugin_dir_path(__FILE__) . 'templates/single-inmueble.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }
    return $template;
}
add_filter('template_include', 'inmobiliaria_register_template');



// Agregar columnas personalizadas al listado de inmuebles
function inmobiliaria_custom_columns($columns) {
    // Eliminar la columna por defecto del título
    unset($columns['title']);

    // Agregar nuevas columnas
    $columns['id'] = 'ID';
    $columns['foto'] = 'Foto';
    $columns['tipo'] = 'Tipo';
    $columns['condicion'] = 'Condición';
    $columns['ubicacion'] = 'Ubicación';
    $columns['precio'] = 'Precio';
    $columns['acciones'] = 'Acciones';

    return $columns;
}
add_filter('manage_inmueble_posts_columns', 'inmobiliaria_custom_columns');




// Llenar las columnas personalizadas con datos
function inmobiliaria_custom_column_content($column, $post_id) {
    switch ($column) {

        case 'id':
            echo $post_id; // Mostrar el ID del inmueble
            break;

        case 'foto':
            $gallery = get_post_meta($post_id, '_inmueble_images', true);
            if (!empty($gallery) && is_array($gallery)) {
                $image_url = wp_get_attachment_image_url($gallery[0], 'thumbnail');
                echo '<img src="' . esc_url($image_url) . '" style="width: 50px; height: 50px; object-fit: cover;">';
            } else {
                echo 'Sin foto';
            }
            break;

        case 'tipo':
            $tipo = get_post_meta($post_id, '_property_tipo', true);
            echo esc_html($tipo ? $tipo : 'Sin tipo');
            break;

        case 'condicion':
            $condicion = get_post_meta($post_id, '_property_condicion', true);
            echo esc_html($condicion ? $condicion : 'Sin condición');
            break;

        case 'ubicacion':
            $direccion = get_post_meta($post_id, '_inmueble_direccion', true);
            $departamento = get_post_meta($post_id, '_inmueble_departamento', true);
            $provincia = get_post_meta($post_id, '_inmueble_provincia', true);
            echo esc_html($direccion . ', ' . $departamento . ', ' . $provincia);
            break;

        case 'precio':
            $precio_arg = get_post_meta($post_id, '_property_precio_pesos', true);
            $precio_usd = get_post_meta($post_id, '_property_precio_usd', true);
            $output = '';
            if (!empty($precio_arg) && $precio_arg != '0') {
                $output .= '$ ' . esc_html($precio_arg);
            }
            if (!empty($precio_usd) && $precio_usd != '0') {
                $output .= ' <br> US$ ' . esc_html($precio_usd);
            }
            echo $output ? $output : 'Sin precio';
            break;

        case 'acciones':
            echo '<a href="' . get_edit_post_link($post_id) . '">Editar</a> | ';
            echo '<a href="' . get_permalink($post_id) . '">Ver</a> | ';
            echo '<a href="' . get_delete_post_link($post_id) . '" style="color: red;">Papelera</a>';
            break;
    }
}
add_action('manage_inmueble_posts_custom_column', 'inmobiliaria_custom_column_content', 10, 2);


// Cambiar el orden de las columnas (Opcional)
function inmobiliaria_column_order($columns) {
    // Ordenar las columnas como en la segunda captura
    $new_columns = [
        'cb' => $columns['cb'], // Checkbox para selección en lote
        'id' => 'ID',
        'foto' => 'Foto',
        'tipo' => 'Tipo',
        'condicion' => 'Condición',
        'ubicacion' => 'Ubicación',
        'precio' => 'Precio',
        'acciones' => 'Acciones',
    ];

    return $new_columns;
}
add_filter('manage_edit-inmueble_sortable_columns', 'inmobiliaria_column_order');


// Ocultar la columna "Fecha" en el listado de inmuebles del administrador
function ocultar_columna_fecha_inmuebles() {
    $screen = get_current_screen();

    // Verificar que estamos en el listado de inmuebles
    if ($screen->post_type === 'inmueble') {
        echo '<style>
            th#date, td.date, th#estado, th#visibilidad, th.column-date, li.trash {
                display: none;
            }
        </style>';
    }
}
add_action('admin_head', 'ocultar_columna_fecha_inmuebles');



// NUEVOOOO
// Modificar el slug dinámicamente al guardar o actualizar un inmueble
function modificar_slug_inmueble($post_id) {
    // Asegurarse de que el post sea del tipo "inmueble"
    if (get_post_type($post_id) !== 'inmueble') {
        return;
    }

    // Evitar bucles infinitos
    remove_action('save_post', 'modificar_slug_inmueble');

    // Obtener los metadatos necesarios
    $condicion = get_post_meta($post_id, '_property_condicion', true);
    $tipo = get_post_meta($post_id, '_property_tipo', true);
    $titulo_dinamico = get_post_meta($post_id, '_inmueble_titulo', true);
    $titulo_parte_2 = isset($titulo_dinamico['parte_2']) ? sanitize_title($titulo_dinamico['parte_2']) : '';

    // Validar que los datos necesarios estén disponibles
    if (empty($condicion) || empty($tipo) || empty($titulo_parte_2)) {
        return;
    }

    // Formar el nuevo slug
    $nuevo_slug = sanitize_title("$condicion-$tipo-$titulo_parte_2");

    // Actualizar el slug del post
    wp_update_post([
        'ID' => $post_id,
        'post_name' => $nuevo_slug,
    ]);

    // Restaurar el hook para futuras ejecuciones
    add_action('save_post', 'modificar_slug_inmueble');
}
add_action('save_post', 'modificar_slug_inmueble');

function flush_rewrite_rules_inmueble() {
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'flush_rewrite_rules_inmueble');
register_deactivation_hook(__FILE__, 'flush_rewrite_rules');



// Agregar un widget al panel principal de WordPress
function agregar_widget_panel_inmobiliario_moderno() {
    wp_add_dashboard_widget(
        'widget_panel_inmobiliario_moderno', // ID único del widget
        'Panel Inmobiliario Moderno', // Título del widget
        'mostrar_widget_panel_inmobiliario_moderno' // Función para mostrar el contenido
    );
}
add_action('wp_dashboard_setup', 'agregar_widget_panel_inmobiliario_moderno');

// Función para mostrar el contenido del widget
function mostrar_widget_panel_inmobiliario_moderno() {
    ?>
    <style>
        .modern-dashboard-container {
            display: flex;
            gap: 30px;
            justify-content: center;
        }
        .modern-dashboard-card {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px;
            border-radius: 25px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            text-align: center;
            width: 250px;
            height: 350px;
            background: linear-gradient(145deg, rgba(0, 0, 0, 0.8), rgba(50, 50, 50, 0.9));
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.6), inset 0px 0px 10px rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
        }
        .modern-dashboard-card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.9), inset 0px 0px 15px rgba(255, 255, 255, 0.3);
        }
        .modern-dashboard-card img {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
            filter: drop-shadow(0px 4px 6px rgba(0, 0, 0, 0.5));
        }
        .modern-dashboard-card span {
            font-size: 18px;
            margin-top: 10px;
        }
        #postbox-container-1 {
            width: -webkit-fill-available!important;
        }
        div#widget_panel_inmobiliario_moderno {
            width: -webkit-fill-available!important;
        }
        .galeria-card, .ver-inmueble-card, .crear-inmueble-card {
            border: 1px solid #D5D5D5;
            background: #f0f0f1;
        }
        .galeria-card {
            color: #eab308!important;
            border: #eab308 solid 2px;
        }
        .ver-inmueble-card{
            color: #135e96!important;
            border: #135e96 solid 2px;
        }
        .crear-inmueble-card{
            color: #059669!important;
            border: #059669 solid 2px;
        }
        .modern-dashboard-container {
            padding: 160px;
        }
        #postbox-container-2, #postbox-container-3, #postbox-container-4 {
            display: none;
        }
    </style>
    <div class="modern-dashboard-container">
        <a href="/wp-admin/upload.php" class="modern-dashboard-card galeria-card">
            <img src="/wp-content/uploads/2025/01/CarbonMediaLibraryFilled.png" alt="Galería">
            <span>Explora nuestras imágenes</span>
        </a>
        <a href="/wp-admin/edit.php?post_type=inmueble" class="modern-dashboard-card ver-inmueble-card">
            <img src="/wp-content/uploads/2025/01/MaterialSymbolsListAltCheckOutlineSharp.png" alt="Ver Inmueble">
            <span>Descubre los detalles de tu futuro hogar</span>
        </a>
        <a href="/wp-admin/post-new.php?post_type=inmueble" class="modern-dashboard-card crear-inmueble-card">
            <img src="/wp-content/uploads/2025/01/SolarGalleryAddLineDuotone.png" alt="Crear Inmueble">
            <span>Añade una nueva propiedad</span>
        </a>
    </div>
    <?php
}



/*function ocultar_inmuebles_no_coincidentes() {
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Obtener parámetros de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const condicion = urlParams.get("condicion") ? urlParams.get("condicion").toLowerCase() : "";
        const tipo = urlParams.get("tipo") ? urlParams.get("tipo").toLowerCase() : "";
        const provincia = urlParams.get("provincia") ? urlParams.get("provincia").toLowerCase() : "";
        const departamento = urlParams.get("departamento") ? urlParams.get("departamento").toLowerCase() : "";

        // Seleccionar todas las tarjetas de inmuebles
        document.querySelectorAll(".inmueble-card").forEach(function (card) {
            let matches = true;

            // Verificar cada filtro
            if (condicion && !card.innerText.toLowerCase().includes(condicion)) matches = false;
            if (tipo && !card.innerText.toLowerCase().includes(tipo)) matches = false;
            if (provincia && !card.innerText.toLowerCase().includes(provincia)) matches = false;
            if (departamento && !card.innerText.toLowerCase().includes(departamento)) matches = false;

            // Ocultar si no coincide
            if (!matches) {
                card.style.display = "none";
            }
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'ocultar_inmuebles_no_coincidentes');


function forzar_shortcode_en_inmueble() {
    if (is_post_type_archive('inmueble') || is_page('inmueble')) {
        global $wp_query;
        $wp_query->is_home = false; // Evita que WordPress lo trate como blog
        $wp_query->is_archive = false;
        $wp_query->is_404 = false;

        // Generar los parámetros dinámicos desde GET
        $shortcode = '[listado_inmuebles';
        if (!empty($_GET['condicion'])) $shortcode .= ' condicion="' . esc_attr($_GET['condicion']) . '"';
        if (!empty($_GET['tipo'])) $shortcode .= ' tipo="' . esc_attr($_GET['tipo']) . '"';
        if (!empty($_GET['provincia'])) $shortcode .= ' provincia="' . esc_attr($_GET['provincia']) . '"';
        if (!empty($_GET['departamento'])) $shortcode .= ' departamento="' . esc_attr($_GET['departamento']) . '"';
        if (!empty($_GET['precio_desde'])) $shortcode .= ' precio_desde="' . esc_attr($_GET['precio_desde']) . '"';
        if (!empty($_GET['precio_hasta'])) $shortcode .= ' precio_hasta="' . esc_attr($_GET['precio_hasta']) . '"';
        $shortcode .= ' limit="8"]';

        // Imprimir solo el shortcode, sin el blog
        echo do_shortcode($shortcode);
    }
}
add_action('template_redirect', 'forzar_shortcode_en_inmueble');*/

function cargar_scripts_plugin() {
    wp_enqueue_script('mi-plugin-js', plugin_dir_url(__FILE__) . 'assets/js/script.js', ['jquery'], '1.0.0', true);
    wp_localize_script('mi-plugin-js', 'ajaxurl', ['url' => admin_url('admin-ajax.php')]); // Enviar URL AJAX a JavaScript
}
add_action('wp_enqueue_scripts', 'cargar_scripts_plugin');



// Cambios 1/6

// 1. Agregar columna de visibilidad al listado de inmuebles
add_filter('manage_edit-inmueble_columns', 'agregar_columna_visibilidad');
function agregar_columna_visibilidad($columns) {
    $new_columns = [];
    $new_columns['mostrar'] = 'Visible';
    return array_slice($columns, 0, 1, true) + $new_columns + array_slice($columns, 1, null, true);
}

// 2. Mostrar checkbox en la nueva columna
add_action('manage_inmueble_posts_custom_column', 'mostrar_checkbox_visibilidad', 10, 2);
function mostrar_checkbox_visibilidad($column, $post_id) {
    if ($column == 'mostrar') {
        $visible = get_post_meta($post_id, '_inmueble_visible', true);
        $checked = $visible === '1' ? 'checked' : '';
        echo '<label class="switch">
        <input type="checkbox" class="toggle-visibility" data-id="' . esc_attr($post_id) . '" ' . $checked . '>
            <span class="slider round"></span>
        </label>';

    }
}

// 3. Cargar script JS solo en listado de inmuebles
add_action('admin_enqueue_scripts', function($hook) {
    if ($hook === 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'inmueble') {
        wp_enqueue_script('inmueble-admin', plugin_dir_url(__FILE__) . 'assets/js/admin.js', ['jquery'], null, true);
    }
});

// 4. Guardar el estado del checkbox (AJAX)
add_action('wp_ajax_toggle_inmueble_visibility', 'toggle_inmueble_visibility');
function toggle_inmueble_visibility() {
    if (!current_user_can('edit_posts')) wp_die();

    $post_id = intval($_POST['post_id']);
    $visible = $_POST['visible'] === 'true' ? '1' : '0';

    update_post_meta($post_id, '_inmueble_visible', $visible);

    wp_send_json_success(['updated' => true]);
}

add_action('admin_head', function () {
    echo '
    <style>
    .switch {
      position: relative;
      display: inline-block;
      width: 40px;
      height: 22px;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      transition: .4s;
      border-radius: 34px;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 16px;
      width: 16px;
      left: 4px;
      bottom: 3px;
      background-color: white;
      transition: .4s;
      border-radius: 50%;
    }

    input:checked + .slider {
      background-color: #4caf50;
    }

    input:checked + .slider:before {
      transform: translateX(16px);
    }
    </style>
    ';
});










?>
