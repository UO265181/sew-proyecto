class Mapa {
    constructor() {
        this.src = null
    }

    fetchData() {

        this.src = 'https://www.mapquestapi.com/staticmap/v5/map?key=2LVGEKH0ZArUc3dX6Jj2nMLmJSqeLLaW&locations=Cabranes&size=1100,500@2x&type=hyb&scalebar=true&defaultMarker=circle-white&zoom=10';

        this.renderData();
    }

    renderData() {

        const section = document.createElement('section');

        const h2 = document.createElement('h2')
        h2.textContent = 'Mapa de situación';

        const figure = document.createElement('figure');
        const figCaption = document.createElement('figCaption');
        const img = document.createElement('img');

        img.src = this.src;
        img.alt = "Mapa de situación del Concejo de Cabranes"
        figCaption.textContent = "Santaolaya de Cabranes"

        figure.appendChild(img);
        figure.appendChild(figCaption);

        section.appendChild(h2);
        section.appendChild(figure);

        document.getElementsByTagName('main')[0].appendChild(section);
    }

}

const mapa = new Mapa();
mapa.fetchData();


