<?php
/*
Plugin Name: Inmobiliaria Plugin
Plugin URI:  
Description: Plugin para gestionar inmuebles y mostrar listados en WordPress.
Version: 1.0
Author: the Panther Soft (Maria Lujan Vaira)
Author URI: https://thepanthersoft.com/
*/

// Evitar el acceso directo
if (!defined('ABSPATH')) {
    exit;
}


// Obtener los datos del inmueble
$post_id = get_the_ID();


//ubicacion
$provincia = get_post_meta($post_id, '_inmueble_provincia', true);
$departamento = get_post_meta($post_id, '_inmueble_departamento', true);
$localidad = get_post_meta($post_id, '_inmueble_localidad', true);
$direccion = get_post_meta($post_id, '_inmueble_direccion', true);

// galeria
$gallery = get_post_meta($post_id, '_inmueble_images', true);

// datos
$tipo = get_post_meta($post_id, '_property_tipo', true);
$condicion = get_post_meta($post_id, '_property_condicion', true);
$precio_pesos = get_post_meta($post_id, '_property_precio_pesos', true);
$precio_usd = get_post_meta($post_id, '_property_precio_usd', true);
$ocultar_precio = get_post_meta($post_id, '_property_ocultar_precio', true);

//servicios
$aire_acondicionado = get_post_meta($post_id, '_inmueble_aire_acondicionado', true);
$amoblado = get_post_meta($post_id, '_inmueble_amoblado', true);
$antiguedad = get_post_meta($post_id, '_inmueble_antiguedad', true);
$apto_credito = get_post_meta($post_id, '_inmueble_apto_credito', true);
$banos = get_post_meta($post_id, '_inmueble_banos', true);
$mascotas = get_post_meta($post_id, '_inmueble_mascotas', true);
$barrio_privado = get_post_meta($post_id, '_inmueble_barrio_privado', true);
$cable_tv = get_post_meta($post_id, '_inmueble_cable_tv', true);
$calefaccion_central = get_post_meta($post_id, '_inmueble_calefaccion_central', true);
$cantidad_de_ambientes = get_post_meta($post_id, '_inmueble_cantidad_de_ambientes', true);
$cochera = get_post_meta($post_id, '_inmueble_cochera', true);
$dormitorios = get_post_meta($post_id, '_inmueble_dormitorios', true);
$estado_conservacion = get_post_meta($post_id, '_inmueble_estado_conservacion', true);
$financiacion = get_post_meta($post_id, '_inmueble_financiacion', true);
$internet = get_post_meta($post_id, '_inmueble_internet', true);
$piscina = get_post_meta($post_id, '_inmueble_piscina', true);
$plantas = get_post_meta($post_id, '_inmueble_plantas', true);
$superficie_cubierta = get_post_meta($post_id, '_inmueble_superficie_cubierta', true);
$superficie_total = get_post_meta($post_id, '_inmueble_superficie_total', true);
$hectareas = get_post_meta($post_id, '_inmueble_hectareas', true);
$telefono = get_post_meta($post_id, '_inmueble_telefono', true);
$tiene_expensas = get_post_meta($post_id, '_inmueble_tiene_expensas', true);
$zona_escolar = get_post_meta($post_id, '_inmueble_zona_escolar', true);
$recibe_permuta = get_post_meta($post_id, '_inmueble_recibe_permuta', true);

// Obtener el título dinámico del inmueble (en dos partes)
$titulo_parte_1 = isset($condicion) ? $condicion : '';
$titulo_parte_2 = isset($tipo) ? $tipo : '';

$direccion_completa = esc_html($direccion) . ', ' . esc_html($departamento) . ', ' . esc_html($provincia);

// Validar que `$gallery` sea un array antes de usarlo
if (!is_array($gallery)) {
    $gallery = []; // Si no es un array, inicializarlo como vacío
}


