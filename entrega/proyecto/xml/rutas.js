
"use strict";
class ArchivoXML {
    constructor(nombre) {
        this.nombre = nombre;
        this.correcto = "¡Todo correcto! archivo XML cargado"
    }
    cargarDatos() {
        $.ajax({
            dataType: "xml",
            url: this.nombre,
            method: 'GET',
            success: function (datos) {


                $('ruta', datos).each(function () {
                    var ruta = $(this).attr('nombre');
                    var tipo = $(this).attr('tipo');
                    var medio_transporte = $(this).attr('medio_transporte');
                    var recomendacion = $(this).attr('recomendacion');

                    var duracion = $(this).find('duracion').text();
                    var duracion_unidades = $(this).find('duracion').attr('unidades');
                    var agencia = $(this).find('agencia').text();
                    var descripcion = $(this).find('descripcion').text();
                    var personas = $(this).find('personas').text();
                    var inicio = $(this).find('inicio');
                    var inicio_fecha = $(inicio).find('fecha').text();
                    var inicio_hora = $(inicio).find('hora').text();
                    var inicio_lugar = $(inicio).find('lugar').text();
                    var inicio_direccion = $(inicio).find('direccion').text();
                    var coordenadas = $(this).find('coordenadas');
                    var longitud = $(coordenadas).find('longitud').text();
                    var latitud = $(coordenadas).find('latitud').text();
                    var altitud = $(coordenadas).find('altitud').text();


                    var section = $('<section>').appendTo('main');
                    $('<h2>').text(ruta).appendTo(section);

                    $('<p>').text(descripcion).appendTo(section);

                    var datosDeRuta = $('<ul>');
                    $('<li>').text('Tipo: ' + tipo).appendTo(datosDeRuta);
                    $('<li>').text('Medio de transporte: ' + medio_transporte).appendTo(datosDeRuta);
                    $('<li>').text('Recomendación: ' + recomendacion).appendTo(datosDeRuta);
                    $('<li>').text('Agencia: ' + agencia).appendTo(datosDeRuta);
                    $('<li>').text('Personas: ' + personas).appendTo(datosDeRuta);
                    $('<li>').text('Duración ('+duracion_unidades+'): ' + duracion).appendTo(datosDeRuta);
                    datosDeRuta.appendTo(section);

                    $('<h3>').text("Inicio").appendTo(section);
                    var datosDeInicio = $('<ul>');
                    if(inicio_fecha.length>0)
                        $('<li>').text('Fecha: ' + inicio_fecha).appendTo(datosDeInicio);
                    if(inicio_hora.length>0)
                        $('<li>').text('Hora: ' + inicio_hora).appendTo(datosDeInicio);
                    $('<li>').text('Lugar: ' + inicio_lugar).appendTo(datosDeInicio);
                    $('<li>').text('Dirección: ' + inicio_direccion).appendTo(datosDeInicio);
                    var coordenadasItem = $('<li>').text("Coordenadas: ")
                    var coordenadasLista = $('<ul>').appendTo(coordenadasItem);
                    $('<li>').text('Longitud: ' + longitud).appendTo(coordenadasLista);
                    $('<li>').text('Latitud: ' + latitud).appendTo(coordenadasLista);
                    $('<li>').text('Altitud: ' + altitud).appendTo(coordenadasLista);
                    coordenadasItem.appendTo(datosDeInicio);
                    datosDeInicio.appendTo(section);


                    $("hito", this).each(function () {
                        var hito = $(this).attr('nombre');
                        var descripcion = $("descripcion", this).text();
                        var distancia = $("distancia", this).text();
                        var distancia_unidades = $("distancia", this).attr('unidades');
                        var coordenadas = $(this).find('coordenadas');
                        var longitud = $(coordenadas).find('longitud').text();
                        var latitud = $(coordenadas).find('latitud').text();
                        var altitud = $(coordenadas).find('altitud').text();


                        
                        var sectionHito = $('<section>').appendTo(section);
                        $('<h3>').text(hito).appendTo(sectionHito);

                        $('<p>').text(descripcion).appendTo(sectionHito);

                        var datosDeHito = $('<ul>');
                        $('<li>').text('Distancia ('+distancia_unidades+'): ' + distancia).appendTo(datosDeHito);
                        var coordenadasItem = $('<li>').text("Coordenadas: ")
                        var coordenadasLista = $('<ul>').appendTo(coordenadasItem);
                        $('<li>').text('Longitud: ' + longitud).appendTo(coordenadasLista);
                        $('<li>').text('Latitud: ' + latitud).appendTo(coordenadasLista);
                        $('<li>').text('Altitud: ' + altitud).appendTo(coordenadasLista);
                        coordenadasItem.appendTo(datosDeHito);
                        datosDeHito.appendTo(sectionHito);


                        var seccionMultimedia = $('<section>').appendTo(sectionHito)
                        $('<h4>').text("Multimedia:").appendTo(seccionMultimedia);

                        $("foto", this).each(function () {
                            var src = $(this).text();
                            var alt = $(this).attr('alt');
                            var figCaption = $(this).attr('figCaption');

                            var figura = $("<figure>");
                            $("<img>").attr("src", src).attr("alt", alt).appendTo(figura);
                            $("<figcaption>").text(figCaption).appendTo(figura);
                            figura.appendTo(seccionMultimedia);
                        });


                        $("video", this).each(function () {
                            var src = $(this).text();
                            var type = $(this).attr('type');

                            var video = $("<video>").attr({
                                "controls": true,
                                "preload": "auto",
                            });
                            $("<source>").attr("src",src).attr("type",type).appendTo(video);
                            video.appendTo(seccionMultimedia);
                        });


                    });

                });


                /*

        // Crear la lista de fotos
        var listaFotos = $("<ul>").addClass("galeria-fotos");
        fotos.forEach(function (foto) {
            var itemFoto = $("<li>").html($("<img>").attr("src", foto));
            listaFotos.append(itemFoto);
        });
        seccionHito.append(listaFotos);

        // Crear la lista de videos
        var listaVideos = $("<ul>").addClass("galeria-videos");
        videos.forEach(function (video) {
            var itemVideo = $("<li>").html($("<iframe>").attr("src",*/


            },
            error: function () {
                $("h3").html("¡Tenemos problemas! No se pudo cargar el archivo XML");
                $("h4").remove();
                $("h5").remove();
                $("p").remove();
            }
        });
    }
    crearElemento(tipoElemento, texto, insertarAntesDe) {
        // Crea un nuevo elemento modificando el árbol DOM
        // El elemnto creado es de 'tipoElemento' con un 'texto' 
        // El elemnto se coloca antes del elemnto 'insertarAntesDe'
        var elemento = document.createElement(tipoElemento);
        elemento.innerHTML = texto;
        $(insertarAntesDe).before(elemento);
    }
    verXML() {
        this.cargarDatos();
        $("button").attr("disabled", "disabled");
    }
}
var rutas = new ArchivoXML("xml/rutas.xml");
