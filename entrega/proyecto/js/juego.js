

class Juego {
    constructor(preguntas) {
        this.preguntas = preguntas;
        this.pRespuesta = null;
    }

    generarContenido() {

        const sPreguntas = document.createElement('section');

        const hPreguntas = document.createElement('h2');
        hPreguntas.textContent = 'Preguntas'
        sPreguntas.appendChild(hPreguntas);

        preguntas.forEach((pregunta, index) => {
            const sPregunta = document.createElement('section');

            const h3 = document.createElement('h3');
            h3.textContent = `${index + 1}. ${pregunta.pregunta}`;

            sPregunta.appendChild(h3);

            pregunta.opciones.forEach(opcion => {
                const inputOpcion = document.createElement('input');
                inputOpcion.type = 'radio';
                inputOpcion.name = `pregunta-${index}`;
                inputOpcion.value = opcion;

                const lbOpcion = document.createElement('label');
                lbOpcion.textContent = opcion;

                sPregunta.appendChild(inputOpcion);
                sPregunta.appendChild(lbOpcion);
            });

            sPreguntas.appendChild(sPregunta);
        });

        const button = document.createElement('button');
        button.textContent = 'Enviar respuestas';
        button.addEventListener('click', () => this.calcularResultado());
        sPreguntas.appendChild(button);

        document.getElementsByTagName('main')[0].appendChild(sPreguntas);



        const sRespuesta = document.createElement('section');
        const hRespuesta = document.createElement('h2');
        hRespuesta.textContent = 'Resultado'
        sRespuesta.appendChild(hRespuesta);

        this.pRespuesta = document.createElement('p');
        this.pRespuesta.textContent = 'Envía tus respuestas para obtener un resultado.'
        sRespuesta.appendChild(this.pRespuesta);

        document.getElementsByTagName('main')[0].appendChild(sRespuesta);
    }



    calcularResultado() {
        const respuestas = document.querySelectorAll('input[type="radio"]:checked');


        if (respuestas.length !== preguntas.length) {
            this.pRespuesta.textContent = 'Debes responder todas las preguntas.';
            return;
        }

        const puntaje = 0;

        preguntas.forEach((pregunta, index) => {
            const respuestaSeleccionada = respuestas[index].value;
            if (respuestaSeleccionada === pregunta.respuestaCorrecta) {
                puntaje += 1;
            }
        });

        this.pRespuesta.textContent =  `Tu puntaje: ${puntaje} / ${preguntas.length}`;
    }
}


const preguntas = [
    {
        pregunta: '¿Qué festival se celebra en Cabranes?',
        opciones: ['Festival del Carnaval Asturiano', 'Festival de la sidra', 'Festival de los mineros', 'Festival de la mejor vaca', 'Festival del arroz con leche'],
        respuestaCorrecta: 'Festival del arroz con leche'
    },
    {
        pregunta: '¿En qué comunidad autónoma se encuentra Cabranes?',
        opciones: ['Asturias', 'Castilla y León', 'Cantabria', 'País Vasco', 'Galicia'],
        respuestaCorrecta: 'Asturias'
    },
    {
        pregunta: '¿Cúal de estos platos no es típico de Cabranes?',
        opciones: ['Paella', 'Cachopo', 'Arroz con leche', 'Fabes', 'Pote'],
        respuestaCorrecta: 'Paella'
    },
    {
        pregunta: '¿A qué mancomunidad pertenece Cabranes?',
        opciones: ['Comarca del Cachopo', 'Comarca de la Minería', 'Comarca de la Sidra', 'Comarca del Norte', 'Comarca del Arroz con Leche'],
        respuestaCorrecta: 'Comarca del Arroz con Leche'
    },
    {
        pregunta: '¿En qué año comenzó el festival del arroz con leche?',
        opciones: ['1980', '1981', '1982', '1990', '1989'],
        respuestaCorrecta: '1980'
    },
    {
        pregunta: '¿En qué año fue declarado el festival del arroz con leche de interés turístico regional?',
        opciones: ['2005', '2004', '2003', '2002', 'Nunca'],
        respuestaCorrecta: '2004'
    },
    {
        pregunta: '¿En qué año fue declarado el festival del arroz con leche de interés turístico nacional?',
        opciones: ['2014', '2015', '2004', '2010', 'Nunca'],
        respuestaCorrecta: 'Nunca'
    },
    {
        pregunta: '¿Cúal de estos ingredientes es típico del arroz con leche?',
        opciones: ['Cúrcuma', 'Canela', 'Orégano', 'Laurel', 'Pimentón'],
        respuestaCorrecta: 'Canela'
    },
    {
        pregunta: '¿Cúal es la población de Cabranes?',
        opciones: ['1000', '982', '1123', '1057', '1070'],
        respuestaCorrecta: '1057'
    },
    {
        pregunta: '¿Cúal de estos lugares no pertenece a Cabranes?',
        opciones: ['Fresnedo', 'Viñón', 'Valbuena', 'Niao', 'Todos pertenecen'],
        respuestaCorrecta: 'Todos pertenecen'
    }
];


const juego = new Juego(preguntas);
juego.generarContenido();