// Obtener propiedades relacionadas (basado en tipo o ubicación)
$args_relacionados = [
    'post_type'      => 'inmueble',
    'posts_per_page' => 4, // Número de inmuebles relacionados
    'post__not_in'   => [$post_id], // Excluir el inmueble actual
    'meta_query'     => [
        'relation' => 'OR',
        [
            'key'     => '_property_tipo',
            'value'   => $tipo,
            'compare' => '='
        ],
        [
            'key'     => '_inmueble_departamento',
            'value'   => $departamento,
            'compare' => '='
        ],
        [
            'key' => '_inmueble_visible',
            'value' => '1',
            'compare' => '='
        ]
    ]
];

$query_relacionados = new WP_Query($args_relacionados);


get_header(); // Cargar el encabezado del tema
?>
<div class="socalo-filtros">
    <div class="filtros-dinamicos" style="padding: 15px; background-color: #f9f9f9; border-bottom: 1px solid #ddd; display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <p style="margin: 0; font-weight: bold;">Filtros aplicados:</p>
        <?php
        // Mostrar los filtros como botones
        if (!empty($condicion)) {
            echo '<span style="background-color: #00796b; color: white; padding: 8px 15px; border-radius: 20px; margin-right: 10px;">' . ucfirst($condicion) . '</span>';
        }
        if (!empty($tipo)) {
            echo '<span style="background-color: #00796b; color: white; padding: 8px 15px; border-radius: 20px; margin-right: 10px;">' . ucfirst($tipo) . '</span>';
        }
        if (!empty($ubicacion)) {
            echo '<span style="background-color: #00796b; color: white; padding: 8px 15px; border-radius: 20px; margin-right: 10px;">' . ucfirst($ubicacion) . '</span>';
        }
        ?>
    </div>




    <div class="miga-de-pan" style="padding: 15px; background-color: #f4f4f4; border-bottom: 1px solid #ddd; margin-bottom: 15px; font-size: 14px;">
        <?php
        // Base URL
        $base_url = home_url('/busqueda/');

        // Mostrar las migas de pan con enlaces
        echo '<a href="' . esc_url(home_url()) . '" style="color: #00796b; text-decoration: none;">Inicio</a> &gt; ';

        if (!empty($condicion)) {
            echo '<a href="' . esc_url(home_url(). '/busqueda/?action=redirigir_a_busqueda&condicion=' . $condicion . '&ubicacion=&precio_desde=&precio_hasta=') . '" style="color: #00796b; text-decoration: none;">' . ucfirst($condicion) . '</a> &gt; ';
        }
        if (!empty($tipo)) {
            echo '<a href="' . esc_url(home_url(). '/busqueda/?action=redirigir_a_busqueda&condicion=&tipo=' . $tipo . '&ubicacion=') . '" style="color: #00796b; text-decoration: none;">' . ucfirst($tipo) . '</a> &gt; ';
        }
        ?>
    </div>

