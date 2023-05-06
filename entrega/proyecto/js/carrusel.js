class Carrusel {


    constructor(images) {
        this.images = images;
        this.currentIndex = 0;
    }

    render(contenedor) {
        var img = document.createElement('img');
        img.src = this.images[this.currentIndex].src;
        img.alt = this.images[this.currentIndex].alt;

        var figCaption = document.createElement('figCaption');
        figCaption.textContent = this.images[this.currentIndex].figCaption;

        contenedor.innerHTML = '';
        contenedor.appendChild(img);
        contenedor.appendChild(figCaption);
    }

    start(interval, contenedor) {
        this.contenedor = contenedor;
        this.render(this.contenedor);
        this.intervalId = setInterval(() => this.next(), interval);
    }

    next() {
        this.currentIndex = (this.currentIndex + 1) % this.images.length;
        this.render(this.contenedor);
    }

    prev() {
        this.currentIndex = (this.currentIndex + this.images.length - 1) % this.images.length;
        this.render(this.contenedor);
    }
}

const images = [
    {src:'multimedia/carrusel1.jpg', alt:'Foto de la placa de Cabranes', figCaption: 'Placa de Cabranes'},
    {src:'multimedia/carrusel2.jpg', alt:'Foto de la cima del monte Incós', figCaption: 'Monte Incós'},
    {src:'multimedia/carrusel3.jpg', alt:'Foto de la Iglesia de San Martín el Real en Torazo', figCaption: 'Iglesia de San Martín el Real'},
    {src:'multimedia/carrusel4.jpg', alt:'Foto de los vecinos reunidos en el festival del arroz', figCaption: 'Festival de Arroz'},
    {src:'multimedia/carrusel5.jpg', alt:'Foto del antiguo castillete minero', figCaption: 'Castillete minero'}];

document.write('<section>');
document.write('<h2> Carrusel de imágenes de Cabranes </h2>');
document.write('<figure id="carrusel"></figure>');
document.write('<button id="prev">Anterior</button>');
document.write('<button id="next">Siguiente</button>');
document.write('</section>');

//TODO: se puede usar esto??
const contenedor = document.getElementById('carrusel');
const prevButton = document.getElementById('prev');
const nextButton = document.getElementById('next');

//TODO: la primera vez que se renderiza una imagen se recarga la página entera
const carrusel = new Carrusel(images);
carrusel.start(3000, contenedor);

prevButton.addEventListener('click', () => carrusel.prev());
nextButton.addEventListener('click', () => carrusel.next());