<?php
/*
Plugin Name: Inmobiliaria Plugin
Plugin URI:  
Description: Plugin para gestionar inmuebles y mostrar listados en WordPress.
Version: 1.0
Author: the Panther Soft (Maria Lujan Vaira)
Author URI: https://thepanthersoft.com/
*/

// ubicaciones.php
return [
    "Buenos Aires" => [
        'departamentos' => [
            "La Plata" => ["City Bell", "Gonnet", "Villa Elisa", "Tolosa", "Ringuelet", "Los Hornos", "Altos de San Lorenzo", "Abasto"],
            "Avellaneda" => ["Wilde", "Dock Sud", "Sarandí", "Piñeyro", "Gerli"],
            "Quilmes" => ["Bernal", "Ezpeleta", "Don Bosco", "Solano", "Villa La Florida", "Barrio Parque"],
            "San Isidro" => ["Beccar", "Boulogne", "Martínez", "Acassuso", "Villa Adelina"],
            "Morón" => ["Haedo", "El Palomar", "Castelar", "Villa Sarmiento", "Morón Sur"],
            "Tandil" => ["Villa Italia", "Centro", "Barrio Golf", "Don Bosco", "Barrio Palermo", "Barrio Arco Iris"],
            "Mar del Plata" => ["Barrio Los Troncos", "Playa Grande", "Barrio Faro Norte", "Barrio Constitución", "Puerto", "Punta Mogotes", "Barrio Cerrito Sur"],
            "Bahía Blanca" => ["Centro", "Villa Mitre", "White", "Barrio Harding Green", "Barrio Patagonia", "Barrio Universitario"],
            "Lanús" => ["Lanús Este", "Lanús Oeste", "Remedios de Escalada", "Villa Industriales", "Monte Chingolo"],
            "Lomas de Zamora" => ["Lomas Centro", "Temperley", "Banfield", "Villa Centenario", "San José", "Llavallol"],
            "Tigre" => ["Nordelta", "Rincón de Milberg", "Benavídez", "El Talar", "Dique Luján"],
            "San Fernando" => ["Victoria", "Virreyes", "San Fernando Centro"],
            "Vicente López" => ["Olivos", "Florida", "Villa Martelli", "Carapachay", "La Lucila"],
            "Berazategui" => ["Hudson", "Ranelagh", "Gutiérrez", "Centro Berazategui"],
            "Florencio Varela" => ["Bosques", "Villa Vatteone", "San Eduardo", "Santa Rosa"],
            "Escobar" => ["Belén de Escobar", "Ingeniero Maschwitz", "Garín", "Matheu"],
            "Pilar" => ["Del Viso", "Manzanares", "Villa Rosa", "Fátima"],
            "Zárate" => ["Lima", "Escalada", "Villa Fox"],
            "Campana" => ["Barrio Dálmine", "Barrio Lubo", "Barrio Ariel del Plata"],
            "General Rodríguez" => ["Barrio Bicentenario", "Villa Vengochea", "Barrio Güemes"],
            "Cañuelas" => ["Barrio Libertad", "Los Pozos", "Villa Adriana"],
            "Mercedes" => ["Barrio San Martín", "Barrio La Florida", "Barrio Gowland"],
            "Chivilcoy" => ["Moquehuá", "Gorostiaga", "La Rica"],
            "Pergamino" => ["Barrio Acevedo", "Barrio Kennedy", "Barrio Belgrano"],
            "Junín" => ["Barrio Belgrano", "Villa del Parque", "Barrio Evita"],
            "Olavarría" => ["Barrio Pueblo Nuevo", "Barrio Villa Aurora", "Barrio San Vicente"],
            "Azul" => ["Chillar", "Cacharí", "Barrio Del Carmen"],
            "Necochea" => ["Quequén", "Barrio Puerto", "Barrio Villa del Deportista"],
            "Tres Arroyos" => ["Barrio Boca", "Barrio Norte", "Barrio Villa Italia"]
        ]
    ],
    "Catamarca" => [
        'departamentos' => [
            "Capital" => ["San Fernando del Valle de Catamarca", "Barrio Parque América", "Barrio La Tablada"],
            "Ambato" => ["La Puerta", "El Rodeo", "Los Varela", "Las Juntas"],
            "Ancasti" => ["Ancasti", "La Candelaria", "El Alto"],
            "Andalgalá" => ["Andalgalá", "Chaquiago", "Villa Vil", "El Potrero"],
            "Antofagasta de la Sierra" => ["Antofagasta de la Sierra", "El Peñón", "Antofalla"],
            "Belén" => ["Belén", "Corral Quemado", "Londres", "Villa Vil", "Puerta de Corral Quemado", "Barrio La Puntilla"],
            "Capayán" => ["Chumbicha", "Huillapima", "San Pablo", "Capayán", "Colonia del Valle"],
            "El Alto" => ["El Alto", "Guayamba", "Vilismán", "Tapso"],
            "Fray Mamerto Esquiú" => ["San José", "La Falda de San Antonio", "Las Pirquitas"],
            "La Paz" => ["Recreo", "Icaño", "Quirós", "La Guardia"],
            "Paclín" => ["La Merced", "San Antonio", "Monte Potrero", "Balcozna"],
            "Pomán" => ["Pomán", "Mutquín", "Colpes", "Saujil", "El Pajonal"],
            "Santa María" => ["Santa María", "San José", "Loro Huasi", "Fuerte Quemado", "Chañar Punco"],
            "Santa Rosa" => ["Bañado de Ovanta", "Los Altos", "Manantiales", "Las Tunas"],
            "Tinogasta" => ["Tinogasta", "Fiambalá", "El Puesto", "Medanitos", "Saujil"],
            "Valle Viejo" => ["San Isidro", "Santa Rosa", "El Bañado", "Villa Dolores", "Polcos"]
        ]
    ], 
    "Tucumán" => [
        'departamentos' => [
            "Capital" => ["San Miguel de Tucumán", "Barrio Norte", "Barrio Sur", "Villa 9 de Julio", "El Manantial"],
            "Burruyacú" => ["Burruyacú", "El Chañar", "La Ramada", "7 de Abril", "Garmendia"],
            "Chicligasta" => ["Concepción", "Medinas", "Arcadia", "Monteagudo"],
            "Cruz Alta" => ["Banda del Río Salí", "Alderetes", "Colombres", "El Naranjito", "San Andrés"],
            "Famaillá" => ["Famaillá", "Barrio San Vicente", "Los Nogales", "Villa Fiad"],
            "Graneros" => ["Graneros", "Lamadrid", "Taco Ralo"],
            "Juan Bautista Alberdi" => ["Juan Bautista Alberdi", "Villa Belgrano", "Escaba", "Yánima"],
            "La Cocha" => ["La Cocha", "El Sacrificio", "San Ignacio", "Rumi Punco"],
            "Lules" => ["Lules", "El Manantial", "San Pablo", "Villa Nougués", "Barrio San Rafael"],
            "Monteros" => ["Monteros", "Yerba Buena", "Acheral", "Santa Rosa de Leales", "Santa Lucía"],
            "Río Chico" => ["Aguilares", "Santa Ana", "Los Sarmientos", "Monte Bello"],
            "Simoca" => ["Simoca", "Manuel García Fernández", "Villa Chicligasta", "San Pedro y San Antonio"],
            "Tafí del Valle" => ["Tafí del Valle", "El Mollar", "Amaicha del Valle", "Colalao del Valle"],
            "Tafí Viejo" => ["Tafí Viejo", "Barrio Lomas de Tafí", "Las Talitas", "Los Pocitos", "Villa Carmela"],
            "Trancas" => ["Trancas", "Choromoro", "San Pedro de Colalao", "Tapia"],
            "Leales" => ["Bella Vista", "Santa Rosa de Leales", "Los Ralos", "Esquina"],
            "Yerba Buena" => ["Yerba Buena", "Barrio Cebil Redondo", "Barrio Marti Coll", "Barrio Aconquija"]
        ]
    ],
    "Chaco" => [
        'departamentos' => [
            "12 de Octubre" => ["General Pinedo", "Gancedo", "Pampa Landriel"],
            "25 de Mayo" => ["Villa Ángela", "Samuhú", "Colonia Juan José Castelli"],
            "Almirante Brown" => ["Pampa del Infierno", "Los Frentones", "Concepción del Bermejo"],
            "Bermejo" => ["La Leonesa", "Las Palmas", "General Vedia"],
            "Comandante Fernández" => ["Presidencia Roque Sáenz Peña", "Napalpí", "Barrio Lamadrid"],
            "Doce de Octubre" => ["General Pinedo", "Hermoso Campo", "Gancedo"],
            "Dos de Abril" => ["Margarita Belén", "Lapachito", "Lapacho"],
            "Fray Justo Santa María de Oro" => ["Charata", "Las Breñas", "Pampa Barrera"],
            "General Belgrano" => ["Corzuela", "Campo Largo", "Las Garcitas"],
            "General Donovan" => ["Makallé", "La Verde", "La Escondida"],
            "General Güemes" => ["Juan José Castelli", "Miraflores", "Villa Río Bermejito"],
            "Independencia" => ["Campo Largo", "Villa Ángela", "Charadai"],
            "Libertad" => ["Puerto Tirol", "Barranqueras", "Fontana"],
            "Libertador General San Martín" => ["La Leonesa", "Puerto Bermejo", "Las Palmas"],
            "Maipú" => ["Villa Ángela", "Samuhú", "San Bernardo"],
            "Mayor Luis Jorge Fontana" => ["Villa Ángela", "Corzuela", "El Espinillo"],
            "O’Higgins" => ["Sáenz Peña", "Presidencia Roca", "Avia Terai"],
            "Quitilipi" => ["Quitilipi", "Machagai", "Taco Pozo"],
            "San Fernando" => ["Resistencia", "Barranqueras", "Puerto Tirol"],
            "San Lorenzo" => ["Las Palmas", "Margarita Belén", "Colonia Benítez"],
            "Sargento Cabral" => ["La Verde", "Colonia Elisa", "Makallé"],
            "Tapenagá" => ["Charadai", "Cote Lai", "Puerto Las Hacheras"],
            "Veinticinco de Mayo" => ["Villa Ángela", "Corzuela", "Los Frentones"],
            "Ñorquinco" => ["El Sauzalito", "Nueva Pompeya", "Fuerte Esperanza"]
        ]
    ],
    "Chubut" => [
        'departamentos' => [
            "Biedma" => ["Puerto Madryn", "Puerto Pirámides"],
            "Cushamen" => ["El Maitén", "Lago Puelo", "Epuyén", "Cholila", "Cushamen"],
            "Escalante" => ["Comodoro Rivadavia", "Rada Tilly", "Barrio Diadema", "Caleta Córdova"],
            "Florentino Ameghino" => ["Camarones", "Bahía Bustamante"],
            "Futaleufú" => ["Esquel", "Trevelin", "Lago Futalaufquen"],
            "Gaiman" => ["Gaiman", "Dolavon", "28 de Julio", "Bryan", "Villa Dique Ameghino"],
            "Gastre" => ["Gastre", "Laguna Grande", "El Escorial"],
            "Languiñeo" => ["Tecka", "Paso de Indios", "Las Plumas"],
            "Mártires" => ["Las Plumas", "El Mirasol"],
            "Paso de Indios" => ["Paso de Indios", "Los Altares"],
            "Rawson" => ["Rawson", "Playa Unión", "Puerto Rawson"],
            "Río Senguer" => ["Río Mayo", "Alto Río Senguer", "Dr. Ricardo Rojas"],
            "Sarmiento" => ["Sarmiento", "Aldea Apeleg", "Lago Musters"],
            "Telsen" => ["Telsen", "Gan Gan", "Cerro Cóndor"],
            "Trelew" => ["Trelew", "Playa Magagna", "El Doradillo", "Las Margaritas"]
        ]
    ],
    "Córdoba" => [
        'departamentos' => [
            "Capital" => ["Córdoba", "Villa Allende", "Mendiolaza", "Unquillo", "Saldán", "La Calera", "Malagueño"],
            "Calamuchita" => ["Santa Rosa de Calamuchita", "Villa General Belgrano", "Embalse", "Villa Rumipal", "Los Reartes", "La Cumbrecita"],
            "Colón" => ["Jesús María", "Colonia Caroya", "Sinsacate", "La Granja", "Ascochinga"],
            "Cruz del Eje" => ["Cruz del Eje", "Villa de Soto", "San Marcos Sierras", "Los Chañaritos"],
            "General Roca" => ["Villa Huidobro", "Huinca Renancó", "Italó", "Del Campillo"],
            "General San Martín" => ["Villa María", "Villa Nueva", "La Playosa", "Arroyo Cabral", "Etruria"],
            "Ischilín" => ["Deán Funes", "Quilino", "Villa Gutiérrez", "Las Peñas"],
            "Juárez Celman" => ["General Cabrera", "General Deheza", "Las Perdices", "Carnerillo"],
            "Marcos Juárez" => ["Marcos Juárez", "Leones", "Camilo Aldao", "Inriville", "Cruz Alta"],
            "Minas" => ["San Carlos Minas", "Villa Dolores", "La Paz", "Los Cerrillos"],
            "Pocho" => ["Salsacate", "San Gerónimo", "Tala Cañada", "Las Palmas"],
            "Punilla" => ["Villa Carlos Paz", "Cosquín", "La Falda", "Huerta Grande", "Capilla del Monte", "Tanti", "Bialet Massé"],
            "Río Cuarto" => ["Río Cuarto", "Alcira Gigena", "Berrotarán", "Las Higueras", "Holmberg"],
            "Río Primero" => ["Monte Cristo", "Piquillín", "Villa Santa Rosa", "La Puerta", "Diego de Rojas"],
            "Río Seco" => ["Villa de María", "San Francisco del Chañar", "Sebastián Elcano"],
            "Río Segundo" => ["Pilar", "Río Segundo", "Laguna Larga", "Oncativo", "Villa del Rosario"],
            "San Alberto" => ["Mina Clavero", "Nono", "Cura Brochero", "Villa Sarmiento"],
            "San Javier" => ["Villa Dolores", "San Javier y Yacanto", "La Población", "Las Rosas"],
            "San Justo" => ["San Francisco", "Arroyito", "Las Varillas", "Morteros", "Freyre"],
            "Santa María" => ["Alta Gracia", "Anisacate", "Villa La Bolsa", "Villa Los Aromos", "La Paisanita"],
            "Sobremonte" => ["San Francisco del Chañar", "Santa Elena", "Pozo del Molle"],
            "Tercero Arriba" => ["Oliva", "Río Tercero", "Tancacha", "Corralito"],
            "Totoral" => ["Villa del Totoral", "Las Peñas", "Cañada de Luque"],
            "Tulumba" => ["San José de la Dormida", "San Pedro Norte", "Villa Tulumba"],
            "Unión" => ["Bell Ville", "Justiniano Posse", "Morrison", "Noetinger"]
        ]
    ],
    "Corrientes" => [
        'departamentos' => [
            "Bella Vista" => ["Bella Vista", "Desmochado", "Tres de Abril", "Colonia Progreso"],
            "Berón de Astrada" => ["Berón de Astrada", "Yahapé"],
            "Capital" => ["Corrientes", "Laguna Brava", "Santa Ana de los Guácaras"],
            "Concepción" => ["Concepción", "Santa Rosa"],
            "Curuzú Cuatiá" => ["Curuzú Cuatiá", "Cazadores Correntinos", "Perugorría"],
            "Empedrado" => ["Empedrado", "El Sombrero"],
            "Esquina" => ["Esquina", "Libertador"],
            "General Alvear" => ["General Alvear", "Paso de los Libres", "Cuchillas"],
            "General Paz" => ["Itatí", "San Cosme", "San Luis del Palmar", "Paso de la Patria"],
            "Goya" => ["Goya", "Santa Lucía", "Colonia Carolina", "San Isidro"],
            "Ituzaingó" => ["Ituzaingó", "Villa Olivari", "San Antonio", "Colonia San Martín"],
            "Lavalle" => ["Santa Lucía", "Yatay Ti Calle", "Lavalle"],
            "Mburucuyá" => ["Mburucuyá", "Estación Mantilla", "Pago de los Deseos"],
            "Mercedes" => ["Mercedes", "Mariano I. Loza", "Felipe Yofré"],
            "Monte Caseros" => ["Monte Caseros", "Juan Pujol", "Mocoretá", "Colonia Libertad"],
            "Paso de los Libres" => ["Paso de los Libres", "Tapebicuá", "Bompland"],
            "Saladas" => ["Saladas", "San Lorenzo", "Caa Catí"],
            "San Martín" => ["La Cruz", "Yapeyú", "Guaviraví"],
            "San Miguel" => ["San Miguel", "Loreto"],
            "San Roque" => ["San Roque", "Pedro R. Fernández (Mantilla)", "Chavarría"],
            "Santo Tomé" => ["Santo Tomé", "Garruchos"],
            "Sauce" => ["Sauce", "Guayquiraró"]
        ]
    ],
    "Entre Ríos" => [
        'departamentos' => [
            "Colón" => ["Colón", "San José", "Villa Elisa", "Pueblo Liebig", "Ubajay"],
            "Concordia" => ["Concordia", "La Criolla", "Los Charrúas", "Puerto Yeruá", "Estancia Grande"],
            "Diamante" => ["Diamante", "Villa Libertador San Martín", "Valle María", "General Alvear", "Aldea Protestante"],
            "Federación" => ["Federación", "Chajarí", "Santa Ana", "San Jaime de la Frontera", "Villa del Rosario"],
            "Federal" => ["Federal", "Conscripto Bernardi", "Nueva Vizcaya"],
            "Feliciano" => ["San José de Feliciano", "San Víctor", "La Esmeralda"],
            "Gualeguay" => ["Gualeguay", "General Galarza", "Aldea Asunción"],
            "Gualeguaychú" => ["Gualeguaychú", "Larroque", "Urdinarrain", "Aldea San Antonio", "Gilbert"],
            "Islas del Ibicuy" => ["Villa Paranacito", "Ceibas", "Ibicuy"],
            "La Paz" => ["La Paz", "Santa Elena", "San Gustavo", "Bovril", "Piedras Blancas"],
            "Nogoyá" => ["Nogoyá", "Lucas González", "Hernández", "Aranguren"],
            "Paraná" => ["Paraná", "Crespo", "San Benito", "Oro Verde", "Colonia Avellaneda", "Viale"],
            "San Salvador" => ["San Salvador", "General Campos"],
            "Tala" => ["Rosario del Tala", "Maciá", "Mansilla"],
            "Uruguay" => ["Concepción del Uruguay", "Basavilbaso", "Caseros", "San Justo", "Colonia Elía"],
            "Victoria" => ["Victoria", "Rincón del Doll"],
            "Villaguay" => ["Villaguay", "Villa Domínguez", "Ingeniero Sajaroff", "Lucas Norte"]
        ]
    ],
    "Formosa" => [
        'departamentos' => [
            "Bermejo" => ["El Colorado", "General Francisco Basail", "Colonia El Alba"],
            "Formosa" => ["Formosa", "San Hilario", "Gran Guardia", "Villa Escolar"],
            "Laishi" => ["San Francisco de Laishi", "Herradura", "Tatané"],
            "Matacos" => ["Ingeniero Juárez", "Las Lomitas", "Pozo del Tigre", "Los Chiriguanos"],
            "Patiño" => ["Comandante Fontana", "Ibarreta", "General Güemes", "Posta Cambio Zalazar"],
            "Pilagás" => ["El Espinillo", "Misión Tacaaglé", "General Manuel Belgrano"],
            "Pilcomayo" => ["Clorinda", "Laguna Blanca", "Riacho He Hé", "Laguna Naineck"],
            "Pirané" => ["Pirané", "Villa Dos Trece", "Gran Guardia", "Palo Santo"],
            "Ramón Lista" => ["General Mosconi", "El Potrillo", "Pozo de Maza"]
        ]
    ],
    "Jujuy" => [
        'departamentos' => [
            "Capital" => ["San Salvador de Jujuy", "Los Perales", "Alto Comedero", "Barrio Chijra", "Barrio Cuyaya"],
            "Cochinoca" => ["Abra Pampa", "Puesto del Marqués", "Casabindo", "Abralaite"],
            "Dr. Manuel Belgrano" => ["San Salvador de Jujuy", "Yala", "Reyes", "Villa Jardín de Reyes"],
            "El Carmen" => ["El Carmen", "Perico", "Monterrico", "Aguas Calientes", "Los Lapachos"],
            "Humahuaca" => ["Humahuaca", "Uquía", "Iturbe", "Tres Cruces"],
            "Ledesma" => ["Libertador General San Martín", "Calilegua", "Caimancito", "Fraile Pintado", "Yuto"],
            "Palpalá" => ["Palpalá", "Rio Blanco", "Barrio 9 de Julio", "Barrio San José"],
            "Rinconada" => ["Rinconada", "Cusi Cusi", "Pirquitas"],
            "San Antonio" => ["San Antonio", "El Ceibal", "Los Alisos"],
            "San Pedro" => ["San Pedro de Jujuy", "La Mendieta", "El Piquete", "San Juancito", "Arrayanal"],
            "Santa Bárbara" => ["Santa Clara", "El Fuerte", "Palma Sola", "Vinalito"],
            "Santa Catalina" => ["Santa Catalina", "Cieneguillas", "La Quiaca Vieja", "Pumahuasi"],
            "Susques" => ["Susques", "El Toro", "Purmamarca", "Tumbaya", "San Antonio de los Cobres"],
            "Tilcara" => ["Tilcara", "Maimará", "Volcán"],
            "Tumbaya" => ["Tumbaya", "Purmamarca"],
            "Valle Grande" => ["Valle Grande", "San Francisco", "Valle Colorado", "Pampichuela"]
        ]
    ],
    "La Pampa" => [
        'departamentos' => [
            "Atreucó" => ["Macachín", "Doblas", "Anchorena", "Miguel Riglos"],
            "Caleu Caleu" => ["La Adela", "Colonia Santa María"],
            "Capital" => ["Santa Rosa", "Toay", "Anguil", "Winifreda"],
            "Catriló" => ["Catriló", "Lonquimay", "Uriburu", "Miguel Cané"],
            "Chalileo" => ["Santa Isabel", "La Humada"],
            "Chapaleufú" => ["Intendente Alvear", "Bernardo Larroudé", "Sarah"],
            "Chical Co" => ["Algarrobo del Águila", "La Humada"],
            "Conhelo" => ["Eduardo Castex", "Conhelo", "Monte Nievas"],
            "Curacó" => ["Puelches", "Casa de Piedra"],
            "Guatraché" => ["Guatraché", "General Manuel J. Campos", "Colonia Santa Teresa"],
            "Hucal" => ["General Acha", "Quehué", "Chacharramendi"],
            "Lihuel Calel" => ["La Reforma"],
            "Limay Mahuida" => ["Limay Mahuida"],
            "Loventué" => ["Victorica", "Telén", "Carro Quemado"],
            "Maracó" => ["General Pico", "Speluzzi", "Dorila", "Agustoni"],
            "Puelén" => ["Puelén", "Algarrobo del Águila"],
            "Quemú Quemú" => ["Quemú Quemú", "Colonia Barón", "Relmo"],
            "Rancul" => ["Rancul", "Parera", "Quetrequén"],
            "Realicó" => ["Realicó", "Van Praet", "Adolfo Van Praet", "Hilario Lagos"],
            "Toay" => ["Toay", "Anguil"],
            "Trenel" => ["Trenel", "Arata", "Caleufú"],
            "Utracán" => ["General Manuel J. Campos", "Quehué", "Chacharramendi"]
        ]
    ],
    "La Rioja" => [
        'departamentos' => [
            "Arauco" => ["Aimogasta", "Machigasta", "Bañado de los Pantanos", "San Pedro"],
            "Capital" => ["La Rioja", "Villa Sanagasta", "Las Padercitas", "La Quebrada"],
            "Castro Barros" => ["Aminga", "Anillaco", "Chuquis", "Santa Vera Cruz", "Los Molinos"],
            "Chamical" => ["Chamical", "Polco", "Bella Vista", "El Retiro"],
            "Chilecito" => ["Chilecito", "Nonogasta", "Anguinán", "Famatina", "Sañogasta", "Malligasta"],
            "Coronel Felipe Varela" => ["Villa Unión", "Guandacol", "Los Palacios", "Pagancillo"],
            "General Ángel V. Peñaloza" => ["Tama", "Salicas", "Los Alanices"],
            "General Belgrano" => ["Olta", "Loma Blanca", "Las Peñas", "Villa Casana"],
            "General Juan Facundo Quiroga" => ["Malanzán", "Portezuelo", "Nacate"],
            "General Lamadrid" => ["Villa Castelli", "Laguna Brava", "Aicuña"],
            "General San Martín" => ["Ulapes", "Ambil", "Corral de Isaac", "Cuatro Esquinas"],
            "Independencia" => ["Patquía", "Los Baldecitos", "Villa Mazán"],
            "Rosario Vera Peñaloza" => ["Chepes", "Villa Casana", "Desiderio Tello", "San Isidro"],
            "San Blas de los Sauces" => ["San Blas", "Schaqui", "Andolucas", "Los Robles"],
            "Sanagasta" => ["Villa Sanagasta", "Las Padercitas"],
            "Vinchina" => ["Vinchina", "Jagüé", "La Ciénaga", "El Cardón"]
        ]
    ],
    "Mendoza" => [
        'departamentos' => [
            "Capital" => ["Ciudad de Mendoza", "Barrio Bombal", "La Favorita", "Barrio Cano"],
            "General Alvear" => ["General Alvear", "Bowen", "San Pedro del Atuel", "Carmensa"],
            "Godoy Cruz" => ["Godoy Cruz", "Carrodilla", "Villa del Parque", "Barrio Trapiche"],
            "Guaymallén" => ["Villa Nueva", "Rodeo de la Cruz", "San José", "Bermejo", "El Bermejo"],
            "Junín" => ["Junín", "Medrano", "Los Barriales", "Philipps", "Rodríguez Peña"],
            "La Paz" => ["La Paz", "Villa Antigua", "Desaguadero"],
            "Las Heras" => ["Las Heras", "El Plumerillo", "El Challao", "Panquehua", "Capdeville", "El Zapallar", "El Borbollón", "Ciudad de Las Heras", "Uspallata", "Villas de San Isidro", "Blanco Encalada", "Los Corralitos", "Colonia Segovia", "Cacheuta", "La Cieneguita"],
            "Lavalle" => ["Villa Tulumaya", "Costa de Araujo", "El Vergel", "Tres de Mayo", "Jocolí"],
            "Luján de Cuyo" => ["Luján de Cuyo", "Chacras de Coria", "Perdriel", "Vistalba", "Ugarteche", "Cacheuta"],
            "Malargüe" => ["Malargüe", "Las Loicas", "El Sosneado", "Agua Escondida"],
            "Maipú" => ["Maipú", "Coquimbito", "Cruz de Piedra", "Russell", "Luzuriaga", "Rodeo del Medio"],
            "Rivadavia" => ["Rivadavia", "Los Campamentos", "Santa María de Oro", "El Mirador", "La Libertad"],
            "San Carlos" => ["San Carlos", "La Consulta", "Eugenio Bustos", "Pareditas", "Villa de Uco"],
            "San Martín" => ["San Martín", "Palmira", "Tres Porteñas", "El Espino", "Chapanay"],
            "San Rafael" => ["San Rafael", "Villa 25 de Mayo", "Las Paredes", "Cuadro Benegas", "El Nihuil"],
            "Santa Rosa" => ["Santa Rosa", "Las Catitas", "La Dormida", "12 de Octubre"],
            "Tunuyán" => ["Tunuyán", "Vista Flores", "La Primavera", "Los Sauces"],
            "Tupungato" => ["Tupungato", "La Arboleda", "El Peral", "San José", "Villa Bastías"]
        ]
    ],
    "Misiones" => [
        'departamentos' => [
            "Apóstoles" => ["Apóstoles", "Azara", "Tres Capones", "San José"],
            "Cainguás" => ["Campo Grande", "Aristóbulo del Valle", "Dos de Mayo", "Salto Encantado"],
            "Candelaria" => ["Candelaria", "Profundidad", "Cerro Corá", "Loreto", "Santa Ana"],
            "Capital" => ["Posadas", "Villa Cabello", "Miguel Lanús", "Garupá"],
            "Concepción" => ["Concepción de la Sierra", "Santa María", "Tres Capones"],
            "Eldorado" => ["Eldorado", "Puerto Piray", "Puerto Esperanza", "Colonia Victoria"],
            "General Manuel Belgrano" => ["San Pedro", "Cruce Caballero", "Pozo Azul", "Colonia Paraíso"],
            "Guaraní" => ["El Soberbio", "San Vicente", "Dos de Mayo", "San Francisco"],
            "Iguazú" => ["Puerto Iguazú", "Wanda", "Andresito", "Puerto Libertad"],
            "Leandro N. Alem" => ["Leandro N. Alem", "Cerro Azul", "Almafuerte", "Oberá", "San Javier"],
            "Libertador General San Martín" => ["Montecarlo", "Caraguatay", "Puerto Piray", "Colonia Victoria"],
            "Montecarlo" => ["Montecarlo", "Caraguatay", "Puerto Piray"],
            "Oberá" => ["Oberá", "Panambí", "Los Helechos", "Campo Ramón", "Campo Viera"],
            "San Ignacio" => ["San Ignacio", "Jardín América", "Santa Ana", "Colonia Alberdi", "Hipólito Yrigoyen"],
            "San Javier" => ["San Javier", "Itacaruaré", "Mojón Grande"],
            "25 de Mayo" => ["25 de Mayo", "Santa Rita", "Colonia Aurora"],
            "Puerto Libertador General San Martín" => ["Puerto Libertador", "Colonia Mado", "Puerto Bosetti"]
        ]
    ],
    "Neuquén" => [
        'departamentos' => [
            "Aluminé" => ["Aluminé", "Villa Pehuenia", "Moquehue"],
            "Añelo" => ["Añelo", "San Patricio del Chañar", "Vista Alegre"],
            "Catán Lil" => ["Las Coloradas", "Catan Lil"],
            "Chos Malal" => ["Chos Malal", "Tricao Malal", "Los Miches"],
            "Collón Curá" => ["Piedra del Águila", "Santo Tomás"],
            "Confluencia" => ["Neuquén Capital", "Plottier", "Centenario", "Senillosa", "Villa El Chocón"],
            "Huiliches" => ["Junín de los Andes", "Lago Meliquina"],
            "Lacar" => ["San Martín de los Andes", "Chacra IV", "Chacra XIII"],
            "Loncopué" => ["Loncopué", "Caviahue-Copahue", "El Huecú"],
            "Los Lagos" => ["Villa La Angostura", "Puerto Manzano", "Cuyín Manzano"],
            "Minas" => ["Andacollo", "Huinganco", "Las Ovejas", "Manzano Amargo"],
            "Ñorquín" => ["El Cholar", "El Huecú", "Varvarco"],
            "Pehuenches" => ["Rincón de los Sauces", "Octavio Pico"],
            "Picún Leufú" => ["Picún Leufú", "El Sauce"],
            "Zapala" => ["Zapala", "Covunco Abajo", "Raimundo"],
            "San Martín de los Andes" => ["San Martín de los Andes", "Vega Maipú", "Vega San Martín"]
        ]
    ],
    "Río Negro" => [
        'departamentos' => [
            "Adolfo Alsina" => ["Viedma", "El Cóndor", "San Javier", "Guardia Mitre"],
            "Avellaneda" => ["Choele Choel", "Luis Beltrán", "Lamarque", "Pomona", "Chimpay"],
            "Bariloche" => ["San Carlos de Bariloche", "Dina Huapi", "Villa Llanquín"],
            "Conesa" => ["General Conesa", "Arroyo Ventana"],
            "El Cuy" => ["El Cuy", "Las Perlas", "Mencué"],
            "General Roca" => ["General Roca", "Cipolletti", "Allen", "Villa Regina", "Fernández Oro", "Ingeniero Huergo", "Mainqué"],
            "Nueve de Julio" => ["Sierra Colorada", "Los Menucos", "Ramos Mexía"],
            "Ñorquincó" => ["Ñorquincó", "Mamuel Choique", "Cerro Policía"],
            "Pilcaniyeu" => ["Pilcaniyeu", "Comallo"],
            "San Antonio" => ["San Antonio Oeste", "Las Grutas", "Sierra Grande", "Puerto San Antonio Este"],
            "Valcheta" => ["Valcheta", "Arroyo Los Berros"],
            "25 de Mayo" => ["Maquinchao", "Jacobacci", "Ojos de Agua"],
            "Pichi Mahuida" => ["Río Colorado", "La Adela"]
        ]
    ],
    "Salta" => [
        'departamentos' => [
            "Anta" => ["Joaquín V. González", "El Quebrachal", "Apolinario Saravia", "Las Lajitas", "Gaona"],
            "Cachi" => ["Cachi", "Payogasta", "La Paya"],
            "Cafayate" => ["Cafayate", "Animaná", "San Carlos"],
            "Capital" => ["Salta", "San Lorenzo", "Villa San Lorenzo"],
            "Cerrillos" => ["Cerrillos", "La Merced", "San Agustín"],
            "Chicoana" => ["Chicoana", "El Carril", "Escoipe"],
            "General Güemes" => ["General Güemes", "Campo Santo", "El Bordo"],
            "Guachipas" => ["Guachipas", "Ceibalito"],
            "Iruya" => ["Iruya", "San Isidro", "Campo Carreras"],
            "La Caldera" => ["La Caldera", "Vaqueros"],
            "La Candelaria" => ["El Jardín", "El Tala", "La Candelaria"],
            "La Poma" => ["La Poma", "Cobres", "El Rodeo"],
            "La Viña" => ["La Viña", "Coronel Moldes", "Ampascachi"],
            "Los Andes" => ["San Antonio de los Cobres", "Olacapato", "Tolar Grande"],
            "Metán" => ["San José de Metán", "El Galpón", "Río Piedras"],
            "Molinos" => ["Molinos", "Seclantás", "Colomé"],
            "Orán" => ["San Ramón de la Nueva Orán", "Hipólito Yrigoyen", "Pichanal", "Colonia Santa Rosa", "Urundel"],
            "Rivadavia" => ["Santa Victoria Este", "Rivadavia Banda Norte", "Rivadavia Banda Sur"],
            "Rosario de la Frontera" => ["Rosario de la Frontera", "El Potrero", "Antilla"],
            "Rosario de Lerma" => ["Rosario de Lerma", "Campo Quijano", "La Silleta"],
            "San Martín" => ["Tartagal", "General Mosconi", "Aguaray", "Salvador Mazza", "Coronel Cornejo"],
            "Santa Victoria" => ["Santa Victoria Oeste", "Nazareno", "Los Toldos"]
        ]
    ],
    "San Juan" => [
        'departamentos' => [
            "Albardón" => ["Villa General San Martín", "Las Tapias", "La Cañada", "El Rincón"],
            "Angaco" => ["Villa El Salvador", "San Isidro", "La Majadita", "Las Tapias"],
            "Calingasta" => ["Barreal", "Tamberías", "Villa Calingasta", "Sorocayense"],
            "Capital" => ["San Juan", "Trinidad", "Concepción", "Desamparados"],
            "Caucete" => ["Villa Independencia", "Bermejo", "Las Talas", "Los Médanos"],
            "Chimbas" => ["Villa Obrera", "Villa Paula", "Barrio Los Pinos", "Barrio Parque Industrial"],
            "Iglesia" => ["Rodeo", "Bella Vista", "Tudcum", "Las Flores"],
            "Jáchal" => ["San José de Jáchal", "Huaco", "Villa Mercedes", "La Ciénaga"],
            "9 de Julio" => ["Villa Cabecera", "Las Chacritas", "Colonia Fiorito"],
            "Pocito" => ["Villa Aberastain", "Carpintería", "Callejón Blanco", "Barrio Municipal"],
            "Rawson" => ["Villa Krause", "Plátanos", "Las Chacritas", "Villa San Damián"],
            "Rivadavia" => ["Villa Rivadavia", "La Bebida", "Marquesado", "Zonda"],
            "San Martín" => ["San Isidro", "Villa Dominguito", "La Puntilla", "Las Lomitas"],
            "Santa Lucía" => ["Santa Lucía", "Villa Don Arturo", "Callejón Castro"],
            "Sarmiento" => ["Villa Media Agua", "Los Berros", "Colonia Fiscal", "Pedernal"],
            "Ullum" => ["Villa Ibáñez", "El Carrizal", "Las Flores"],
            "Valle Fértil" => ["San Agustín de Valle Fértil", "Usno", "Baldes del Rosario", "Astica"],
            "Zonda" => ["Villa Basilio Nievas", "Villa Tacú", "El Encón"],
            "25 de Mayo" => ["Santa Rosa", "Las Casuarinas", "Tupelí", "Casuarinas", "La Chimbera"]
        ]
    ],
    "San Luis" => [
        'departamentos' => [
            "Ayacucho" => ["Quines", "Candelaria", "Luján", "Leandro N. Alem", "San Francisco del Monte de Oro"],
            "Belgrano" => ["Villa General Roca", "La Calera", "Nogolí", "El Trapiche"],
            "Chacabuco" => ["Concarán", "Naschel", "Tilisarao", "Cortaderas", "Villa Larca", "Renca"],
            "Coronel Pringles" => ["La Toma", "El Morro", "Carolina", "San Martín"],
            "General Pedernera" => ["Villa Mercedes", "Justo Daract", "Juan Llerena", "Las Isletas"],
            "Gobernador Dupuy" => ["Anchorena", "Arizona", "Buena Esperanza", "Unión"],
            "Junín" => ["Merlo", "Santa Rosa de Conlara", "Los Molles", "Cerro de Oro"],
            "Libertador General San Martín" => ["San Martín", "Las Aguadas", "Villa de Praga"],
            "La Capital" => ["San Luis", "Juana Koslay", "El Volcán", "Potrero de los Funes", "La Punta"]
        ]
    ],
    "Santa Cruz" => [
        'departamentos' => [
            "Corpen Aike" => ["Comandante Luis Piedrabuena", "Jaramillo", "Fitz Roy", "Tres Cerros"],
            "Deseado" => ["Puerto Deseado", "Puerto San Julián", "Pico Truncado", "Koluel Kayke", "Las Heras"],
            "Güer Aike" => ["Río Gallegos", "El Turbio", "Julia Dufour", "Rospentek", "El Chaltén"],
            "Lago Argentino" => ["El Calafate", "Tres Lagos", "Gobernador Gregores"],
            "Lago Buenos Aires" => ["Perito Moreno", "Los Antiguos", "Hipólito Yrigoyen"],
            "Magallanes" => ["Puerto Santa Cruz"],
            "Río Chico" => ["Gobernador Mayer", "Puerto Coig", "La Esperanza"]
        ]
    ],
    "Santa Fe" => [
        'departamentos' => [
            "Belgrano" => ["Las Rosas", "Las Parejas", "Montes de Oca", "Tortugas"],
            "Caseros" => ["Casilda", "Chabás", "San José de la Esquina", "Villada", "Arteaga"],
            "Castellanos" => ["Rafaela", "Sunchales", "Humberto Primo", "Santa Clara de Saguier", "Bella Italia"],
            "Constitución" => ["Villa Constitución", "Empalme Villa Constitución", "Theobald", "Pavón Arriba", "Cañada Rica"],
            "Garay" => ["Helvecia", "Cayastá", "Saladero Cabal", "Santa Rosa de Calchines"],
            "General López" => ["Venado Tuerto", "Firmat", "Murphy", "Teodelina", "Villa Cañás"],
            "General Obligado" => ["Reconquista", "Avellaneda", "Villa Ocampo", "Las Toscas", "Florencia"],
            "Iriondo" => ["Cañada de Gómez", "Correa", "Oliveros", "Bustinza", "Totoras"],
            "La Capital" => ["Santa Fe", "Santo Tomé", "Recreo", "San José del Rincón"],
            "Las Colonias" => ["Esperanza", "San Jerónimo Norte", "Pilar", "Franck", "Humboldt"],
            "San Cristóbal" => ["San Cristóbal", "Ceres", "San Guillermo", "Suardi", "Hersilia"],
            "San Javier" => ["San Javier", "Alejandra", "Cacique Ariacaiquín", "Colonia Teresa"],
            "San Jerónimo" => ["Coronda", "Gálvez", "Barrancas", "San Fabián", "Arocena"],
            "San Justo" => ["San Justo", "San Bernardo", "Pedro Gómez Cello", "Ramayón"],
            "San Lorenzo" => ["San Lorenzo", "Fray Luis Beltrán", "Puerto General San Martín", "Ricardone"],
            "San Martín" => ["San Jorge", "El Trébol", "Sastre", "María Susana", "Piamonte"],
            "Vera" => ["Vera", "Calchaquí", "Margarita", "Toba", "La Gallareta"],
            "Rosario" => ["Rosario", "Granadero Baigorria", "Funes", "Villa Gobernador Gálvez", "Pérez"],
            "9 de Julio" => ["Tostado", "Villa Minetti", "Gregoria Pérez de Denis", "Pozo Borrado"]
        ]
    ],
    "Santiago del Estero" => [
        'departamentos' => [
            "Aguilares" => ["Aguilares", "Santa Bárbara", "Barrancas"],
            "Alberdi" => ["Campo Gallo", "El Mojón", "El Cuadrado"],
            "Atamisqui" => ["Villa Atamisqui", "Medellín", "El Deán"],
            "Avellaneda" => ["Herrera", "Villa Robles", "Colonia Dora"],
            "Banda" => ["La Banda", "Clodomira", "Los Quiroga", "Beltrán"],
            "Belgrano" => ["Pinto", "Malbrán", "Villa General Mitre"],
            "Capital" => ["Santiago del Estero", "La Dársena", "El Zanjón"],
            "Choya" => ["Frías", "San Pedro", "Tapso"],
            "Copo" => ["Monte Quemado", "Pampa de los Guanacos", "Campo Gallo"],
            "Figueroa" => ["La Cañada", "Vaca Huañuna", "La Invernada"],
            "General Taboada" => ["Añatuya", "Los Juríes", "Colonia Dora"],
            "Guasayán" => ["San Pedro de Guasayán", "Lavalle", "Villa Guasayán"],
            "Jiménez" => ["Pozo Hondo", "Pampa Muyoj", "Los Telares"],
            "Juan Felipe Ibarra" => ["Suncho Corral", "El Colorado"],
            "Loreto" => ["Loreto", "Villa Unión", "San Antonio"],
            "Mitre" => ["Villa Unión", "Lugones", "Colonia Dora"],
            "Moreno" => ["Quimilí", "Tintina", "Weisburd"],
            "Ojo de Agua" => ["Villa Ojo de Agua", "Sol de Julio"],
            "Pellegrini" => ["Nueva Esperanza", "El Bobadal", "Ahí Veremos"],
            "Quebrachos" => ["Sumampa", "Los Telares"],
            "Río Hondo" => ["Termas de Río Hondo", "Villa Río Hondo", "Chaupi Pozo"],
            "Rivadavia" => ["Selva", "Pampa de los Guanacos", "Santa Rosa"],
            "Robles" => ["Fernández", "Vilelas", "Robles"],
            "Salavina" => ["Villa Salavina", "Los Telares", "Árraga"],
            "San Martín" => ["Brea Pozo", "Los Pocitos", "Villa Río Hondo"],
            "Sarmiento" => ["Garza", "El Arenal", "Abra Grande"],
            "Silípica" => ["Árraga", "San Ramón", "Chauchillas"]
        ]
    ],
    "Tierra del Fuego" => [
        'departamentos' => [
            "Río Grande" => ["Río Grande", "Tolhuin", "San Sebastián", "Estancia Viamonte"],
            "Ushuaia" => ["Ushuaia", "Puerto Almanza", "Bahía Lapataia", "Estancia Harberton"],
            "Antártida e Islas del Atlántico Sur" => [
                "Base Esperanza",
                "Base Marambio",
                "Base Orcadas",
                "Base Carlini"
            ]
        ]
    ]

];
                       
