class Carrusel {


    constructor(images) {
        this.images = images;
        this.currentIndex = 0;
        this.contenedor = null;
    }

    update() {
        const img = document.createElement('img');
        img.src = this.images[this.currentIndex].src;
        img.alt = this.images[this.currentIndex].alt;

        const figCaption = document.createElement('figCaption');
        figCaption.textContent = this.images[this.currentIndex].figCaption;

        this.contenedor.innerHTML = '';
        this.contenedor.appendChild(img);
        this.contenedor.appendChild(figCaption);
    }

    start(interval) {
        this.update();
        this.intervalId = setInterval(() => this.next(), interval);
    }

    next() {
        this.currentIndex = (this.currentIndex + 1) % this.images.length;
        this.update();
    }

    prev() {
        this.currentIndex = (this.currentIndex + this.images.length - 1) % this.images.length;
        this.update();
    }


    crearContenedor() {
        const section = document.createElement('section');

        const h2 = document.createElement('h2')
        h2.textContent = 'Carrusel de imágenes';

        const figure = document.createElement('figure');
        const buttonPrev = document.createElement('button');
        buttonPrev.textContent = 'Anterior';
        buttonPrev.addEventListener('click', () => this.prev());
        const buttonNext = document.createElement('button');
        buttonNext.textContent = 'Siguiente';
        buttonNext.addEventListener('click', () => this.next());

        section.appendChild(h2);
        section.appendChild(figure);
        section.appendChild(buttonPrev);
        section.appendChild(buttonNext);

        document.getElementsByTagName('main')[0].appendChild(section);

        this.contenedor = figure;
    }

}
const images = [
    { src: 'multimedia/carrusel1.jpg', alt: 'Foto de la placa de Cabranes', figCaption: 'Placa de Cabranes' },
    { src: 'multimedia/carrusel2.jpg', alt: 'Foto de la cima del monte Incós', figCaption: 'Monte Incós' },
    { src: 'multimedia/carrusel3.jpg', alt: 'Foto de la Iglesia de San Martín el Real en Torazo', figCaption: 'Iglesia de San Martín el Real' },
    { src: 'multimedia/carrusel4.jpg', alt: 'Foto de los vecinos reunidos en el festival del arroz', figCaption: 'Festival de Arroz' },
    { src: 'multimedia/carrusel5.jpg', alt: 'Foto del antiguo castillete minero', figCaption: 'Castillete minero' }];
//TODO: la primera vez que se renderiza una imagen se recarga la página entera
const carrusel = new Carrusel(images);
carrusel.crearContenedor();
carrusel.start(3000);

