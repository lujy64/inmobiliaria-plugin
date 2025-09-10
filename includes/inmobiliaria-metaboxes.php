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
// METABOX: UBICACIÓN DEL INMUEBLE
// =========================

    // Registrar el Metabox: Ubicación
    function inmobiliaria_add_location_metabox()
    {
        add_meta_box(
            'inmueble_location',
            'Ubicación del Inmueble',
            'inmobiliaria_render_location_metabox',
            'inmueble',
            'normal',
            'high'
        );
    }
    add_action('add_meta_boxes', 'inmobiliaria_add_location_metabox');

    // Renderizar el Metabox: Ubicación
    function inmobiliaria_render_location_metabox($post)
    {

        // Incluir el archivo ubicaciones.php
        $ubicaciones = require plugin_dir_path(__FILE__) . 'ubicaciones.php';

        // Recuperar valores previos guardados
        $provincia_guardada = get_post_meta($post->ID, '_inmueble_provincia', true);
        $departamento_guardado = get_post_meta($post->ID, '_inmueble_departamento', true);
        $direccion_guardada = get_post_meta($post->ID, '_inmueble_direccion', true);
        $localidad_guardada = get_post_meta($post->ID, '_inmueble_localidad', true);

    ?>
        <!-- Campos del Metabox -->
        <div class="card-ubicacion">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0px 20px;">
                <div class="campos">
                    <!-- Campo Provincia -->
                    <p style="margin-bottom: 6px;"><label for="inmueble_provincia">Provincia <strong>(Requerido)</strong></label></p>
                    <select id="inmueble_provincia" name="inmueble_provincia" style="width: 100%;" required>
                        <option value="">Seleccione una provincia</option>
                        <?php foreach ($ubicaciones as $provincia_nombre => $datos) : ?>
                            <option value="<?php echo esc_attr($provincia_nombre); ?>" <?php selected($provincia_guardada, $provincia_nombre); ?>>
                                <?php echo esc_html($provincia_nombre); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="campos">
                    <!-- Campo Departamento -->
                    <p style="margin-bottom: 6px;"><label for="inmueble_departamento">Departamento o Partido <strong>(Requerido)</strong></label></p>
                    <select id="inmueble_departamento" name="inmueble_departamento" required style="width: 100%;" <?php echo empty($provincia_guardada) ? 'disabled' : ''; ?>>
                        <option value="">Seleccione un departamento</option>
                        <?php
                        if (!empty($provincia_guardada) && isset($ubicaciones[$provincia_guardada]['departamentos'])) {
                            foreach ($ubicaciones[$provincia_guardada]['departamentos'] as $departamento => $localidades) :
                        ?>
                                <option value="<?php echo esc_attr($departamento); ?>" <?php selected($departamento_guardado, $departamento); ?>>
                                    <?php echo esc_html($departamento); ?>
                                </option>
                        <?php
                            endforeach;
                        }
                        ?>
                    </select>
                </div>
                <div class="campos">
                    <!-- Campo Localidad -->
                    <p style="margin-bottom: 6px;"><label for="inmueble_localidad">Zona o Localidad:</label></p>
                    <select id="inmueble_localidad" name="inmueble_localidad" style="width: 100%;" <?php echo empty($departamento_guardado) ? 'disabled' : ''; ?>>
                        <option value="">Seleccione una localidad</option>
                        <?php
                        if (
                            !empty($provincia_guardada)
                            && !empty($departamento_guardado)
                            && isset($ubicaciones[$provincia_guardada]['departamentos'][$departamento_guardado])
                        ) {
                            foreach ($ubicaciones[$provincia_guardada]['departamentos'][$departamento_guardado] as $localidad) :
                        ?>
                                <option value="<?php echo esc_attr($localidad); ?>" <?php selected($localidad_guardada, $localidad); ?>>
                                    <?php echo esc_html($localidad); ?>
                                </option>
                        <?php
                            endforeach;
                        }
                        ?>
                    </select>
                </div>
                <div class="campos">
                    <!-- Campo Dirección -->
                    <p style="margin-bottom: 6px;"><label for="inmueble_direccion">Domicilio <strong>(Requerido)</strong></label></p>
                    <input type="text" id="inmueble_direccion" name="inmueble_direccion" value="<?php echo esc_attr($direccion_guardada); ?>" style="width: 100%;" required />
                </div>
            </div>

            <!-- Contenedor del mapa -->
            <div class="map-container" id="map-container" style="width: 100%; height: 300px; margin-top: 20px;">
                <iframe
                    id="map-iframe"
                    width="100%"
                    height="100%"
                    frameborder="0"
                    style="border:0;"
                    src="https://www.google.com/maps?q=<?php echo urlencode($direccion_guardada . ', ' . $localidad_guardada . ', ' . $provincia_guardada); ?>&output=embed"
                    allowfullscreen>
                </iframe>
            </div>

            <!-- Contenedor del mapa interactivo con Leaflet -->
            <!-- <div id="map-leaflet" style="width: 100%; height: 300px; margin-top: 20px;"></div>-->


        </div>


        <!-- Script para manejar dependencias dinámicas -->
        <script>
            jQuery(document).ready(function($) {
                const ubicaciones = <?php echo json_encode($ubicaciones); ?>;

                // Actualizar el campo Departamento según la Provincia seleccionada
                $('#inmueble_provincia').on('change', function() {
                    const provinciaSeleccionada = $(this).val();
                    const departamentoSelect = $('#inmueble_departamento');
                    const localidadSelect = $('#inmueble_localidad');

                    // Resetear los selects
                    departamentoSelect.empty().append('<option value="">Seleccione un departamento</option>');
                    localidadSelect.empty().append('<option value="">Seleccione una localidad</option>').prop('disabled', true);

                    if (provinciaSeleccionada && ubicaciones[provinciaSeleccionada]) {
                        const departamentos = ubicaciones[provinciaSeleccionada].departamentos;
                        for (const departamento in departamentos) {
                            departamentoSelect.append(`<option value="${departamento}">${departamento}</option>`);
                        }
                        departamentoSelect.prop('disabled', false);
                    } else {
                        departamentoSelect.prop('disabled', true);
                    }
                });

                // Actualizar el campo Localidad según el Departamento seleccionado
                $('#inmueble_departamento').on('change', function() {
                    const provinciaSeleccionada = $('#inmueble_provincia').val();
                    const departamentoSeleccionado = $(this).val();
                    const localidadSelect = $('#inmueble_localidad');

                    // Resetear el select de localidades
                    localidadSelect.empty().append('<option value="">Seleccione una localidad</option>');

                    if (provinciaSeleccionada && departamentoSeleccionado && ubicaciones[provinciaSeleccionada]?.departamentos[departamentoSeleccionado]) {
                        const localidades = ubicaciones[provinciaSeleccionada].departamentos[departamentoSeleccionado];
                        localidades.forEach(function(localidad) {
                            localidadSelect.append(`<option value="${localidad}">${localidad}</option>`);
                        });
                        localidadSelect.prop('disabled', false);
                    } else {
                        localidadSelect.prop('disabled', true);
                    }
                });

                // Actualizar el mapa
                function actualizarMapa() {
                    const provincia = $('#inmueble_provincia').val();
                    const departamento = $('#inmueble_departamento').val();
                    //const localidad = $('#inmueble_localidad').val();
                    const direccion = $('#inmueble_direccion').val();
                    const direccionCompleta = `${direccion}, ${departamento}, ${provincia}`;
                    const direccionUrl = encodeURIComponent(direccionCompleta);

                    // Actualizar el iframe del mapa
                    $('#map-iframe').attr('src', `https://www.google.com/maps?q=${direccionUrl}&output=embed`);
                }

                // Detectar cambios en los campos para actualizar el mapa
                $('#inmueble_provincia, #inmueble_departamento, #inmueble_localidad, #inmueble_direccion').on('input change', function() {
                    actualizarMapa();
                });
            });
        </script>

        <!-- Cargar Leaflet -->
        <!--<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
            jQuery(document).ready(function($) {
                const mapContainer = document.getElementById("map-leaflet");
                const direccionInput = document.getElementById("inmueble_direccion");
                const provinciaInput = document.getElementById("inmueble_provincia");
                const localidadInput = document.getElementById("inmueble_localidad");
                const departamentoInput = document.getElementById("inmueble_departamento");

                const defaultCoords = [-32.8908, -68.8272]; // Coordenadas por defecto
                let map = L.map(mapContainer).setView(defaultCoords, 13);
                let marker = L.marker(defaultCoords, { draggable: true }).addTo(map);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Geocodificar dirección escrita manualmente
                function geocodeAddress(address) {
                    const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`;
                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            if (data && data.length > 0) {
                                const lat = parseFloat(data[0].lat);
                                const lon = parseFloat(data[0].lon);
                                const latlng = [lat, lon];
                                map.setView(latlng, 16);
                                marker.setLatLng(latlng);
                            }
                        });
                }

                // Geocodificación inversa: del pin al domicilio
                function reverseGeocode(lat, lon) {
                    const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;
                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            if (data && data.display_name) {
                                direccionInput.value = data.display_name;
                            }
                        });
                }

                // Cuando arrastrás el marcador, actualiza la dirección
                marker.on('dragend', function(e) {
                    const coords = marker.getLatLng();
                    reverseGeocode(coords.lat, coords.lng);
                });


                provinciaInput.addEventListener("change", () => {
                    const provincia = provinciaInput.value;
                    if (provincia.trim() !== "" ) {
                        geocodeAddress(provincia);
                    }
                });

                departamentoInput.addEventListener("change", () => {
                    const departamento = departamentoInput.value;
                    if (departamento.trim() !== "" ) {
                        geocodeAddress(departamento);
                    }
                });

                localidadInput.addEventListener("change", () => {
                    const localidad = localidadInput.value;
                    if (localidad.trim() !== "" ) {
                        geocodeAddress(localidad);
                    }
                });

                // Cuando escribís una dirección, mové el marcador
                direccionInput.addEventListener("change", () => {
                    const direccion = direccionInput.value;
                    if (direccion.trim() !== "" ) {
                        geocodeAddress(direccion);
                    }
                });

                // Al cargar la página, si hay dirección ya guardada, colocá el pin
                const direccionInicial = direccionInput.value + ", " + localidadInput.value + ", " + departamentoInput.value + ", " + provinciaInput.value;
                if (direccionInicial.trim() !== "") {
                    geocodeAddress(direccionInicial);
                } else {
                    map.setView(defaultCoords, 13);
                    marker.setLatLng(defaultCoords);
                }
            }); 
        </script>-->



    <?php
    }

    // Guardar los Datos del Metabox: Ubicación
    function inmobiliaria_save_location_metabox($post_id)
    {
        // Lista de campos a guardar
        $fields = [
            'inmueble_provincia',
            'inmueble_departamento',
            'inmueble_localidad',
            'inmueble_direccion'
        ];

        foreach ($fields as $field) {
            if (array_key_exists($field, $_POST)) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    add_action('save_post', 'inmobiliaria_save_location_metabox');

// =========================
// METABOX: FIN UBICACIÓN DEL INMUEBLE
// =========================    



// =========================
// METABOX: ACTIVAR EL INMUEBLE
// =========================

function agregar_checkbox_publicado_meta_box() {
    add_meta_box(
        'publicado_inmueble_meta_box', // ID
        'Estado de Publicación', // Título
        'mostrar_checkbox_publicado_meta_box', // Callback
        'inmueble', // Post type
        'side', // Contexto (sidebar)
        'high' // Prioridad
    );
}
add_action('add_meta_boxes', 'agregar_checkbox_publicado_meta_box');

function mostrar_checkbox_publicado_meta_box($post) {
    // Obtener el valor actual
    $publicado = get_post_meta($post->ID, '_publicado_inmueble', true);

    // Mostrar el checkbox
    ?>
    <label>
        <input type="checkbox" name="publicado_inmueble" value="1" <?php checked($publicado, '1'); ?> />
        ¿Activo para mostrar?
    </label>
    <?php
}
function guardar_checkbox_publicado_inmueble($post_id) {
    // Verificar el tipo de post
    if (get_post_type($post_id) !== 'inmueble') {
        return;
    }

    // Guardar el valor (1 si está marcado, 0 si no)
    $publicado = isset($_POST['publicado_inmueble']) ? '1' : '0';
    update_post_meta($post_id, '_publicado_inmueble', $publicado);
}
add_action('save_post', 'guardar_checkbox_publicado_inmueble');

// =========================
// METABOX: FIN ACTIVAR EL INMUEBLE
// =========================


// =========================
// METABOX: DATOS DEL INMUEBLE
// =========================

    // Registrar el Metabox: Datos de la Propiedad
    function inmobiliaria_add_property_details_metabox()
    {
        add_meta_box(
            'property_details', // ID del metabox
            'Datos del Inmueble', // Título del metabox
            'inmobiliaria_render_property_details_metabox', // Función de renderizado
            'inmueble', // Tipo de post
            'normal', // Contexto (normal, side, etc.)
            'high' // Prioridad
        );
    }
    add_action('add_meta_boxes', 'inmobiliaria_add_property_details_metabox');

    // Renderizar el Metabox: Datos de la Propiedad
    function inmobiliaria_render_property_details_metabox($post)
    {
        // Recuperar valores previos
        $tipo = get_post_meta($post->ID, '_property_tipo', true);
        $condicion = get_post_meta($post->ID, '_property_condicion', true);
        $precio_pesos = get_post_meta($post->ID, '_property_precio_pesos', true);
        $precio_usd = get_post_meta($post->ID, '_property_precio_usd', true);
        $ocultar_precio = get_post_meta($post->ID, '_property_ocultar_precio', true);

        // Generar el HTML del metabox
        ?>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <!-- Tipo -->
                    <div class="campos">
                        <p style="margin-bottom: 6px;"><label for="property_tipo">Tipo <strong>(Requerido)</strong></label></p>
                        <select id="property_tipo" name="property_tipo" required style="width: 100%;">
                            <option disabled selected="selected">Elegir inmueble</option>
                            <option value="Casa" <?php selected($tipo, 'Casa'); ?>>Casa</option>
                            <option value="Departamento" <?php selected($tipo, 'Departamento'); ?>>Departamento</option>
                            <option value="Lote" <?php selected($tipo, 'Lote'); ?>>Lote</option>
                            <option value="Bodega" <?php selected($tipo, 'Bodega'); ?>>Bodega</option>
                            <option value="Bodega con Vinedo" <?php selected($tipo, 'Bodega con Vinedo'); ?>>Bodega con Viñedo</option>
                            <option value="Cabana" <?php selected($tipo, 'Cabana'); ?>>Cabaña</option>
                            <option value="Campo" <?php selected($tipo, 'Campo'); ?>>Campo</option>
                            <option value="Chalet" <?php selected($tipo, 'Chalet'); ?>>Chalet</option>
                            <option value="Cochera" <?php selected($tipo, 'Cochera'); ?>>Cochera</option>
                            <option value="Condominio" <?php selected($tipo, 'Condominio'); ?>>Condominio</option>
                            <option value="Deposito" <?php selected($tipo, 'Deposito'); ?>>Deposito</option>
                            <option value="Duplex" <?php selected($tipo, 'Duplex'); ?>>Duplex</option>
                            <option value="Edificio" <?php selected($tipo, 'Edificio'); ?>>Edificio</option>
                            <option value="Estacion de Servicio" <?php selected($tipo, 'Estacion de Servicio'); ?>>Estacion de Servicio</option>
                            <option value="Fabrica" <?php selected($tipo, 'Fabrica'); ?>>Fábrica</option>
                            <option value="Finca" <?php selected($tipo, 'Finca'); ?>>Finca</option>
                            <option value="Fondo de Comercio" <?php selected($tipo, 'Fondo de Comercio'); ?>>Fondo de Comercio</option>
                            <option value="Fraccionamiento" <?php selected($tipo, 'Fraccionamiento'); ?>>Fraccionamiento</option>
                            <option value="Galpon" <?php selected($tipo, 'Galpon'); ?>>Galpon</option>
                            <option value="Hotel" <?php selected($tipo, 'Hotel'); ?>>Hotel</option>
                            <option value="Industria" <?php selected($tipo, 'Industria'); ?>>Industria</option>
                            <option value="Local Comercial" <?php selected($tipo, 'Local Comercial'); ?>>Local Comercial</option>
                            <option value="Loft" <?php selected($tipo, 'Loft'); ?>>Loft</option>
                            <option value="Loteo" <?php selected($tipo, 'Loteo'); ?>>Loteo</option>
                            <option value="Negocio" <?php selected($tipo, 'Negocio'); ?>>Negocio</option>
                            <option value="Oficina" <?php selected($tipo, 'Oficina'); ?>>Oficina</option>
                            <option value="PH" <?php selected($tipo, 'PH'); ?>>P H</option>
                            <option value="Piso" <?php selected($tipo, 'Piso'); ?>>Piso</option>
                            <option value="Playa de Estacionamiento" <?php selected($tipo, 'Playa de Estacionamiento'); ?>></option>
                            <option value="Quinta" <?php selected($tipo, 'Quinta'); ?>>Quinta</option>
                            <option value="Semipiso" <?php selected($tipo, 'Semipiso'); ?>>Semipiso</option>
                            <option value="Terreno" <?php selected($tipo, 'Terreno'); ?>>Terreno</option>
                            <option value="Triplex" <?php selected($tipo, 'Triplex'); ?>>Triplex</option>
                            <option value="Vinedo" <?php selected($tipo, 'Vinedo'); ?>>Viñedo</option>
                        </select>
                    </div>

                    <!-- Condición -->
                    <div class="campos">
                        <p style="margin-bottom: 6px;"><label for="property_condicion">Condición <strong>(Requerido)</strong></label></p>
                        <select id="property_condicion" name="property_condicion" required style="width: 100%;">
                            <option disabled selected="selected">Elegir Condición</option>
                            <option value="Venta" <?php selected($condicion, 'Venta'); ?>>Venta</option>
                            <option value="Alquiler" <?php selected($condicion, 'Alquiler'); ?>>Alquiler</option>
                            <option value="Alquiler Temporario" <?php selected($condicion, 'Alquiler Temporario'); ?>>Alquiler Temporario</option>
                            <option value="Permuta" <?php selected($condicion, 'Permuta'); ?>>Permuta</option>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <!-- Precio en pesos -->
                        <div class="campos">
                            <p style="margin-bottom: 6px;"><label for="property_precio_pesos">Precio ($)</label></p>
                            <input type="number" id="property_precio_pesos" name="property_precio_pesos" value="<?php echo esc_attr($precio_pesos); ?>" style="width: 100%;" />
                        </div>

                        <!-- Precio en dólares -->
                        <div class="campos">
                            <p style="margin-bottom: 6px;"><label for="property_precio_usd">Precio (US$)</label></p>
                            <input type="number" id="property_precio_usd" name="property_precio_usd" value="<?php echo esc_attr($precio_usd); ?>" style="width: 100%;" />
                        </div>
                    </div>

                    <!-- Ocultar precio -->
                    <div class="campos">
                        <p><input type="checkbox" id="property_ocultar_precio" name="property_ocultar_precio" value="1" <?php checked($ocultar_precio, '1'); ?> />
                            <label for="property_ocultar_precio">Ocultar Precio</label>
                        </p>
                    </div>
                </div>

                <!-- Descripción -->
                <div>
                    <p style="margin-bottom: 6px;"><label for="property_descripcion">Descripción <strong>(Requerido)</strong></label></p>
                    <textarea id="property_descripcion" name="property_descripcion" style="width: 100%; height: 300px;" required><?php echo esc_textarea(get_post_meta($post->ID, '_property_descripcion', true)); ?></textarea>
                </div>
            </div>
        <?php
    }

    // Guardar los Datos del Metabox
    function inmobiliaria_save_property_details($post_id)
    {
        // Lista de campos a guardar
        $fields = [
            'property_tipo',
            'property_condicion',
            'property_precio_pesos',
            'property_precio_usd',
            'property_ocultar_precio',
            'inmueble_direccion',  // Dirección
            'inmueble_departamento', // Departamento
            'inmueble_provincia'   // Provincia
        ];

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $value = sanitize_text_field($_POST[$field]);
                if ($field === 'property_ocultar_precio') {
                    $value = $_POST[$field] === '1' ? '1' : '0';
                }
                update_post_meta($post_id, '_' . $field, $value);
            } else if ($field === 'property_ocultar_precio') {
                // Si el checkbox no está marcado, guardar '0'
                update_post_meta($post_id, '_property_ocultar_precio', '0');
            }
        }
        // Guardar la descripción con espacios y HTML permitido
        if (isset($_POST['property_descripcion'])) {
            update_post_meta($post_id, '_property_descripcion', wp_kses_post($_POST['property_descripcion']));
        }

        // Generar y guardar el título dinámico
        $tipo = get_post_meta($post_id, '_property_tipo', true);
        $condicion = get_post_meta($post_id, '_property_condicion', true);
        $direccion = get_post_meta($post_id, '_inmueble_direccion', true);
        $departamento = get_post_meta($post_id, '_inmueble_departamento', true);
        $provincia = get_post_meta($post_id, '_inmueble_provincia', true);

        // Dividir el título en dos partes
        $titulo_parte_1 = $condicion . ' de ' . $tipo; // Ejemplo: "Venta de Casa"
        $titulo_parte_2 = $direccion . ', ' . $departamento . ', ' . $provincia; // Ejemplo: "Calle Falsa 123, Departamento, Provincia"

        // Guardar las dos partes del título como un array en el metadato
        $titulo_completo = [
            'parte_1' => $titulo_parte_1,
            'parte_2' => $titulo_parte_2,
        ];
        update_post_meta($post_id, '_inmueble_titulo', $titulo_completo);

    }
    add_action('save_post', 'inmobiliaria_save_property_details');

// =========================
// METABOX: FIN DATOS DEL INMUEBLE
// =========================


// =========================
// METABOX: SERVICIOS
// =========================

    // Registrar el Metabox: Servicios
    function inmobiliaria_add_services_metabox()
    {
        add_meta_box(
            'inmueble_services',              // ID del metabox
            'Servicios del Inmueble',         // Título
            'inmobiliaria_render_services',   // Función de renderizado
            'inmueble',                       // Tipo de post
            'normal',                         // Contexto
            'high'                            // Prioridad
        );
    }
    add_action('add_meta_boxes', 'inmobiliaria_add_services_metabox');

    // Renderizar el Metabox: Servicios
    function inmobiliaria_render_services($post)
    {
        // Recuperar valores guardados
        $tipo = get_post_meta($post_id, '_property_tipo', true);
        $aire_acondicionado = get_post_meta($post->ID, '_inmueble_aire_acondicionado', true);
        $amoblado = get_post_meta($post->ID, '_inmueble_amoblado', true);
        $antiguedad = get_post_meta($post->ID, '_inmueble_antiguedad', true);
        $apto_credito = get_post_meta($post->ID, '_inmueble_apto_credito', true);
        $banos = get_post_meta($post->ID, '_inmueble_banos', true);
        $mascotas = get_post_meta($post->ID, '_inmueble_mascotas', true);
        $barrio_privado = get_post_meta($post->ID, '_inmueble_barrio_privado', true);
        $cable_tv = get_post_meta($post->ID, '_inmueble_cable_tv', true);
        $calefaccion_central = get_post_meta($post->ID, '_inmueble_calefaccion_central', true);
        $cantidad_de_ambientes = get_post_meta($post->ID, '_inmueble_cantidad_de_ambientes', true);
        $cochera = get_post_meta($post->ID, '_inmueble_cochera', true);
        $dormitorios = get_post_meta($post->ID, '_inmueble_dormitorios', true);
        $estado_conservacion = get_post_meta($post->ID, '_inmueble_estado_conservacion', true);
        $financiacion = get_post_meta($post->ID, '_inmueble_financiacion', true);
        $internet = get_post_meta($post->ID, '_inmueble_internet', true);
        $piscina = get_post_meta($post->ID, '_inmueble_piscina', true);
        $plantas = get_post_meta($post->ID, '_inmueble_plantas', true);
        $superficie_cubierta = get_post_meta($post->ID, '_inmueble_superficie_cubierta', true);
        $superficie_total = get_post_meta($post->ID, '_inmueble_superficie_total', true);
        $hectareas = get_post_meta($post->ID, '_inmueble_hectareas', true);
        $telefono = get_post_meta($post->ID, '_inmueble_telefono', true);
        $tiene_expensas = get_post_meta($post->ID, '_inmueble_tiene_expensas', true);
        $zona_escolar = get_post_meta($post->ID, '_inmueble_zona_escolar', true);
        $recibe_permuta = get_post_meta($post->ID, '_inmueble_recibe_permuta', true);


        ?>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_aire_acondicionado">Aire Acondicionado:</label><br>
                            <select id="inmueble_aire_acondicionado" name="inmueble_aire_acondicionado" style="width: 100%;">
                                <option value="Indistinto" <?php selected($aire_acondicionado, 'Indistinto'); ?>>Indistinto</option>
                                <option value="No" <?php selected($aire_acondicionado, 'No'); ?>>No</option>
                                <option value="Sí" <?php selected($aire_acondicionado, 'Sí'); ?>>Sí</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_amoblado">Amoblado/a:</label><br>
                            <select id="inmueble_amoblado" name="inmueble_amoblado" style="width: 100%;">
                                <option value="Indistinto" <?php selected($amoblado, 'Indistinto'); ?>>Indistinto</option>
                                <option value="No" <?php selected($amoblado, 'No'); ?>>No</option>
                                <option value="Sí" <?php selected($amoblado, 'Sí'); ?>>Sí</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_antiguedad">Antigüedad <strong>(Requerido)</strong></label><br>
                            <select id="inmueble_antiguedad" name="inmueble_antiguedad" required style="width: 100%;">
                                <option disabled selected="selected">Seleccionar</option>
                                <option value="Indistinto" <?php selected($antiguedad, 'Indistinto'); ?>>Indistinto</option>
                                <option value="A Estrenar" <?php selected($antiguedad, 'A Estrenar'); ?>>A Estrenar</option>
                                <option value="6 Meses" <?php selected($antiguedad, '6 Meses'); ?>>6 Meses</option>
                                <option value="1 Año" <?php selected($antiguedad, '1 Año'); ?>>1 Año</option>
                                <option value="1 Año y medio" <?php selected($antiguedad, '1 Año y medio'); ?>>1 Año y medio</option>
                                <option value="2 Años" <?php selected($antiguedad, '2 Años'); ?>>2 Años</option>
                                <option value="3 Años" <?php selected($antiguedad, '3 Años'); ?>>3 Años</option>
                                <option value="4 Años" <?php selected($antiguedad, '4 Años'); ?>>4 Años</option>
                                <option value="5 Años" <?php selected($antiguedad, '5 Años'); ?>>5 Años</option>
                                <option value="6 Años" <?php selected($antiguedad, '6 Años'); ?>>6 Años</option>
                                <option value="7 Años" <?php selected($antiguedad, '7 Años'); ?>>7 Años</option>
                                <option value="8 Años" <?php selected($antiguedad, '8 Años'); ?>>8 Años</option>
                                <option value="9 Años" <?php selected($antiguedad, '9 Años'); ?>>9 Años</option>
                                <option value="10 Años" <?php selected($antiguedad, '10 Años'); ?>>10 Años</option>
                                <option value="11 Años" <?php selected($antiguedad, '11 Años'); ?>>11 Años</option>
                                <option value="12 Años" <?php selected($antiguedad, '12 Años'); ?>>12 Años</option>
                                <option value="13 Años" <?php selected($antiguedad, '13 Años'); ?>>13 Años</option>
                                <option value="14 Años" <?php selected($antiguedad, '14 Años'); ?>>14 Años</option>
                                <option value="15 Años" <?php selected($antiguedad, '15 Años'); ?>>15 Años</option>
                                <option value="16 Años" <?php selected($antiguedad, '16 Años'); ?>>16 Años</option>
                                <option value="17 Años" <?php selected($antiguedad, '17 Años'); ?>>17 Años</option>
                                <option value="18 Años" <?php selected($antiguedad, '18 Años'); ?>>18 Años</option>
                                <option value="19 Años" <?php selected($antiguedad, '19 Años'); ?>>19 Años</option>
                                <option value="20 Años" <?php selected($antiguedad, '20 Años'); ?>>20 Años</option>
                                <option value="21 Años" <?php selected($antiguedad, '21 Años'); ?>>21 Años</option>
                                <option value="22 Años" <?php selected($antiguedad, '22 Años'); ?>>22 Años</option>
                                <option value="23 Años" <?php selected($antiguedad, '23 Años'); ?>>23 Años</option>
                                <option value="24 Años" <?php selected($antiguedad, '24 Años'); ?>>24 Años</option>
                                <option value="25 Años" <?php selected($antiguedad, '25 Años'); ?>>25 Años</option>
                                <option value="26 Años" <?php selected($antiguedad, '26 Años'); ?>>26 Años</option>
                                <option value="27 Años" <?php selected($antiguedad, '27 Años'); ?>>27 Años</option>
                                <option value="28 Años" <?php selected($antiguedad, '28 Años'); ?>>28 Años</option>
                                <option value="29 Años" <?php selected($antiguedad, '29 Años'); ?>>29 Años</option>
                                <option value="30 Años" <?php selected($antiguedad, '30 Años'); ?>>30 Años</option>
                                <option value="31 Años" <?php selected($antiguedad, '31 Años'); ?>>31 Años</option>
                                <option value="32 Años" <?php selected($antiguedad, '32 Años'); ?>>32 Años</option>
                                <option value="33 Años" <?php selected($antiguedad, '33 Años'); ?>>33 Años</option>
                                <option value="34 Años" <?php selected($antiguedad, '34 Años'); ?>>34 Años</option>
                                <option value="35 Años" <?php selected($antiguedad, '35 Años'); ?>>35 Años</option>
                                <option value="36 Años" <?php selected($antiguedad, '36 Años'); ?>>36 Años</option>
                                <option value="37 Años" <?php selected($antiguedad, '37 Años'); ?>>37 Años</option>
                                <option value="38 Años" <?php selected($antiguedad, '38 Años'); ?>>38 Años</option>
                                <option value="39 Años" <?php selected($antiguedad, '39 Años'); ?>>39 Años</option>
                                <option value="40 Años" <?php selected($antiguedad, '40 Años'); ?>>40 Años</option>
                                <option value="41 Años" <?php selected($antiguedad, '41 Años'); ?>>41 Años</option>
                                <option value="42 Años" <?php selected($antiguedad, '42 Años'); ?>>42 Años</option>
                                <option value="43 Años" <?php selected($antiguedad, '43 Años'); ?>>43 Años</option>
                                <option value="44 Años" <?php selected($antiguedad, '44 Años'); ?>>44 Años</option>
                                <option value="45 Años" <?php selected($antiguedad, '45 Años'); ?>>45 Años</option>
                                <option value="46 Años" <?php selected($antiguedad, '46 Años'); ?>>46 Años</option>
                                <option value="47 Años" <?php selected($antiguedad, '47 Años'); ?>>47 Años</option>
                                <option value="48 Años" <?php selected($antiguedad, '48 Años'); ?>>48 Años</option>
                                <option value="49 Años" <?php selected($antiguedad, '49 Años'); ?>>49 Años</option>
                                <option value="50 Años" <?php selected($antiguedad, '50 Años'); ?>>50 Años</option>
                                <option value="Mas de 50 Años" <?php selected($antiguedad, 'Mas de 50 Años'); ?>>Mas de 50 Años</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_apto_credito">Apto Crédito Hipotecario:</label><br>
                            <select id="inmueble_apto_credito" name="inmueble_apto_credito" style="width: 100%;">
                                <option value="Indistinto" <?php selected($apto_credito, 'Indistinto'); ?>>Indistinto</option>
                                <option value="No" <?php selected($apto_credito, 'No'); ?>>No</option>
                                <option value="Sí" <?php selected($apto_credito, 'Sí'); ?>>Sí</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_banos">Baños <strong>(Requerido)</strong></label><br>
                            <select id="inmueble_banos" name="inmueble_banos" style="width: 100%;" required>
                                <option disabled selected="selected">Seleccionar</option>
                                <option value="Indistinto" <?php selected($banos, 'Indistinto'); ?>>Indistinto</option>
                                <option value="1" <?php selected($banos, '1'); ?>>1</option>
                                <option value="2" <?php selected($banos, '2'); ?>>2</option>
                                <option value="3" <?php selected($banos, '3'); ?>>3</option>
                                <option value="3" <?php selected($banos, '3'); ?>>3</option>
                                <option value="4" <?php selected($banos, '4'); ?>>4</option>
                                <option value="5" <?php selected($banos, '5'); ?>>5</option>
                                <option value="6" <?php selected($banos, '6'); ?>>6</option>
                                <option value="7" <?php selected($banos, '7'); ?>>7</option>
                                <option value="8" <?php selected($banos, '8'); ?>>8</option>
                                <option value="9" <?php selected($banos, '9'); ?>>9</option>
                                <option value="10 o Mas" <?php selected($banos, '10 o Mas'); ?>>10 o Mas</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_mascotas">Mascotas:</label><br>
                            <select id="inmueble_mascotas" name="inmueble_mascotas" style="width: 100%;">
                                <option value="Indistinto" <?php selected($mascotas, 'Indistinto'); ?>>Indistinto</option>
                                <option value="No" <?php selected($mascotas, 'No'); ?>>No</option>
                                <option value="Sí" <?php selected($mascotas, 'Sí'); ?>>Sí</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_barrio_privado">Barrio Privado:</label><br>
                            <select id="inmueble_barrio_privado" name="inmueble_barrio_privado" style="width: 100%;">
                                <option value="Indistinto" <?php selected($barrio_privado, 'Indistinto'); ?>>Indistinto</option>
                                <option value="No" <?php selected($barrio_privado, 'No'); ?>>No</option>
                                <option value="Sí" <?php selected($barrio_privado, 'Sí'); ?>>Sí</option>
                                <option value="Semi Privado" <?php selected($barrio_privado, 'Semi Privado'); ?>>Semi Privado</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_cable_tv">Cable TV:</label><br>
                            <select id="inmueble_cable_tv" name="inmueble_cable_tv" style="width: 100%;">
                                <option value="Indistinto" <?php selected($cable_tv, 'Indistinto'); ?>>Indistinto</option>
                                <option value="No" <?php selected($cable_tv, 'No'); ?>>No</option>
                                <option value="Sí" <?php selected($cable_tv, 'Sí'); ?>>Sí</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_calefaccion_central">Calefacción Central:</label><br>
                            <select id="inmueble_calefaccion_central" name="inmueble_calefaccion_central" style="width: 100%;">
                                <option value="Indistinto" <?php selected($calefaccion_central, 'Indistinto'); ?>>Indistinto</option>
                                <option value="No" <?php selected($calefaccion_central, 'No'); ?>>No</option>
                                <option value="Sí" <?php selected($calefaccion_central, 'Sí'); ?>>Sí</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_cantidad_de_ambientes">Cantidad de Ambientes: </label><br>
                            <select id="inmueble_cantidad_de_ambientes" name="inmueble_cantidad_de_ambientes" style="width: 100%;">
                                <option value="Indistinto" <?php selected($cantidad_de_ambientes, 'Indistinto'); ?>>Indistinto</option>
                                <option value="Monoambiente" <?php selected($cantidad_de_ambientes, 'Monoambiente'); ?>>Monoambiente</option>
                                <option value="2" <?php selected($cantidad_de_ambientes, '2'); ?>>2</option>
                                <option value="3" <?php selected($cantidad_de_ambientes, '3'); ?>>3</option>
                                <option value="4" <?php selected($cantidad_de_ambientes, '4'); ?>>4</option>
                                <option value="5" <?php selected($cantidad_de_ambientes, '5'); ?>>5</option>
                                <option value="6 o mas" <?php selected($cantidad_de_ambientes, '6 o mas'); ?>>6 o mas</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_cochera">Cochera <strong>(Requerido)</strong> </label><br>
                            <select id="inmueble_cochera" name="inmueble_cochera" style="width: 100%;" required>
                                <option disabled selected="selected">Seleccionar</option>
                                <option value="Indistinto" <?php selected($cochera, 'Indistinto'); ?>>Indistinto</option>
                                <option value="Garage" <?php selected($cochera, 'Garage'); ?>>Garage</option>
                                <option value="Garage Cochera" <?php selected($cochera, 'Garage Cochera'); ?>>Garage/Cochera</option>
                                <option value="Garage Doble" <?php selected($cochera, 'Garage Doble'); ?>>Garage Doble</option>
                                <option value="Cochera Pasante" <?php selected($cochera, 'Cochera Pasante'); ?>>Cochera Pasante</option>
                                <option value="Sin Cochera" <?php selected($cochera, 'Sin Cochera'); ?>>Sin Cochera</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_dormitorios">Dormitorios <strong>(Requerido)</strong> </label><br>
                            <select id="inmueble_dormitorios" name="inmueble_dormitorios" style="width: 100%;" required>
                                <option disabled selected="selected">Seleccionar</option>
                                <option value="Indistinto" <?php selected($dormitorios, 'Indistinto'); ?>>Indistinto</option>
                                <option value="1" <?php selected($dormitorios, '1'); ?>>1</option>
                                <option value="2" <?php selected($dormitorios, '2'); ?>>2</option>
                                <option value="3" <?php selected($dormitorios, '3'); ?>>3</option>
                                <option value="4" <?php selected($dormitorios, '4'); ?>>4</option>
                                <option value="5" <?php selected($dormitorios, '5'); ?>>5</option>
                                <option value="6" <?php selected($dormitorios, '6'); ?>>6</option>
                                <option value="7" <?php selected($dormitorios, '7'); ?>>7</option>
                                <option value="8" <?php selected($dormitorios, '8'); ?>>8</option>
                                <option value="9" <?php selected($dormitorios, '9'); ?>>9</option>
                                <option value="10 o Mas" <?php selected($dormitorios, '10 o Mas'); ?>>10 o Mas</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_estado_conservacion">Estado de Conservación <strong>(Requerido)</strong></label><br>
                            <select id="inmueble_estado_conservacion" name="inmueble_estado_conservacion" style="width: 100%;" required>
                                <option disabled selected="selected">Seleccionar</option>
                                <option value="Indistinto" <?php selected($estado_conservacion, 'Indistinto'); ?>>Indistinto</option>
                                <option value="Excelente" <?php selected($estado_conservacion, 'Excelente'); ?>>Excelente</option>
                                <option value="Muy Bueno" <?php selected($estado_conservacion, 'Muy Bueno'); ?>>Muy Bueno</option>
                                <option value="Bueno" <?php selected($estado_conservacion, 'Bueno'); ?>>Bueno</option>
                                <option value="Regular" <?php selected($estado_conservacion, 'Regular'); ?>>Regular</option>
                            </select>
                        </p>
                    </div>
                </div>

                <div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_financiacion">Financiación:</label><br>
                            <select id="inmueble_financiacion" name="inmueble_financiacion" style="width: 100%;">
                                <option value="Indistinto" <?php selected($financiacion, 'Indistinto'); ?>>Indistinto</option>
                                <option value="No" <?php selected($financiacion, 'No'); ?>>No</option>
                                <option value="Sí" <?php selected($financiacion, 'Sí'); ?>>Sí</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_internet">Internet:</label><br>
                            <select id="inmueble_internet" name="inmueble_internet" style="width: 100%;">
                                <option value="Indistinto" <?php selected($internet, 'Indistinto'); ?>>Indistinto</option>
                                <option value="No" <?php selected($internet, 'No'); ?>>No</option>
                                <option value="Sí" <?php selected($internet, 'Sí'); ?>>Sí</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_piscina">Piscina:</label><br>
                            <select id="inmueble_piscina" name="inmueble_piscina" style="width: 100%;">
                                <option value="Indistinto" <?php selected($piscina, 'Indistinto'); ?>>Indistinto</option>
                                <option value="No" <?php selected($piscina, 'No'); ?>>No</option>
                                <option value="Sí" <?php selected($piscina, 'Sí'); ?>>Sí</option>
                            </select>
                        </p>
                    </div>
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_plantas">Plantas:</label><br>
                            <select id="inmueble_plantas" name="inmueble_plantas" style="width: 100%;">
                                <option value="Indistinto" <?php selected($plantas, 'Indistinto'); ?>>Indistinto</option>
                                <option value="1 Planta" <?php selected($plantas, '1 Planta'); ?>>1 Planta</option>
                                <option value="2 Plantas" <?php selected($plantas, '2 Plantas'); ?>>2 Plantas</option>
                                <option value="3 Plantas" <?php selected($plantas, '3 Plantas'); ?>>3 Plantas</option>
                                <option value="4 Plantas" <?php selected($plantas, '4 Plantas'); ?>>4 Plantas</option>
                                <option value="5 Plantas" <?php selected($plantas, '5 Plantas'); ?>>5 Plantas</option>
                                <option value="6 Plantas" <?php selected($plantas, '6 Plantas'); ?>>6 Plantas</option>
                                <option value="7 Plantas" <?php selected($plantas, '7 Plantas'); ?>>7 Plantas</option>
                                <option value="8 Plantas" <?php selected($plantas, '8 Plantas'); ?>>8 Plantas</option>
                                <option value="9 Plantas" <?php selected($plantas, '9 Plantas'); ?>>9 Plantas</option>
                                <option value="10 o Mas Plantas" <?php selected($plantas, '10 o Mas Plantas'); ?>>10 o Mas Plantas</option>
                            </select>
                        </p>
                    </div>

                    <div class="campos">
                        <p style="margin-bottom: 6px;"><label for="inmueble_hectareas">Hectareas <strong></strong></label></p>
                        <input type="number" id="inmueble_hectareas" name="inmueble_hectareas" value="<?php echo esc_attr($hectareas); ?>" style="width: 100%;" />
                    </div>
  
                    <div class="campos">
                        <p style="margin-bottom: 6px;"><label for="inmueble_superficie_cubierta">Superficie Cubierta m2 <strong></strong></label></p>
                        <input type="number" id="inmueble_superficie_cubierta" name="inmueble_superficie_cubierta" value="<?php echo esc_attr($superficie_cubierta); ?>" style="width: 100%;" />
                    </div>

                    <div class="campos">
                        <p style="margin-bottom: 6px;"><label for="inmueble_superficie_total">Superficie Total m2 <strong></strong></label></p>
                        <input type="number" id="inmueble_superficie_total" name="inmueble_superficie_total" value="<?php echo esc_attr($superficie_total); ?>" style="width: 100%;"/>
                    </div>

                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_telefono">Teléfono:</label><br>
                            <select id="inmueble_telefono" name="inmueble_telefono" style="width: 100%;">
                                <option value="Indistinto" <?php selected($telefono, 'Indistinto'); ?>>Indistinto</option>
                                <option value="No" <?php selected($telefono, 'No'); ?>>No</option>
                                <option value="Sí" <?php selected($telefono, 'Sí'); ?>>Sí</option>
                            </select>
                        </p>
                    </div>

                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_tiene_expensas">Tiene Expensas <strong>(Requerido)</strong></label><br>
                            <select id="inmueble_tiene_expensas" name="inmueble_tiene_expensas" style="width: 100%;">
                                <option disabled selected="selected">Seleccionar</option>
                                <option value="Indistinto" <?php selected($tiene_expensas, 'Indistinto'); ?>>Indistinto</option>
                                <option value="No" <?php selected($tiene_expensas, 'No'); ?>>No</option>
                                <option value="Sí" <?php selected($tiene_expensas, 'Sí'); ?>>Sí</option>
                            </select>
                        </p>
                    </div>

                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_zona_escolar">Zona Escolar:</label><br>
                            <select id="inmueble_zona_escolar" name="inmueble_zona_escolar" style="width: 100%;">
                                <option value="Indistinto" <?php selected($zona_escolar, 'Indistinto'); ?>>Indistinto</option>
                                <option value="No" <?php selected($zona_escolar, 'No'); ?>>No</option>
                                <option value="Sí" <?php selected($zona_escolar, 'Sí'); ?>>Sí</option>
                            </select>
                        </p>
                    </div>
                    
                    <div class="campos">
                        <p style="margin-bottom:6px;">
                            <label for="inmueble_recibe_permuta">¿Recibe Permuta?</label><br>
                            <select id="inmueble_recibe_permuta" name="inmueble_recibe_permuta" style="width: 100%;">
                            <option value="Indistinto" <?php selected($recibe_permuta, 'Indistinto'); ?>>Indistinto</option>
                                <option value="No" <?php selected($recibe_permuta, 'No'); ?>>No</option>
                                <option value="Sí" <?php selected($recibe_permuta, 'Sí'); ?>>Sí</option>
                            </select>
                        </p>
                    </div>
                </div>
            </div>

        <?php
    }

    // Guardar los datos del Metabox: Servicios
    function inmobiliaria_save_services($post_id)
    {
        $fields = [
            'inmueble_aire_acondicionado',
            'inmueble_amoblado',
            'inmueble_antiguedad',
            'inmueble_apto_credito',
            'inmueble_banos',
            'inmueble_mascotas',
            'inmueble_barrio_privado',
            'inmueble_cable_tv',
            'inmueble_calefaccion_central',
            'inmueble_cantidad_de_ambientes',
            'inmueble_cochera',
            'inmueble_dormitorios',
            'inmueble_estado_conservacion',
            'inmueble_financiacion',
            'inmueble_internet',
            'inmueble_piscina',
            'inmueble_plantas',
            'inmueble_superficie_cubierta',
            'inmueble_superficie_total',
            'inmueble_hectareas',
            'inmueble_telefono',
            'inmueble_tiene_expensas',
            'inmueble_zona_escolar',
            'inmueble_recibe_permuta',
        ];

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    add_action('save_post', 'inmobiliaria_save_services');

// =========================
// METABOX: FIN SERVICIOS
// =========================



// =========================
// METABOX: GALERIA DE IMÁGENES
// =========================

    // Registrar el metabox de imágenes
    function inmobiliaria_add_images_metabox() {
        add_meta_box(
            'inmueble_images',
            'Imágenes del Inmueble',
            'inmobiliaria_render_images_metabox',
            'inmueble',
            'normal',
            'high'
        );
    }
    add_action('add_meta_boxes', 'inmobiliaria_add_images_metabox');

    // Renderizar el metabox
    function inmobiliaria_render_images_metabox($post) {
        // Recuperar imágenes existentes (IDs de la biblioteca de medios)
        $images = get_post_meta($post->ID, '_inmueble_images', true);

        // Convertir en array si no lo es
        $images = is_array($images) ? $images : array();
        ?>
        <div id="inmueble-images-container">
            <ul id="inmueble-images-list" style="list-style: none; padding: 0; margin: 0;">
                <?php foreach ($images as $image_id) : ?>
                    <li data-id="<?php echo $image_id; ?>" style="margin-bottom: 10px; border: 1px solid #ddd; padding: 10px; display: flex; align-items: center;">
                        <?php echo wp_get_attachment_image($image_id, 'thumbnail', false, array('style' => 'margin-right: 10px;')); ?>
                        <input type="text" name="inmueble_image_descriptions[<?php echo $image_id; ?>]" value="<?php echo esc_attr(get_post_meta($image_id, '_image_description', true)); ?>" placeholder="Descripción de la imagen" style="flex-grow: 1; margin-right: 10px;" />
                        <button type="button" class="remove-image-button button">Eliminar</button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <button type="button" id="add-inmueble-image" class="button">Agregar Imágenes</button>
        <input type="hidden" id="inmueble-images-field" name="inmueble_images" value="<?php echo esc_attr(implode(',', $images)); ?>">
        <p style="margin-top: 10px;">Puedes cambiar el orden arrastrando las imágenes.</p>

        <script>
        jQuery(document).ready(function($) {
            let frame;
            const container = $('#inmueble-images-container');
            const imageList = $('#inmueble-images-list');
            const field = $('#inmueble-images-field');

            // Abrir el Media Uploader
            $('#add-inmueble-image').on('click', function(e) {
                e.preventDefault();

                if (frame) {
                    frame.open();
                    return;
                }

                frame = wp.media({
                    title: 'Seleccionar Imágenes',
                    button: { text: 'Añadir imágenes' },
                    multiple: true
                });

                frame.on('select', function() {
                    const attachments = frame.state().get('selection').toJSON();
                    attachments.forEach(function(attachment) {
                        imageList.append(`
                            <li data-id="${attachment.id}" style="margin-bottom: 10px; border: 1px solid #ddd; padding: 10px; display: flex; align-items: center;">
                                <img src="${attachment.sizes.thumbnail.url}" style="margin-right: 10px;">
                                <input type="text" name="inmueble_image_descriptions[${attachment.id}]" placeholder="Descripción de la imagen" style="flex-grow: 1; margin-right: 10px;">
                                <button type="button" class="remove-image-button button">Eliminar</button>
                            </li>
                        `);
                    });
                    updateField();
                });

                frame.open();
            });

            // Eliminar una imagen
            container.on('click', '.remove-image-button', function() {
                $(this).closest('li').remove();
                updateField();
            });

            // Reordenar imágenes
            imageList.sortable({
                update: function() {
                    updateField();
                }
            });

            // Actualizar el campo oculto
            function updateField() {
                const ids = [];
                imageList.find('li').each(function() {
                    ids.push($(this).data('id'));
                });
                field.val(ids.join(','));
            }
        });
        </script>
        <style>
        #inmueble-images-list li img {
            width: 60px;
            height: auto;
        }
        </style>
        <?php
    }

    // Guardar las imágenes seleccionadas y sus descripciones
    function inmobiliaria_save_images_metabox($post_id) {
        if (array_key_exists('inmueble_images', $_POST)) {
            $image_ids = explode(',', sanitize_text_field($_POST['inmueble_images']));
            update_post_meta($post_id, '_inmueble_images', $image_ids);

            // Guardar descripciones de imágenes
            if (!empty($_POST['inmueble_image_descriptions'])) {
                foreach ($_POST['inmueble_image_descriptions'] as $image_id => $description) {
                    update_post_meta($image_id, '_image_description', sanitize_text_field($description));
                }
            }
        }
    }
    add_action('save_post', 'inmobiliaria_save_images_metabox');




// =========================
// METABOX: FIN GALERIA
// =========================


// =========================
// FIN DEL CÓDIGO
// =========================
?>