# Inmobiliaria Plugin

Plugin para gestionar inmuebles y mostrar listados en WordPress.

## Descripción

Este plugin permite crear y gestionar un tipo de contenido personalizado llamado "Inmueble" para administrar propiedades inmobiliarias. Incluye funcionalidades para mostrar listados, filtros de búsqueda, galerías de imágenes, y personalización del panel de administración.

## Instalación

1. Copia la carpeta del plugin `inmobiliaria-plugin` en el directorio `wp-content/plugins/` de tu instalación de WordPress.
2. Activa el plugin desde el panel de administración de WordPress en la sección "Plugins".
3. El plugin registrará automáticamente el tipo de contenido "Inmueble" y sus funcionalidades asociadas.

## Uso

### Tipo de contenido personalizado "Inmueble"

- El plugin crea un Custom Post Type llamado "Inmueble" para gestionar propiedades.
- Puedes agregar, editar y eliminar inmuebles desde el panel de administración de WordPress.
- El slug para los inmuebles es `/inmuebles/`.

### Shortcodes disponibles

- `[buscador_principal]`  
  Muestra un formulario de búsqueda avanzado para filtrar inmuebles por condición, tipo, ubicación y rango de precios.

- `[buscador_header]`  
  Similar al buscador principal, pensado para ubicarse en el header o áreas compactas.

- `[listado_buscador]`  
  Muestra un listado de inmuebles filtrados según los parámetros enviados por URL.

- `[listado_inmuebles]`  
  Muestra un listado de inmuebles con opciones de filtrado por condición, tipo, provincia, departamento y rango de precios.  
  Ejemplo: `[listado_inmuebles condicion="Venta" tipo="Casa" posts_per_page="10"]`

### Funcionalidades adicionales

- Personalización del panel de administración para mostrar columnas específicas en el listado de inmuebles.
- Galerías de imágenes para cada inmueble con carrusel.
- Modificación dinámica del slug del inmueble basado en metadatos.
- Widget personalizado en el panel principal de WordPress para acceso rápido a funciones del plugin.
- Control de visibilidad de inmuebles mediante checkbox en el listado de administración.

## Archivos principales

- `inmobiliaria-plugin.php` - Archivo principal del plugin.
- `includes/inmobiliaria-post-type.php` - Registro del Custom Post Type.
- `includes/inmobiliaria-metaboxes.php` - Metaboxes personalizados para inmuebles.
- `includes/inmobiliaria-shortcodes.php` - Shortcodes para búsqueda y listado.
- `includes/ubicaciones.php` - Funcionalidades relacionadas con ubicaciones.
- `templates/single-inmueble.php` - Plantilla personalizada para mostrar un inmueble.

## Autor

The Panther Soft (Maria Lujan Vaira)  
[https://thepanthersoft.com/](https://marialujanvaira.com/)

## Licencia

Este plugin es software libre y puede ser modificado y distribuido bajo los términos de la licencia GPL v2 o superior.
