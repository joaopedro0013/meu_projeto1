const container = document.querySelector('.container');
const search = document.querySelector('.container button');
const temperatura = document.querySelector('.temperatura');
const detalhes_clima = document.querySelector('.detalhes_clima');
const error404 = document.querySelector('.not-found');

search.addEventListener('click', () => {

    const APIKey = '65ad99c859117d377d0045cc2e9e1fb0';
    const city = document.querySelector('.container input').value;

    if (city === '')
        return;

    fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${APIKey}`)
        .then(response => response.json())
        .then(json => {

            if (json.cod === '404') {
                container.style.height = '400px';
                temperatura.style.display = 'none';
                detalhes_clima.style.display = 'none';
                error404.style.display = 'block';
                error404.classList.add('fadeIn');
                return;
            }

            error404.style.display = 'none';
            error404.classList.remove('fadeIn');

            const image = document.querySelector('.temperatura img');
            const temperature = document.querySelector('.temperatura .temperature');
            const description = document.querySelector('.temperatura .description');
            const humidity = document.querySelector('.detalhes_clima .umidade span');
            const wind = document.querySelector('.detalhes_clima .vento span');

            switch (json.weather[0].main) {
                case 'Clear':
                    image.src = 'images/clear.png';
                    break;

                case 'Rain':
                    image.src = 'images/rain.png';
                    break;

                case 'Snow':
                    image.src = 'images/snow.png';
                    break;

                case 'Clouds':
                    image.src = 'images/cloud.png';
                    break;

                case 'Haze':
                    image.src = 'images/mist.png';
                    break;

                default:
                    image.src = '';
            }

            temperature.innerHTML = `${parseInt(json.main.temp)}<span>°C</span>`;
            description.innerHTML = `${json.weather[0].description}`;
            humidity.innerHTML = `${json.main.humidity}%`;
            wind.innerHTML = `${parseInt(json.wind.speed)}Km/h`;

            temperatura.style.display = '';
            detalhes_clima.style.display = '';
            temperatura.classList.add('fadeIn');
            detalhes_clima.classList.add('fadeIn');


        });


});