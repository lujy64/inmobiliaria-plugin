<?php
/*
Plugin Name: Inmobiliaria Plugin
Plugin URI:  
Description: Plugin para gestionar inmuebles y mostrar listados en WordPress.
Version: 1.0
Author: the Panther Soft (Maria Lujan Vaira)
Author URI: https://thepanthersoft.com/
*/

// =========================
// SHORTCODE: BUSCADOR DINÁMICO PRINCIPAL
// =========================
function inmobiliaria_buscador_principal_shortcode() {
    global $wpdb;

    // Obtener opciones únicas desde la base de datos
    $condiciones = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_property_condicion'");
    $tipos = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_property_tipo'");
    $ubicaciones = $wpdb->get_results("
        SELECT DISTINCT 
            pm1.meta_value AS direccion, 
            pm2.meta_value AS departamento, 
            pm3.meta_value AS provincia 
        FROM {$wpdb->postmeta} pm1
        LEFT JOIN {$wpdb->postmeta} pm2 ON pm1.post_id = pm2.post_id AND pm2.meta_key = '_inmueble_departamento'
        LEFT JOIN {$wpdb->postmeta} pm3 ON pm1.post_id = pm3.post_id AND pm3.meta_key = '_inmueble_provincia'
        WHERE pm1.meta_key = '_inmueble_direccion'
    ");

    ob_start();
    ?>
     <form id="buscador-principal-inmuebles" method="POST" class="form-buscador" style="display: flex; gap: 10px; align-items: center;">
        <input type="hidden" name="action" value="redirigir_a_busqueda">

        <!-- Condición -->
        <select name="condicion" style="padding: 10px;">
            <option disabled selected>Condición de Inmueble</option>
            <?php foreach ($condiciones as $condicion) : ?>
                <option value="<?php echo esc_attr($condicion); ?>"><?php echo esc_html($condicion); ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Tipo -->
        <select name="tipo" style="padding: 10px;">
            <option disabled selected>Tipo de Inmueble</option>
            <?php foreach ($tipos as $tipo) : ?>
                <option value="<?php echo esc_attr($tipo); ?>"><?php echo esc_html($tipo); ?></option>
            <?php endforeach; ?>
        </select>

        <select name="ubicacion" style="padding: 10px;" id="ubicaciones">
            <option disabled selected>Zona o Palabra Clave</option>
            <?php 
            // Extraer solo las ubicaciones únicas
            $ubicaciones_unicas = array_unique(array_map(function($ubicacion) {
                return $ubicacion->departamento . ', ' . $ubicacion->provincia;
            }, $ubicaciones));

            // Mostrar opciones sin duplicados
            foreach ($ubicaciones_unicas as $ubicacion) : ?>
                <option value="<?php echo esc_attr($ubicacion); ?>"><?php echo esc_html($ubicacion); ?></option>
            <?php endforeach; ?>
        </select>



        <!-- Precio Desde -->
        <input type="number" name="precio_desde" placeholder="Precio Desde" style="padding: 10px; width: 120px;">

        <!-- Precio Hasta -->
        <input type="number" name="precio_hasta" placeholder="Precio Hasta" style="padding: 10px; width: 120px;">

        <!-- Botón -->
        <button type="submit" style="padding: 10px; background-color: #00796b; color: white; border: none;">Buscar</button>
    </form>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const buscadorForm = document.getElementById("buscador-principal-inmuebles");

        buscadorForm.addEventListener("submit", function (e) {
            e.preventDefault();

            let formData = new FormData(buscadorForm);
            let queryString = new URLSearchParams(formData).toString();
            window.location.href = "<?php echo home_url('/busqueda/'); ?>?" + queryString;
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('buscador_principal', 'inmobiliaria_buscador_principal_shortcode');



function inmobiliaria_buscador_header_shortcode() {
    global $wpdb;

    // Obtener opciones únicas desde la base de datos
    $condiciones = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_property_condicion'");
    $tipos = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_property_tipo'");
    $ubicaciones = $wpdb->get_results("
        SELECT DISTINCT 
            pm1.meta_value AS direccion, 
            pm2.meta_value AS departamento, 
            pm3.meta_value AS provincia 
        FROM {$wpdb->postmeta} pm1
        LEFT JOIN {$wpdb->postmeta} pm2 ON pm1.post_id = pm2.post_id AND pm2.meta_key = '_inmueble_departamento'
        LEFT JOIN {$wpdb->postmeta} pm3 ON pm1.post_id = pm3.post_id AND pm3.meta_key = '_inmueble_provincia'
        WHERE pm1.meta_key = '_inmueble_direccion'
    ");

    ob_start();
    ?>
    <form id="buscador-inmuebles" method="POST" class="form-buscador" style="display: flex; gap: 10px; align-items: center;">
        <input type="hidden" name="action" value="redirigir_a_busqueda">

        <!-- Condición -->
        <select name="condicion" style="padding: 10px;">
            <option disabled selected>Condición de Inmueble</option>
            <?php foreach ($condiciones as $condicion) : ?>
                <option value="<?php echo esc_attr($condicion); ?>"><?php echo esc_html($condicion); ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Tipo -->
        <select name="tipo" style="padding: 10px;">
            <option disabled selected>Tipo de Inmueble</option>
            <?php foreach ($tipos as $tipo) : ?>
                <option value="<?php echo esc_attr($tipo); ?>"><?php echo esc_html($tipo); ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Zona o Palabra Clave -->
        <select name="ubicacion" style="padding: 10px;" id="ubicaciones">
            <option disabled selected>Zona o Palabra Clave</option>
            <?php 
            // Extraer solo las ubicaciones únicas
            $ubicaciones_unicas = array_unique(array_map(function($ubicacion) {
                return $ubicacion->departamento . ', ' . $ubicacion->provincia;
            }, $ubicaciones));

            // Mostrar opciones sin duplicados
            foreach ($ubicaciones_unicas as $ubicacion) : ?>
                <option value="<?php echo esc_attr($ubicacion); ?>"><?php echo esc_html($ubicacion); ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Botón -->
        <button type="submit" style="padding: 10px; background-color: #00796b; color: white; border: none;">Buscar</button>
    </form>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const buscadorForm = document.getElementById("buscador-inmuebles");

        buscadorForm.addEventListener("submit", function (e) {
            e.preventDefault();

            let formData = new FormData(buscadorForm);
            let queryString = new URLSearchParams(formData).toString();
            window.location.href = "<?php echo home_url('/busqueda/'); ?>?" + queryString;
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('buscador_header', 'inmobiliaria_buscador_header_shortcode');



function listado_inmueble_buscador() {
    // Capturar parámetros desde GET
    $params = [
        'condicion' => isset($_GET['condicion']) ? sanitize_text_field($_GET['condicion']) : '',
        'tipo' => isset($_GET['tipo']) ? sanitize_text_field($_GET['tipo']) : '',
        'ubicacion' => isset($_GET['ubicacion']) ? urldecode(sanitize_text_field($_GET['ubicacion'])) : '',
        'precio_desde' => isset($_GET['precio_desde']) ? intval($_GET['precio_desde']) : '',
        'precio_hasta' => isset($_GET['precio_hasta']) ? intval($_GET['precio_hasta']) : '',
    ];

    // Extraer "provincia" y "departamento" de la "ubicacion" (Ej: "Capital, Mendoza")
    if (!empty($params['ubicacion'])) {
        $ubicacion_parts = explode(',', $params['ubicacion']);
        $params['departamento'] = trim($ubicacion_parts[0]);
        $params['provincia'] = trim($ubicacion_parts[1] ?? '');
        unset($params['ubicacion']); // Ya no necesitamos este campo
    }

    // Construir el shortcode con los filtros aplicados
    $shortcode = '[listado_inmuebles limit="8"';
    foreach ($params as $key => $value) {
        if (!empty($value)) {
            $shortcode .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
        }
    }
    $shortcode .= ']'; // Cerrar el shortcode

    // Ejecutar el shortcode generado
    return do_shortcode($shortcode);
}
add_shortcode('listado_buscador', 'listado_inmueble_buscador');














function inmobiliaria_listado_shortcode($atts) {
    // Procesar atributos del shortcode
    $atts = shortcode_atts([
        'condicion' => '',
        'tipo' => '',
        'provincia' => '',
        'departamento' => '',
        'precio_desde' => '',
        'precio_hasta' => '',
        'posts_per_page' => 8, 
    ], $atts);

    // Obtener filtros desde la URL (GET)
    $tipo = !empty($_GET['tipo']) ? sanitize_text_field($_GET['tipo']) : $atts['tipo'];
    $condicion = !empty($_GET['condicion']) ? sanitize_text_field($_GET['condicion']) : $atts['condicion'];
    $provincia = !empty($_GET['provincia']) ? sanitize_text_field($_GET['provincia']) : $atts['provincia'];
    $departamento = !empty($_GET['departamento']) ? sanitize_text_field($_GET['departamento']) : $atts['departamento'];
    $precio_desde = !empty($_GET['precio_desde']) ? intval($_GET['precio_desde']) : $atts['precio_desde'];
    $precio_hasta = !empty($_GET['precio_hasta']) ? intval($_GET['precio_hasta']) : $atts['precio_hasta'];

    // Crear la consulta personalizada con WP_Query
    $meta_query = ['relation' => 'AND'];

    if (!empty($tipo)) {
        $meta_query[] = [
            'key' => '_property_tipo',
            'value' => $tipo,
            'compare' => '=',
        ];
    }

    if (!empty($condicion)) {
        $meta_query[] = [
            'key' => '_property_condicion',
            'value' => $condicion,
            'compare' => '=',
        ];
    }

    if (!empty($provincia)) {
        $meta_query[] = [
            'key' => '_inmueble_provincia',
            'value' => $provincia,
            'compare' => '=',
        ];
    }

    if (!empty($departamento)) {
        $meta_query[] = [
            'key' => '_inmueble_departamento',
            'value' => $departamento,
            'compare' => '=',
        ];
    }

    if (!empty($precio_desde) || !empty($precio_hasta)) {
        $rango_precio = ['relation' => 'AND'];

        if (!empty($precio_desde)) {
            $rango_precio[] = [
                'key' => '_property_precio_usd',
                'value' => $precio_desde,
                'type' => 'NUMERIC',
                'compare' => '>=',
            ];
        }

        if (!empty($precio_hasta)) {
            $rango_precio[] = [
                'key' => '_property_precio_usd',
                'value' => $precio_hasta,
                'type' => 'NUMERIC',
                'compare' => '<=',
            ];
        }

        $meta_query[] = $rango_precio;
    }

    // Configurar la paginación
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    // Crear la consulta principal
    $query_args = [
        'post_type' => 'inmueble',
        'posts_per_page' => intval($atts['posts_per_page']),
        'meta_query' => $meta_query,
        'paged' => $paged,
    ];

    $query = new WP_Query($query_args);

    // Contenedor principal del listado
    $output = '<div class="inmobiliaria-listado" style="display: flex; flex-wrap: wrap; gap: 20px;">';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $output .= render_inmueble_card(get_the_ID());
        }
    } else {
        $output .= '<p>No se encontraron inmuebles con los criterios seleccionados.</p>';
    }

    $output .= '</div>'; // Fin del contenedor principal

    // Agregar la paginación
    $output .= '<div class="pagination" style="margin-top: 20px; text-align: center;">';
    $output .= paginate_links([
        'total' => $query->max_num_pages,
        'current' => max(1, get_query_var('paged')),
        'format' => '?paged=%#%',
        'prev_text' => '&laquo; Anterior',
        'next_text' => 'Siguiente &raquo;',
    ]);
    $output .= '</div>';

    // Restaurar el estado global de la consulta
    wp_reset_postdata();

    return $output;
}
add_shortcode('listado_inmuebles', 'inmobiliaria_listado_shortcode');
    
    
    


    function render_inmueble_card($post_id) {

        $output = '';
        // Recuperar datos personalizados
        $provincia = get_post_meta($post_id, '_inmueble_provincia', true);
        $departamento = get_post_meta($post_id, '_inmueble_departamento', true);
        $direccion = get_post_meta($post_id, '_inmueble_direccion', true);
        $superficie_total = get_post_meta($post_id, '_inmueble_superficie_total', true);
        $superficie_cubierta = get_post_meta($post_id, '_inmueble_superficie_cubierta', true);
        $dormitorios = get_post_meta($post_id, '_inmueble_dormitorios', true);
        $banos = get_post_meta($post_id, '_inmueble_banos', true);
        $cochera = get_post_meta($post_id, '_inmueble_cochera', true);
        $tipo = get_post_meta($post_id, '_property_tipo', true);

        var_dump($tipo);

        // Obtener la galería de imágenes del inmueble
        $gallery = get_post_meta($post_id, '_inmueble_images', true);
        if (!is_array($gallery)) {
            $gallery = [];
        }

        // Construir la tarjeta del inmueble
        $output .= '<div class="inmueble-card" style="position: relative; width: 300px; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">';

            // Contenedor del carrusel
            $output .= '<div class="inmueble-carousel" data-current-index="0" style="position: relative; overflow: hidden; width: 300px; height: 200px;">';

                // Contenedor de imágenes
                $output .= '<div class="carousel-images" style="display: flex; transition: transform 0.5s ease;">';
                    foreach ($gallery as $image_id) {
                        $image_url = wp_get_attachment_url($image_id);
                        if ($image_url) {
                            $output .= '<img src="' . esc_url($image_url) . '" style="width: 300px; height: 200px; object-fit: cover;">';
                        }
                    }
                $output .= '</div>';

                // Botones de navegación del carrusel
                $output .= '<button class="carousel-prev" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); background-color: rgba(0,0,0,0.5); color: #fff; border: none; padding: 5px 10px; cursor: pointer; border-radius: 50%;">&#10094;</button>';
                $output .= '<button class="carousel-next" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); background-color: rgba(0,0,0,0.5); color: #fff; border: none; padding: 5px 10px; cursor: pointer; border-radius: 50%;">&#10095;</button>';


                // Botón "Ver más" que aparece en hover
                $output .= '<div class="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); opacity: 0; display: flex; align-items: center; justify-content: center; transition: opacity 0.3s ease;">';
                    $output .= '<a href="' . get_permalink() . '" >Ver más</a>';
                $output .= '</div>';

                // Precio superpuesto
                $output .= '<div class="inmueble-price" >';

                    $precio_pesos = get_post_meta(get_the_ID(), '_property_precio_pesos', true);
                    $precio_usd = get_post_meta(get_the_ID(), '_property_precio_usd', true);

                    // Reglas para mostrar el precio
                    if ($precio_usd !== '0' && !empty($precio_usd)) {
                        $output .= 'US$ ' . esc_html($precio_usd);
                    } elseif ($precio_pesos !== '0' && !empty($precio_pesos)) {
                        $output .= '$ ' . esc_html($precio_pesos);
                    } else {
                        $output .= 'Consultar'; // Si no hay precios
                    }

                $output .= '</div>'; // Fin inmueble-price

            $output .= '</div>'; // Fin inmueble-carousel

            // Información principal
            $output .= '<div class="inmueble-info">';

                // Asignar ícono según el tipo
                switch (esc_html($tipo)) {
                    case 'Casa':
                        $icono_tipo = 'iconos-casa.png';
                        break;
                    case 'Departamento':
                        $icono_tipo = 'iconos-departamento.png';
                        break;
                    case 'Lote':
                        $icono_tipo = 'iconos-terreno.png';
                        break;
                    case 'Bodega':
                        $icono_tipo = 'iconos-bodega.png';
                        break;
                    case 'Bodega con Vinedo':
                        $icono_tipo = 'iconos-bodega.png';
                        break;
                    case 'Cabana':
                        $icono_tipo = 'iconos-cabaña.png';
                        break;
                    case 'Campo':
                        $icono_tipo = 'iconos-finca.png';
                        break;
                    //case 'Chalet':
                        //$icono_tipo = 'iconos-.png';
                        //break;
                    case 'Cochera':
                        $icono_tipo = 'iconos-cochera.png';
                        break;
                    case 'Condominio':
                        $icono_tipo = 'iconos-departamento.png';
                        break;
                    case 'Deposito':
                        $icono_tipo = 'iconos-galpon.png';
                        break;
                    case 'Duplex':
                        $icono_tipo = 'iconos-duplex.png';
                        break;
                    case 'Edificio':
                        $icono_tipo = 'iconos-departamento.png';
                        break;
                    //case 'Estacion de Servicio':
                        //$icono_tipo = 'iconos-.png';
                        //break;
                    //case 'Fabrica':
                        //$icono_tipo = 'iconos-.png';
                        //break;
                    case 'Finca':
                        $icono_tipo = 'iconos-finca.png';
                        break;
                    //case 'Fondo de Comercio':
                        //$icono_tipo = 'iconos-.png';
                        //break;
                    case 'Fraccionamiento':
                        $icono_tipo = 'iconos-terreno.png';
                        break;
                    case 'Galpon':
                        $icono_tipo = 'iconos-galpon.png';
                        break;
                    //case 'Hotel':
                        //$icono_tipo = 'iconos-.png';
                        //break;
                   // case 'Industria':
                        //$icono_tipo = 'iconos-.png';
                        //break;
                    case 'Local Comercial':
                        $icono_tipo = 'iconos-local comercial.png';
                        break;
                    //case 'Loft':
                        //$icono_tipo = 'iconos-.png';
                        //break;
                    case 'Loteo':
                        $icono_tipo = 'iconos-terreno.png';
                        break;
                    case 'Negocio':
                        $icono_tipo = 'iconos-local comercial.png';
                        break;
                    case 'Oficina':
                        $icono_tipo = 'iconos-oficina.png';
                        break;
                    case 'P H':
                        $icono_tipo = 'iconos-departamento.png';
                        break;
                    case 'Piso':
                        $icono_tipo = 'iconos-departamento.png';
                        break;
                    //case 'Playa de Estacionamiento':
                       // $icono_tipo = 'iconos-.png';
                       // break;
                    //case 'Quinta':
                        //$icono_tipo = 'iconos-.png';
                        //break;
                    case 'Semipiso':
                        $icono_tipo = 'iconos-departamento.png';
                        break;
                    case 'Terreno':
                        $icono_tipo = 'iconos-terreno.png';
                        break;
                    //case 'Triplex':
                        //$icono_tipo = 'iconos-.png';
                        //break;
                    //case 'Vinedo':
                        //$icono_tipo = 'iconos-.png';
                        //break;

                    default:
                        $icono_tipo = 'iconos-casa.png'; // Ícono predeterminado si no coincide ningún tipo
                        break;
                }

                $plugin_dir = plugin_dir_url(__FILE__);

                // Generar la URL al directorio de íconos dentro del plugin
                $icono_url = $plugin_dir . '../assets/icons/' . $icono_tipo;  
            
                $output .= '<div class="caja-blanca-con-icono-tipo">';
                    $output .= '<div class="texto-direcc">';
                        $output .= '<p>' . esc_html($departamento) . ', ' . esc_html($provincia) . '</p>';
                        $output .= '<p>' . esc_html($direccion) . '</p>';
                    $output .= '</div>';
                    $output .= '<img src="' . esc_url($icono_url) . '" alt="Tipo de inmueble">';
                $output .= '</div>';

            
            $output .= '</div>'; // Fin inmueble-info



            $output .= '<div class="inmueble-icons">';

                    // Iconos con detalles
                    $output .= '<span><img src="' . esc_url($plugin_dir . '../assets/icons/iconos-1terreno completo.png') . '" alt="Superficie Total"> ' . esc_html($superficie_total) . 'm²</span>';
                    $output .= '<span><img src="' . esc_url($plugin_dir . '../assets/icons/iconos-terreno construido.png') . '" alt="Superficie Cubierta"> ' . esc_html($superficie_cubierta) . 'm²</span>';

                    // Mostrar ícono y texto de dormitorio sólo si no es "indistinto" o vacío
                    if (!empty($dormitorios) && strtolower($dormitorios) !== 'indistinto') {
                        $output .= '<span><img src="' . esc_url($plugin_dir . '../assets/icons/iconos-dormitorios.png') . '" alt="Dormitorios"> ' . esc_html($dormitorios) . '</span>';
                    }

                    // Mostrar ícono y texto de cochera sólo si no es "indistinto" o vacío
                    if (!empty($banos) && strtolower($banos) !== 'indistinto') {
                        $output .= '<span><img src="' . esc_url($plugin_dir . '../assets/icons/iconos-baño.png') . '" alt="Baños"> ' . esc_html($banos) . '</span>';
                    }

                    // Mostrar ícono y texto de cochera sólo si no es "indistinto" o vacío
                    if (!empty($cochera) && strtolower($cochera) !== 'indistinto') {
                        $output .= '<span><img src="' . esc_url($plugin_dir . '../assets/icons/iconos-cochera.png') . '" alt="Cocheras">' . esc_html($cochera) . '</span>';
                    }

            $output .= '</div>'; // Fin inmueble-icons
            

        $output .= '</div>'; // Fin inmueble-card
    
        return $output;
    }
    
    function generate_carousel($gallery) {
        $output = '<div class="inmueble-carousel" style="position: relative; overflow: hidden; width: 300px; height: 200px;">';
        if (!empty($gallery)) {
            $output .= '<div class="carousel-images" style="display: flex; transition: transform 0.5s ease;">';
            foreach ($gallery as $image_id) {
                $image_url = wp_get_attachment_url($image_id);
                if ($image_url) {
                    $output .= '<img src="' . esc_url($image_url) . '" alt="Imagen del inmueble" style="width: 300px; height: 200px; object-fit: cover;">';
                }
            }
            $output .= '</div>';
        } else {
            $output .= '<img src="https://via.placeholder.com/300x200?text=Sin+Imagen" alt="Sin imagen" style="width: 300px; height: 200px; object-fit: cover;">';
        }
        $output .= '</div>'; // Fin inmueble-carousel
        return $output;
    }

    // Encolar el script para el carrusel
    function inmobiliaria_enqueue_carrusel_script() {
        wp_enqueue_script(
            'carrusel-inmuebles',
            plugin_dir_url(__FILE__) . '../assets/js/carrusel.js', // Ruta al archivo del script
            [],
            '1.0',
            true // Cargar al final del body
        );
    }
    add_action('wp_enqueue_scripts', 'inmobiliaria_enqueue_carrusel_script');
    