</div>
<main class="inmueble-template single-inmueble">
    
    <div class="inmueble-primer-fila">
        <!-- Galería de imágenes -->
        <div class="inmueble-galeria">
            <?php if (!empty($gallery) && is_array($gallery)) : ?>
                <div class="gallery-main-container">
                    <!-- Flecha izquierda -->
                    <div class="gallery-arrow left-arrow">&lt;</div>

                    <!-- Imagen principal -->
                        <img id="main-image" src="<?php echo esc_url(wp_get_attachment_url($gallery[0])); ?>" alt="Imagen principal del inmueble" style="width: 885px; height: 664px;" />
                        <div class="caja-precio">
                        <?php if ($ocultar_precio !== '1') : ?>
                            <?php if (!empty($precio_pesos)) : ?>
                                <p class="precio">$ <?php echo esc_html($precio_pesos); ?></p>
                            <?php elseif (!empty($precio_usd)) : ?>
                                <p class="precio">US$ <?php echo esc_html($precio_usd); ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <!-- Flecha derecha -->
                    <div class="gallery-arrow right-arrow">&gt;</div>
                </div>
                <div class="gallery-thumbnails">
                    <!-- Miniaturas -->
                    <?php foreach ($gallery as $image_id) : ?>
                        <?php $image_url = wp_get_attachment_url($image_id); ?>
                        <?php if ($image_url) : ?>
                            <?php $watermark_url = home_url('/imagen-marca-agua/' . $image_id . '/'); ?>
                            <div class="watermark-wrapper" style="position: relative; display: inline-block; width: fit-content;">
                                <img class="thumbnail" src="<?php echo esc_url($image_url); ?>" alt="Miniatura del inmueble" />
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="caja-iconos-inmuebles">
                <div class="inmueble-info">
                        <?php

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
                        ?>
            
                        <div class="caja-blanca-con-icono-tipo">
                            <img src="<?php echo esc_url($icono_url); ?>" alt="Tipo de inmueble">
                            <div class="texto-direcc">
                                <p><?php echo esc_html($departamento); ?> , <?php echo esc_html($provincia); ?></p>
                                <p><?php echo esc_html($direccion); ?></p>
                            </div>
                        </div>

            
                </div>

                <div class="inmueble-icons">
                    <?php 
                    if ($icono_tipo == 'Terreno' || $icono_tipo == 'Lote') { ?>   
                        <span><img src="<?php echo esc_url($plugin_dir . '../assets/icons/iconos-1terreno completo.png'); ?>" alt="Hectareas"> <?php echo esc_html($hectareas); ?></span>
                    <?php }   ?>

                    <?php 
                    if ($icono_tipo !== 'Terreno' || $icono_tipo !== 'Lote') { ?>  
                    <span><img src="<?php echo esc_url($plugin_dir . '../assets/icons/iconos-1terreno completo.png'); ?>" alt="Superficie Total"> <?php echo esc_html($superficie_total); ?> m²</span>
                    <span><img src="<?php echo esc_url($plugin_dir . '../assets/icons/iconos-terreno construido.png'); ?>" alt="Superficie Cubierta"> <?php echo esc_html($superficie_cubierta); ?> m²</span>
                    <?php }   ?>
                    <?php
                    // Mostrar ícono y texto de dormitorio sólo si no es "indistinto" o vacío
                    if (!empty($dormitorios) && strtolower($dormitorios) !== 'indistinto') { ?>
                        <span><img src="<?php echo esc_url($plugin_dir . '../assets/icons/iconos-dormitorios.png'); ?>" alt="Dormitorios"> <?php echo esc_html($dormitorios); ?> </span>
                    <?php }

                    // Mostrar ícono y texto de cochera sólo si no es "indistinto" o vacío
                    if (!empty($banos) && strtolower($banos) !== 'indistinto') { ?>
                        <span><img src="<?php echo esc_url($plugin_dir . '../assets/icons/iconos-baño.png'); ?>" alt="Baños"><?php echo esc_html($banos); ?> </span>
                    <?php }

                    // Mostrar ícono y texto de cochera sólo si no es "indistinto" o vacío
                    if (!empty($cochera) && strtolower($cochera) !== 'indistinto') { ?>
                        <span><img src="<?php echo esc_url($plugin_dir . '../assets/icons/iconos-cochera.png'); ?>" alt="Cocheras"><?php echo esc_html($cochera); ?> </span>
                    <?php } ?>

                </div>
            </div>
        </div>

        <div class="inmueble-datos">

            <!-- Mostrar el título dinámico -->
            <div class="inmueble-titulo" style="margin-bottom: 20px;">
                <p style="font-size: 20px; font-weight: bold; margin: 0;"><?php echo esc_html($titulo_parte_1);?> de <?php echo esc_html($titulo_parte_2); ?></p>
                <p style="font-size: 16px; color: #555; margin: 0;"><?php echo esc_html($direccion_completa); ?></p>
                <p></p>
            </div>

            <!-- Mostrar descripcion -->
            <div class="inmueble-caracteristicas">
                <p class="inmueble-caracteristicas-titulo">CARACTERÍSTICAS:</p>
                <?php 
                     
                    $descripcion = get_post_meta(get_the_ID(), '_property_descripcion', true);
                    if (!empty($descripcion)) {
                        echo '<div class="descripcion-inmueble">';
                        echo wpautop(wp_kses_post($descripcion)); // Mostrar descripción con HTML permitido y saltos de línea
                        echo '</div>';
                    }

                ?>
            </div>

            <div class="boton-whatsapp" style="margin-top: 20px; text-align: center;">
                <?php
                // Texto para compartir en WhatsApp
                $titulo_completo = esc_html($titulo_parte_1) . ' de ' . esc_html($titulo_parte_2);
                $url_actual = get_permalink(); // Enlace a la página actual
                $texto_whatsapp = urlencode("¡Hola! Estoy interesado en esta propiedad: $url_actual. Solicito información sobre  $titulo_completo. en $direccion_completa ");
                ?>
                <a href="https://wa.me/+5492617777029?text=<?php echo $texto_whatsapp; ?>" target="_blank" rel="noopener noreferrer" style="display: block; padding: 10px 20px; background-color: #25d366; color: #fff; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;">
                    <img src="/wp-content/uploads/2025/01/boton-icono-whatsappa.png" alt="WhatsApp" style="width: 20px; vertical-align: middle; margin-right: 10px;">
                    CONSULTAR POR ESTA PROPIEDAD
                </a>
            </div>

        </div>
    </div>
    <div class="inmueble-segunda-fila">
        <div class="inmueble-detalles">
        <div class="titulo-propiedad">Datos de la propiedad</div>
            <div class="detalles-izq">
                <div class="detalles">
                    <p class="titulo-detalle">ID#</p>
                    <p class="info-detalle"><?php echo esc_html($post_id); ?></p>
                </div>
                <div class="detalles">
                    <p class="titulo-detalle">Condición</p>
                    <p class="info-detalle"><?php echo esc_html($condicion); ?></p>
                </div>
                <?php
                    if ($hectareas !== '0' && $hectareas !== ' ' && !empty($hectareas)) {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Hectareas</p>
                    <p class="info-detalle"><?php echo esc_html($hectareas); ?></p>
                </div>
                <?php } else { } ?>        

                <?php
                    if ($superficie_total !== '0' && $superficie_total !== ' ' && !empty($superficie_total)) {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Superficie Total m2</p>
                    <p class="info-detalle"><?php echo esc_html($superficie_total); ?></p>
                </div>
                <?php } else { } ?>    

                <?php
                    if ($superficie_cubierta !== '0' && $superficie_cubierta !== ' ' && !empty($superficie_cubierta)) {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Superficie Cubierta m2</p>
                    <p class="info-detalle"><?php echo esc_html($superficie_cubierta); ?></p>
                </div>
                <?php } else { } ?>

                <?php
                    if ($dormitorios !== '0' && $dormitorios !== ' ' && $dormitorios === 'Indistinto' && !empty($dormitorios)) {
                ?>        
                <div class="detalles">
                    <p class="titulo-detalle">Dormitorios</p>
                    <p class="info-detalle"><?php echo esc_html($dormitorios); ?></p>
                </div>
                <?php } else { } ?>

                <?php
                    if ($banos !== '0' && $banos !== ' ' && !empty($banos)) {
                ?>  
                <div class="detalles">
                    <p class="titulo-detalle">Baños</p>
                    <p class="info-detalle"><?php echo esc_html($banos); ?></p>
                </div>
                <?php } else { } ?>

                <?php
                    if ($cochera !== '0' && $cochera !== ' ' && $cochera === 'Indistinto' && !empty($cochera)) {
                ?> 
                <div class="detalles">
                    <p class="titulo-detalle">Cochera</p>
                    <p class="info-detalle"><?php echo esc_html($cochera); ?></p>
                </div>
                <?php } else { } ?>
                
                <?php
                    if ($mascotas === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Mascotas</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($mascotas === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Mascotas</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>

                <?php
                    if ($calefaccion_central === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Calefacción Central</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($calefaccion_central === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Calefacción Central</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>

                
                <?php
                    if ($amoblado === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Amoblado</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($amoblado === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Amoblado</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>


                <?php
                    if ($piscina === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Piscina</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($piscina === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Piscina</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>



                <?php
                    if ($cable_tv === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Cable TV</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($cable_tv === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Cable TV</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>


                <?php
                    if ($plantas === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Plantas</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($plantas === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Plantas</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>

            </div>
            

            <div class="detalles-der">
                

                <?php
                if ($zona_escolar === 'Indistinto') {
                   
                } else { ?>

                <div class="detalles">
                    <p class="titulo-detalle">Cantidad de ambientes</p>
                    <p class="info-detalle"><?php echo esc_html($cantidad_de_ambientes); ?></p>
                </div>

                <?php } ?>


                <?php
                    if ($zona_escolar === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Zona escolar</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($zona_escolar === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Zona escolar</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>

                <?php
                    if ($antiguedad === '' || $antiguedad === 'Indistinto') {
                ?>
                
                <?php
                } else { ?>

                    <div class="detalles">
                        <p class="titulo-detalle">Antigüedad</p>
                        <p class="info-detalle"><?php echo esc_html($antiguedad); ?></p>
                    </div>

                <?php } ?>



                <?php
                    if ($barrio_privado === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Barrio Privado</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($barrio_privado === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Barrio Privado</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>




                <?php
                    if ($aire_acondicionado === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Aire Acondicionado</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($aire_acondicionado === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Aire Acondicionado</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>



                <?php
                    if ($tiene_expensas === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Tiene Expensas</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($tiene_expensas === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Tiene Expensas</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>




                <?php
                    if ($internet === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Internet</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($internet === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Internet</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>



                
                <?php
                    if ($apto_credito === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Apto Crédito Hipotecario</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($apto_credito === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Apto Crédito Hipotecario</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>



                <?php
                    if ($financiacion === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Financiación</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($financiacion === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Financiación</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>


                <?php
                    if ($estado_conservacion === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Estado de Conservación</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($estado_conservacion === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">Estado de Conservación</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>


                <?php
                    if ($recibe_permuta === 'Sí') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">¿Recibe Permuta?</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/FaSolidCheck.png">
                    </p>
                </div>
                <?php
                    } elseif ($recibe_permuta === 'No') {
                ?>
                <div class="detalles">
                    <p class="titulo-detalle">¿Recibe Permuta?</p>
                    <p class="info-detalle">
                        <img class="icono-informacion-inmueble" src="/wp-content/uploads/2025/01/IconParkSolidError.png">
                    </p>
                </div>
                <?php } else { } ?>

            </div>
        </div>
        

        <div class="inmueble-mapa">
            <iframe 
                src="https://www.google.com/maps?q=<?php echo urlencode("$direccion, $localidad, $departamento, $provincia"); ?>&output=embed"
                width="100%"
                height="400"
                style="border: 0;"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>

        <!-- Leaflet JS & CSS -->
        <!--<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const map = L.map('map-leaflet').setView([-32.8908, -68.8272], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                const direccion = "<?php //echo esc_js(
                    /*get_post_meta(get_the_ID(), '_inmueble_direccion', true) . ', ' .
                    get_post_meta(get_the_ID(), '_inmueble_localidad', true) . ', ' .
                    get_post_meta(get_the_ID(), '_inmueble_departamento', true) . ', ' .
                    get_post_meta(get_the_ID(), '_inmueble_provincia', true)
                );*/ ?>";
                //const direccion = "<?php /*echo esc_js(
                    get_post_meta(get_the_ID(), '_inmueble_direccion', true) . ', ' .
                    get_post_meta(get_the_ID(), '_inmueble_departamento', true) . ', ' .
                    get_post_meta(get_the_ID(), '_inmueble_provincia', true)
                );*/ ?>";

                console.log("Buscando dirección:", direccion);

                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(direccion)}`)
                    .then(res => res.json())
                    .then(data => {
                        console.log("Resultado de búsqueda:", data);

                        if (data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            map.setView([lat, lon], 16);
                            L.marker([lat, lon]).addTo(map).bindPopup(direccion).openPopup();
                        } else {
                            alert("No se pudo ubicar el inmueble en el mapa.");
                        }
                    })
                    .catch(err => {
                        console.error("Error al geolocalizar:", err);
                    });
            });
        </script>-->



    </div>
</main>

<?php if ($query_relacionados->have_posts()) : ?>
    <div class="propiedades-relacionadas">
        <h2>Propiedades Relacionadas</h2>
        <div class="relacionadas-listado" style="display: flex; flex-wrap: wrap; gap: 20px;">
            <?php while ($query_relacionados->have_posts()) : $query_relacionados->the_post(); ?>
                <?php
                // Datos de cada propiedad relacionada
                $post_id_rel = get_the_ID();
                $gallery_rel = get_post_meta($post_id_rel, '_inmueble_images', true);
                if (!is_array($gallery_rel)) {
                    $gallery_rel = [];
                }

                //ubicacion
                $provincia = get_post_meta($post_id_rel, '_inmueble_provincia', true);
                $departamento = get_post_meta($post_id_rel, '_inmueble_departamento', true);
                $localidad = get_post_meta($post_id_rel, '_inmueble_localidad', true);
                $direccion = get_post_meta($post_id_rel, '_inmueble_direccion', true);

                // datos
                $tipo = get_post_meta($post_id_rel, '_property_tipo', true);
                $precio_pesos = get_post_meta($post_id_rel, '_property_precio_pesos', true);
                $precio_usd = get_post_meta($post_id_rel, '_property_precio_usd', true);
                $ocultar_precio = get_post_meta($post_id_rel, '_property_ocultar_precio', true);

                //servicios
                $cochera = get_post_meta($post_id_rel, '_inmueble_cochera', true);
                $dormitorios = get_post_meta($post_id_rel, '_inmueble_dormitorios', true);

                ?>
                <div class="inmueble-card relaciones" style="position: relative; width: 300px; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Contenedor del carrusel -->
                    <div class="inmueble-carousel" data-current-index="0" style="position: relative; overflow: hidden; width: 300px; height: 200px;">
                        <div class="carousel-images" style="display: flex; transition: transform 0.5s ease;">
                            <?php if (!empty($gallery_rel)) : ?>
                                <?php foreach ($gallery_rel as $image_id_rel) : ?>
                                    <?php $image_url_rel = wp_get_attachment_url($image_id_rel); ?>
                                    <?php if ($image_url_rel) : ?>
                                        <img src="<?php echo esc_url($image_url_rel); ?>" style="width: 300px; height: 200px; object-fit: cover;">
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <img src="https://via.placeholder.com/300x200?text=Sin+Imagen" style="width: 300px; height: 200px; object-fit: cover;">
                            <?php endif; ?>
                        </div>

                        <!-- Botones de navegación -->
                        <button class="carousel-prev" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); background-color: rgba(0,0,0,0.5); color: #fff; border: none; padding: 5px 10px; cursor: pointer; border-radius: 50%;">&#10094;</button>
                        <button class="carousel-next" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); background-color: rgba(0,0,0,0.5); color: #fff; border: none; padding: 5px 10px; cursor: pointer; border-radius: 50%;">&#10095;</button>

                        <!-- Botón "Ver más" -->
                        <div class="overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); opacity: 0; display: flex; align-items: center; justify-content: center; transition: opacity 0.3s ease;">
                            <a href="<?php the_permalink(); ?>" style="color: white; text-decoration: none; font-weight: bold;">Ver más</a>
                        </div>

                        <div class="inmueble-price" >
                            <?php
                                // Reglas para mostrar el precio
                                if ($precio_usd === '0' && !empty($precio_usd)) { ?>
                                    US$ <?php echo esc_html($precio_usd);
                                } elseif ($precio_pesos !== '0' && !empty($precio_pesos)) { ?>
                                    $ <?php echo esc_html($precio_pesos);
                                } else { ?>
                                    Consultar
                                <?php }
                            ?>

                        </div>

                    </div>

                    <div class="inmueble-info">
                        <?php

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
                        ?>
            
                        <div class="caja-blanca-con-icono-tipo">
                            <div class="texto-direcc">
                                <p><?php echo esc_html($departamento); ?> , <?php echo esc_html($provincia); ?></p>
                                <p><?php echo esc_html($direccion); ?></p>
                            </div>
                            <img src="<?php echo esc_url($icono_url); ?>" alt="Tipo de inmueble">
                        </div>

            
                    </div>

                    <div class="inmueble-icons">

                        <span><img src="<?php echo esc_url($plugin_dir . '../assets/icons/iconos-1terreno completo.png'); ?>" alt="Superficie Total"> <?php echo esc_html($superficie_total); ?> m²</span>
                        <span><img src="<?php echo esc_url($plugin_dir . '../assets/icons/iconos-terreno construido.png'); ?>" alt="Superficie Cubierta"> <?php echo esc_html($superficie_cubierta); ?> m²</span>
                        <?php
                        // Mostrar ícono y texto de dormitorio sólo si no es "indistinto" o vacío
                        if (!empty($dormitorios) && strtolower($dormitorios) !== 'indistinto') { ?>
                            <span><img src="<?php echo esc_url($plugin_dir . '../assets/icons/iconos-dormitorios.png'); ?>" alt="Dormitorios"> <?php echo esc_html($dormitorios); ?> </span>
                        <?php }

                        // Mostrar ícono y texto de cochera sólo si no es "indistinto" o vacío
                        if (!empty($banos) && strtolower($banos) !== 'indistinto') { ?>
                            <span><img src="<?php echo esc_url($plugin_dir . '../assets/icons/iconos-baño.png'); ?>" alt="Baños"><?php echo esc_html($banos); ?> </span>
                        <?php }

                        // Mostrar ícono y texto de cochera sólo si no es "indistinto" o vacío
                        if (!empty($cochera) && strtolower($cochera) !== 'indistinto') { ?>
                            <span><img src="<?php echo esc_url($plugin_dir . '../assets/icons/iconos-cochera.png'); ?>" alt="Cocheras"><?php echo esc_html($cochera); ?> </span>
                        <?php } ?>

                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>



<script>
document.addEventListener("DOMContentLoaded", function () {
    const thumbnails = document.querySelectorAll(".gallery-thumbnails img");
    const mainImage = document.getElementById("main-image");
    const leftArrow = document.querySelector(".left-arrow");
    const rightArrow = document.querySelector(".right-arrow");

    // Obtener todas las imágenes
    const galleryImages = Array.from(thumbnails).map((thumbnail) => thumbnail.src);
    let currentIndex = 0;

    // Cambiar la imagen principal al hacer clic en una miniatura
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener("click", function () {
            mainImage.src = this.src;
            currentIndex = index; // Actualizar índice actual
        });
    });

    // Cambiar la imagen principal al hacer clic en las flechas
    leftArrow.addEventListener("click", function () {
        currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
        mainImage.src = galleryImages[currentIndex];
    });

    rightArrow.addEventListener("click", function () {
        currentIndex = (currentIndex + 1) % galleryImages.length;
        mainImage.src = galleryImages[currentIndex];
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".inmueble-carousel").forEach(function (carousel) {
        const imagesContainer = carousel.querySelector(".carousel-images");
        const images = imagesContainer.querySelectorAll("img");
        const prevButton = carousel.querySelector(".carousel-prev");
        const nextButton = carousel.querySelector(".carousel-next");
        let currentIndex = 0;

        function updateCarousel() {
            const offset = -currentIndex * 300; // Ancho de la imagen
            imagesContainer.style.transform = `translateX(${offset}px)`;
        }

        prevButton.addEventListener("click", function () {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateCarousel();
        });

        nextButton.addEventListener("click", function () {
            currentIndex = (currentIndex + 1) % images.length;
            updateCarousel();
        });
    });
});
</script>






<?php


get_footer(); // Cargar el pie del tema
?>
