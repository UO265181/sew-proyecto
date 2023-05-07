class Noticias {
    constructor(maxArticulos) {
        this.articles = null;
        this.maxArticulos = maxArticulos;
    }

    fetchData() {

        $.ajax({
            url: 'https://api.newscatcherapi.com/v2/search?q=Cabranes%20AND%20Asturias&lang=es&sort_by=date',
            method: 'GET',
            headers: {
                'x-api-key': '5qJpx5i3nRb0GxeX-ycugDrmkwsvw01bjtQX2ctUU5A'
            },
            success: (response) => {

                this.articles = response.articles;

                this.render();

            },
            error: (error) => {
                console.log('Error al obtener noticas:', error);
            },
        });
    }

    render() {

        const section = document.createElement('section');

        const h2 = document.createElement('h2')
        h2.textContent = 'Noticias';

        section.appendChild(h2);

        if (this.articles.length == 0) {
            const pNoNoticias = document.createElement('p');
            pNoNoticias.textContent = 'No existen noticias recientes.';
        } else {

            for(let i=0; i<this.articles.length && i<this.maxArticulos; i++) {


                const article = document.createElement('article');

                const h3 = document.createElement('h3')
                h3.textContent = this.articles[i].title;

                const pFecha = document.createElement('p')
                pFecha.textContent = this.articles[i].published_date;

                const pArticulo = document.createElement('p')
                pArticulo.textContent = this.articles[i].summary;

                const ulFuentes = document.createElement('ul');
                const liAutor = document.createElement('li');
                liAutor.textContent = `Autor: ${this.articles[i].authors}`;
                const liDerechos = document.createElement('li');
                liDerechos.textContent = `Derechos: ${this.articles[i].rights}`;
                const liEnlace = document.createElement('li');
                const aEnlance = document.createElement('a');
                aEnlance.textContent = `Enlace a la noticia`;
                aEnlance.href = this.articles[i].link;

                liEnlace.appendChild(aEnlance);

                ulFuentes.appendChild(liAutor);
                ulFuentes.appendChild(liDerechos);
                ulFuentes.appendChild(liEnlace);

                article.appendChild(h3);
                article.appendChild(pFecha);
                article.appendChild(pArticulo);
                article.appendChild(ulFuentes);

                section.appendChild(article);
            }
        }
        document.getElementsByTagName('main')[0].appendChild(section);
    }

}

const noticias = new Noticias(3);
noticias.fetchDataAndRender();


