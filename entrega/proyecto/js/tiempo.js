class Tiempo {
    constructor() {
        this.temperature = null;
        this.temperatureFeel = null;
        this.temperatureMax = null;
        this.temperatureMin = null;
        this.description = null;
        this.pressure = null;
        this.humidity = null;
        this.windSpeed = null;
    }

    fetchData() {

        $.ajax({
            url: 'https://api.openweathermap.org/data/2.5/weather?id=6359916&appid=f584ab7920bcc2b1c18704d726aea2a5&units=metric&lang=sp',
            method: 'GET',
            success: (response) => {

                this.temperature = response.main.temp;
                this.temperatureFeel = response.main.feels_like;
                this.temperatureMax = response.main.temp_max;
                this.temperatureMin = response.main.temp_min;

                this.description = response.weather[0].description;
                this.pressure = response.main.pressure;
                this.humidity = response.main.humidity;
                this.windSpeed = response.wind.speed;

                this.renderData();
            },
            error: (error) => {
                console.log('Error al obtener los datos meteorológicos:', error);
            },
        });
    }

    renderData() {
        const section = document.createElement('section');

        const h2 = document.createElement('h2')
        h2.textContent = 'Tiempo';

        const pDescripcion = document.createElement('p');
        pDescripcion.textContent=`Descripción general: ${this.description}.`;

        const h3Temperaturas = document.createElement('h3');
        h3Temperaturas.textContent = 'Temperaturas';
        const ulTemperarutas = document.createElement('ul');
        const liActual = document.createElement('li');
        liActual.textContent = `Actual: ${this.temperature}Cº`;
        const liMin = document.createElement('li');
        liMin.textContent = `Mínima: ${this.temperatureMin}Cº`;
        const liMax = document.createElement('li');
        liMax.textContent = `Máxima: ${this.temperatureMax}Cº`;
        const liSensacion = document.createElement('li');
        liSensacion.textContent = `Sensación térmica: ${this.temperatureFeel}Cº`;

        ulTemperarutas.appendChild(liActual);
        ulTemperarutas.appendChild(liMin);
        ulTemperarutas.appendChild(liMax);
        ulTemperarutas.appendChild(liSensacion);

        const h3Otros = document.createElement('h3');
        h3Otros.textContent = 'Otros';
        const ulOtros = document.createElement('ul');
        const liHumedad = document.createElement('li');
        liHumedad.textContent = `Humedad: ${this.humidity}%`;
        const liPresion = document.createElement('li');
        liPresion.textContent = `Presión: ${this.pressure} hPa`;
        const liViento = document.createElement('li');
        liViento.textContent = `Velocidad del viento: ${this.windSpeed} m/s`;

        ulOtros.appendChild(liHumedad);
        ulOtros.appendChild(liPresion);
        ulOtros.appendChild(liViento);



        section.appendChild(h2);
        section.appendChild(pDescripcion);
        section.appendChild(h3Temperaturas);
        section.appendChild(ulTemperarutas);
        section.appendChild(h3Otros);
        section.appendChild(ulOtros);

        document.getElementsByTagName('main')[0].appendChild(section);
    }

}

const tiempo = new Tiempo();
tiempo.fetchData();


//  "id": 6359916,
//  "name": "Cabranes",
//  "state": "",
//  "country": "ES",
//  "coord": {
//      "lon": -5.42945,
//      "lat": 43.412338
//  }