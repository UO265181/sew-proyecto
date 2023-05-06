class Tiempo {
    constructor() {
      this.temperature = null;
      this.description = null;
    }
  
    fetchData() {
        
      $.ajax({
        url: 'https://api.openweathermap.org/data/2.5/weather?lat=-5.410172&lon=43.416699&appid=f584ab7920bcc2b1c18704d726aea2a5',
        method: 'GET',
        success: (response) => {
            
          this.temperature = response.main.temp;
          this.description = response.weather.description;
          
          document.write('<p>')
          document.write('Temperature: ${this.temperature}');
          document.write('</p>')
          document.write('<p>')
          document.write('Description: ${this.description}');
          document.write('</p>')
        },
        error: (error) => {
          console.log('Error al obtener los datos meteorológicos:', error);
        },
      });
    }
  
  }



  document.write('<section>');
  document.write('<h2> Tiempo en Cabranes </h2>');

  // Crear una instancia de la clase Weather y llamar al método fetchData para obtener los datos
  const tiempo = new Tiempo();
  tiempo.fetchData();

  document.write('</section>');
  