
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
                    var agencia = $(this).find('agencia').text();
                    var descripcion = $(this).find('descripcion').text();
                    var personas = $(this).find('personas').text();


                    var section = $('<section>').appendTo('body');
                    $('<h2>').text(ruta).appendTo(section);
                    $('<p>').text('tipo: ' + tipo).appendTo(section);
                    $('<p>').text('medio_transporte: ' + medio_transporte).appendTo(section);
                    $('<p>').text('recomendacion: ' + recomendacion).appendTo(section);
                });


                /*
                $("ruta", xml).each(function () {
    // Obtener los atributos de la ruta
    var tipo = $(this).attr("tipo");
    var recomendacion = $(this).attr("recomendacion");

    // Crear la sección de la ruta
    var seccionRuta = $("<section>").addClass("ruta");

    // Crear el encabezado de la sección
    var encabezadoRuta = $("<h2>").text(tipo + " (Recomendación: " + recomendacion + ")");
    seccionRuta.append(encabezadoRuta);

    // Recorrer los hitos de la ruta
    $("hito", this).each(function () {
        // Obtener los datos del hito
        var nombre = $("nombre", this).text();
        var descripcion = $("descripcion", this).text();
        var longitud = $("longitud", this).text();
        var latitud = $("latitud", this).text();
        var altitud = $("altitud", this).text();
        var distancia = $("distancia", this).text();
        var unidades = $("distancia", this).attr("unidades");
        var fotos = $("galeria_fotos foto", this).map(function () {
            return $(this).text();
        }).get();
        var videos = $("galeria_videos video", this).map(function () {
            return $(this).text();
        }).get();

        // Crear la sección del hito
        var seccionHito = $("<section>").addClass("hito");

        // Crear el encabezado del hito
        var encabezadoHito = $("<h3>").text(nombre);
        seccionHito.append(encabezadoHito);

        // Crear el párrafo de la descripción
        var parrafoDescripcion = $("<p>").text(descripcion);
        seccionHito.append(parrafoDescripcion);

        // Crear la lista de coordenadas
        var listaCoordenadas = $("<ul>").addClass("coordenadas");
        var itemCoordenadasLongitud = $("<li>").text("Longitud: " + longitud);
        var itemCoordenadasLatitud = $("<li>").text("Latitud: " + latitud);
        var itemCoordenadasAltitud = $("<li>").text("Altitud: " + altitud);
        listaCoordenadas.append(itemCoordenadasLongitud, itemCoordenadasLatitud, itemCoordenadasAltitud);
        seccionHito.append(listaCoordenadas);

        // Crear el párrafo de la distancia
        var parrafoDistancia = $("<p>").text("Distancia: " + distancia + " " + unidades);
        seccionHito.append(parrafoDistancia);

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
        //Muestra el archivo JSON recibido
        this.crearElemento("h2", "Archivo XML", "footer");
        this.crearElemento("h3", this.correcto, "footer"); // Crea un elemento con DOM 
        this.crearElemento("h4", "XML", "footer"); // Crea un elemento con DOM        
        this.crearElemento("h5", "", "footer"); // Crea un elemento con DOM para el string con XML
        this.crearElemento("h4", "Datos", "footer"); // Crea un elemento con DOM 
        this.crearElemento("p", "", "footer"); // Crea un elemento con DOM para los datos obtenidos con XML
        this.cargarDatos();
        $("button").attr("disabled", "disabled");
    }
}
var rutas = new ArchivoXML("xml/rutas.xml");
