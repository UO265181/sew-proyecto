
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

                    var coordenadasRuta = [];
                    var puntosSVG = [];
                    var separacionLadosSVG = 100;
                    var xAcumulado = separacionLadosSVG;

                    // Info de la ruta
                    var ruta = $(this).attr('nombre');
                    var tipo = $(this).attr('tipo');
                    var medio_transporte = $(this).attr('medio_transporte');
                    var recomendacion = $(this).attr('recomendacion');
                    var ida_y_vuelta = $(this).attr('ida_y_vuelta');

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
                    var coordenadas = $(this).find('coordenadas')[0];
                    var longitud = $(coordenadas).find('longitud').text();
                    var latitud = $(coordenadas).find('latitud').text();
                    var altitud = $(coordenadas).find('altitud').text();

                    coordenadasRuta.push(coordenadas);
                    puntosSVG.push({ x: xAcumulado, y: altitud, texto: "Inicio de " + ruta, altitudReal: altitud });

                    var section = $('<section>').appendTo('main');
                    $('<h2>').text(ruta).appendTo(section);

                    $('<p>').text(descripcion).appendTo(section);

                    var datosDeRuta = $('<ul>');
                    $('<li>').text('Tipo: ' + tipo).appendTo(datosDeRuta);
                    $('<li>').text('Medio de transporte: ' + medio_transporte).appendTo(datosDeRuta);
                    $('<li>').text('Recomendación: ' + recomendacion).appendTo(datosDeRuta);
                    $('<li>').text('Agencia: ' + agencia).appendTo(datosDeRuta);
                    $('<li>').text('Personas: ' + personas).appendTo(datosDeRuta);
                    $('<li>').text('Duración (' + duracion_unidades + '): ' + duracion).appendTo(datosDeRuta);
                    var referenciasItem = $('<li>').text("Referencias: ")
                    var referenciasLista = $('<ul>').appendTo(referenciasItem);
                    $("referencia", this).each(function () {
                        var nombreReferencia = $(this).text();
                        var urlReferencia = $(this).attr('url');

                        var referencia = $("<a>");
                        referencia.attr("href", urlReferencia);
                        referencia.text(nombreReferencia);

                        var referenciaItem = $('<li>').appendTo(referenciasLista);
                        referencia.appendTo(referenciaItem);
                    });
                    referenciasItem.appendTo(datosDeRuta);
                    datosDeRuta.appendTo(section);

                    $('<h3>').text("Inicio").appendTo(section);
                    var datosDeInicio = $('<ul>');
                    if (inicio_fecha.length > 0)
                        $('<li>').text('Fecha: ' + inicio_fecha).appendTo(datosDeInicio);
                    if (inicio_hora.length > 0)
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

                        // Info del hito
                        var hito = $(this).attr('nombre');
                        var descripcion = $("descripcion", this).text();
                        var distancia = $("distancia", this).text();
                        var distancia_unidades = $("distancia", this).attr('unidades');
                        var coordenadas = $(this).find('coordenadas');
                        var longitud = $(coordenadas).find('longitud').text();
                        var latitud = $(coordenadas).find('latitud').text();
                        var altitud = $(coordenadas).find('altitud').text();

                        coordenadasRuta.push(coordenadas);
                        var distanciaPuntoSVG = parseFloat(distancia);
                        if (distancia_unidades === "metros")
                            distanciaPuntoSVG *= 1000000;
                        else
                            distanciaPuntoSVG *= 1000;
                        xAcumulado += distanciaPuntoSVG;
                        puntosSVG.push({ x: xAcumulado, y: altitud, texto: hito, altitudReal: altitud });


                        var sectionHito = $('<section>').appendTo(section);
                        $('<h3>').text(hito).appendTo(sectionHito);

                        $('<p>').text(descripcion).appendTo(sectionHito);

                        var datosDeHito = $('<ul>');
                        $('<li>').text('Distancia (' + distancia_unidades + '): ' + distancia).appendTo(datosDeHito);
                        var coordenadasItem = $('<li>').text("Coordenadas: ")
                        var coordenadasLista = $('<ul>').appendTo(coordenadasItem);
                        $('<li>').text('Longitud: ' + longitud).appendTo(coordenadasLista);
                        $('<li>').text('Latitud: ' + latitud).appendTo(coordenadasLista);
                        $('<li>').text('Altitud: ' + altitud).appendTo(coordenadasLista);
                        coordenadasItem.appendTo(datosDeHito);
                        datosDeHito.appendTo(sectionHito);

                        // Elementos multimedia
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

                            var video = $("<video>").attr("controls", true).attr("preload", "auto");
                            $("<source>").attr("src", src).attr("type", type).appendTo(video);
                            video.appendTo(seccionMultimedia);
                        });

                    });


                    if (ida_y_vuelta === "si") {
                        var nPuntos = puntosSVG.length;
                        for (let i = nPuntos - 2; i >= 0; i--) {
                            xAcumulado += puntosSVG[i + 1].x - puntosSVG[i].x;
                            puntosSVG.push({ x: xAcumulado, y: puntosSVG[i].y, texto: puntosSVG[i].texto, altitudReal: puntosSVG[i].altitudReal })
                        }
                    }


                    //SVG-------------------------------------------------------
                    var anchoSVG = 1000;
                    var altoSVG = 1000;

                    //Adapto los puntos

                    //Punto falso (exolicado en la bitácora)
                    var menorY = puntosSVG.reduce((previous, current) => {
                        return current.y < previous.y ? current : previous;
                    });
                    puntosSVG.push({ x: xAcumulado + (separacionLadosSVG * 2), y: menorY.y, noEscribir: true })

                    // Escalo los puntos 
                    var distanciaMaxima = 0;
                    for (let i = 0; i < puntosSVG.length - 1; i++) {
                        for (let j = i + 1; j < puntosSVG.length; j++) {
                            var distancia = Math.sqrt(Math.pow((puntosSVG[j].x - puntosSVG[i].x), 2) + Math.pow((puntosSVG[j].y - puntosSVG[i].y), 2));
                            if (distancia > distanciaMaxima) {
                                distanciaMaxima = distancia;
                            }
                        }
                    }

                    var escala = distanciaMaxima / Math.min(anchoSVG, altoSVG);
                    for (let i = 0; i < puntosSVG.length; i++) {
                        puntosSVG[i].x /= escala;
                        puntosSVG[i].y /= escala;

                        // Invierto las alturas
                        puntosSVG[i].y = altoSVG - puntosSVG[i].y;
                    }


                    // Creo el svg
                    var svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                    svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');

                    svg.setAttribute('width', anchoSVG);
                    svg.setAttribute('height', altoSVG);

                    var polyline = document.createElementNS("http://www.w3.org/2000/svg", "polyline");
                    var polylineCoordenadas = "";

                    // Recorro los puntos
                    for (var i = 0; i < puntosSVG.length; i++) {

                        if (!puntosSVG[i].noEscribir) {
                            var punto = puntosSVG[i];

                            var texto = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                            texto.setAttribute('x', punto.x);
                            texto.setAttribute('y', punto.y - 10);
                            texto.setAttribute('font-size', '8');
                            texto.setAttribute('font-family', 'sans-serif');
                            texto.setAttribute("text-anchor", "middle");
                            texto.textContent = punto.texto;

                            var textoAltitud = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                            textoAltitud.setAttribute('x', punto.x);
                            textoAltitud.setAttribute('y', punto.y - 20);
                            textoAltitud.setAttribute('font-size', '8');
                            textoAltitud.setAttribute('font-family', 'sans-serif');
                            textoAltitud.setAttribute("text-anchor", "middle");
                            textoAltitud.textContent = punto.altitudReal;

                            var circulo = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                            circulo.setAttribute('cx', punto.x);
                            circulo.setAttribute('cy', punto.y);
                            circulo.setAttribute('r', '5');
                            circulo.setAttribute('fill', 'red');

                            polylineCoordenadas += punto.x + "," + punto.y + " ";

                            svg.appendChild(circulo);
                            svg.appendChild(texto);
                            svg.appendChild(textoAltitud);
                        }
                    }

                    polyline.setAttribute("points", polylineCoordenadas.trim());
                    polyline.setAttribute("stroke", "blue");
                    polyline.setAttribute("stroke-width", "2");
                    polyline.setAttribute("stroke-dasharray", "5,5");
                    polyline.setAttribute('fill', 'none');
                    svg.appendChild(polyline);



                    // Sección en el html
                    var dirAltimetria = $(this).find('altimetria').text();
                    var altimetriaSection = $('<section>');
                    altimetriaSection.appendTo(section);
                    $('<h3>').text("Altimetría").appendTo(altimetriaSection);
                    $('<p>').text("Puedes ver la altimetría de la ruta en el archivo SVG ya genereado que se encuentra en: " + dirAltimetria+". También puedes descargarlo ahora usando el botón.").appendTo(altimetriaSection);

                    // Botón de descarga
                    var botonSVG = $('<button>');
                    botonSVG.text('Descargar SVG');
                    botonSVG.on('click', function () {
                        var svgData = new XMLSerializer().serializeToString(svg);
                        var blob = new Blob([svgData], { type: 'image/svg+xml' });
                        var url = window.URL.createObjectURL(blob);

                        // Enlace y clic automático para descargar el archivo
                        var downloadLink = $('<a>');
                        downloadLink.attr("href", url);
                        downloadLink.attr("download", ruta + '.svg');
                        section.append(downloadLink);
                        downloadLink.get(0).click();
                        downloadLink.remove();
                    });

                    altimetriaSection.append(botonSVG);


                    //KML-----------------------------

                    /*
                    var kmlDoc = document.implementation.createDocument('', 'kml', null);
                    var kmlElement = kmlDoc.documentElement;

                    var documentElement = kmlDoc.createElement('Document');
                    kmlElement.appendChild(documentElement);


                    for (var i = 0; i < coordenadasRuta.length; i++) {
                        var latitud = $(coordenadasRuta[i]).find('latitud').text();
                        var longitud = $(coordenadasRuta[i]).find('longitud').text();

                        var placemarkElement = kmlDoc.createElement('Placemark');

                        var pointElement = kmlDoc.createElement('Point');
                        placemarkElement.appendChild(pointElement);

                        var coordinatesElement = kmlDoc.createElement('coordinates');
                        coordinatesElement.textContent = longitud + ',' + latitud;
                        pointElement.appendChild(coordinatesElement);

                        documentElement.appendChild(placemarkElement);
                    }

                    var serializer = new XMLSerializer();
                    var kmlString = serializer.serializeToString(kmlDoc);
                    section.append(kmlString);
                    */
                });



            },
            error: function () {
                $("h1").html("ERROR: No se pudo cargar el archivo XML");
            }
        });
    }

    verXML() {
        this.cargarDatos();
        $("button").attr("disabled", "disabled");
    }
}
var rutas = new ArchivoXML("xml/rutas.xml");
