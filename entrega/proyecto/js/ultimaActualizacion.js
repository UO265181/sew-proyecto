class UltimaActualizacion {
    constructor() {
        this.fecha = null
    }

    obtenerFecha() {

        const date = new Date();

        this.fecha = date.toLocaleString();
    }

    render() {

        const section = document.createElement('section');

        const h2 = document.createElement('h2')
        h2.textContent = 'Última actualización';

        const pFecha = document.createElement('p')
        pFecha.textContent =  `Fecha de la última actualización del sitio web: ${this.fecha}`;

        section.appendChild(h2);
        section.appendChild(pFecha);

        document.getElementsByTagName('main')[0].appendChild(section);

    }

}

const ultimaActualizacion = new UltimaActualizacion();
ultimaActualizacion.obtenerFecha();
ultimaActualizacion.render();


