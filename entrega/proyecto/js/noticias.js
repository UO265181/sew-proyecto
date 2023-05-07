class Noticias {
    constructor() {
        this.nArticles = null;
    }

    fetchData() {

        $.ajax({
            url: 'https://newsapi.org/v2/everything?q=cabranes&language=es&apiKey=f61b8609c11a431fb4fbc79dfd29cb6b',
            method: 'GET',
            success: (response) => {

                this.nArticles=response.totalResults;
                

                this.renderData();
            },
            error: (error) => {
                console.log('Error al obtener noticas:', error);
            },
        });
    }

    renderData() {
       
        

        document.getElementsByTagName('main')[0].appendChild(section);
    }

}

const noticias = new Noticias();
noticias.fetchData();


