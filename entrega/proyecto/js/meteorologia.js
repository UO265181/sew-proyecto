class Meteorologia {
    constructor(nDays) {
        this.days = null;
        this.nDays = nDays;
    }

    fetchDataAndRender() {

        $.ajax({
            url: `https://api.weatherbit.io/v2.0/forecast/daily?key=91e4b6637f7f40e3a5b398092e6a4f66&lang=es&units=M&days=${this.nDays}&lat=43.407598&lon=-5.415428`,
            method: 'GET',
            success: (response) => {

                this.days = response.data;

                this.render();
            },
            error: (error) => {
                console.log('Error al obtener los datos meteorológicos:', error);
            },
        });
    }

    render() {


        for (let i = 0; i < this.nDays && i < this.days.length; i++) {

            const sDia = document.createElement('section');

            const h2 = document.createElement('h2')
            h2.textContent = this.days[i].valid_date;

            const pDescripcion = document.createElement('p');
            pDescripcion.textContent = `Descripción general: ${this.days[i].weather.description}.`;

            const h3Temperaturas = document.createElement('h3');
            h3Temperaturas.textContent = 'Temperaturas';
            const ulTemperarutas = document.createElement('ul');
            const liMed = document.createElement('li');
            liMed.textContent = `Media: ${this.days[i].temp}Cº`;
            const liMin = document.createElement('li');
            liMin.textContent = `Mínima: ${this.days[i].min_temp}Cº`;
            const liMax = document.createElement('li');
            liMax.textContent = `Máxima: ${this.days[i].max_temp}Cº`;

            ulTemperarutas.appendChild(liMed);
            ulTemperarutas.appendChild(liMin);
            ulTemperarutas.appendChild(liMax);

            const h3Otros = document.createElement('h3');
            h3Otros.textContent = 'Otros';
            const ulOtros = document.createElement('ul');
            const liHumedad = document.createElement('li');
            liHumedad.textContent = `Probabilidad de lluvia: ${this.days[i].pop}%`;
            const liPresion = document.createElement('li');
            liPresion.textContent = `Humedad: ${this.days[i].rh}%`;
            const liViento = document.createElement('li');
            liViento.textContent = `Velocidad del viento: ${this.days[i].wind_spd} m/s`;
    
            ulOtros.appendChild(liHumedad);
            ulOtros.appendChild(liPresion);
            ulOtros.appendChild(liViento);

            sDia.appendChild(h2);
            sDia.appendChild(pDescripcion);
            sDia.appendChild(h3Temperaturas);
            sDia.appendChild(ulTemperarutas);
            sDia.appendChild(h3Otros);
            sDia.appendChild(ulOtros);

            document.getElementsByTagName('main')[0].appendChild(sDia);
        }
       
    }

}

const meteorologia = new Meteorologia(7);
meteorologia.fetchDataAndRender();



//  "coord": {
//      "lon": -5.42945,
//      "lat": 43.412338
//  }