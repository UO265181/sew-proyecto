
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
                    $("p").html(ruta);
                });

                var ruta = $('ruta', datos).attr("nombre");
                var tipo = $('ruta', datos).attr("tipo");
                var medio_transporte = $('ruta', datos).attr("medio_transporte");
                var agencia = $('agencia', datos).text();
                var amanecer = $('ruta', datos).attr("rise");


                $("p").html(ruta);

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
