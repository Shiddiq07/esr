<script>
    // Greeting and Time-Based Message
    const hours = new Date().getHours();
    const greetingText = hours < 12 ? "Good Morning" : (hours < 18 ? "Good Afternoon" : "Good Evening");
    const greetings = $("#greeting-time").text();

    $("#greeting-time").text(`${greetingText}, ${greetings}`);

    // Weather API Fetch
    function fetchWeather() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(success, error);
        } else {
            displayError("Geolocation not supported.");
        }
    }

    function clock() {
        setInterval(() => {
            const currentDate = new Date();
            const time = `${currentDate.getHours().toString().padStart(2, '0')}:${currentDate.getMinutes().toString().padStart(2, '0')}`;

            $('#weather-time').text(time)
        }, 1000)
    }

    function success(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;

        // API call to OpenWeatherMap
        fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=1c90b186ba7aed055fa57e2c883db862&units=metric`)
            .then(response => response.json())
            .then(data => displayWeather(data))
            .catch(() => displayError("Error fetching weather data."));
    }

    function error() {
        displayError("Location permission denied.");
    }

    function displayWeather(data) {
        const weatherContainer = $("#weather-info");
        const temp = data.main.temp;
        const humidity = data.main.humidity;
        const condition = `${data.weather[0].main} - ${data.weather[0].description}`;
        const wind = data.wind.speed;

        // Choose icon based on weather condition and day/night
        const icon = data.weather[0].icon;
        let weatherIcon;
        if (icon.includes("d")) { // Day icons
            weatherIcon = condition.includes("Rain") ? "bi bi-cloud-rain text-info" : 
                          condition.includes("Cloud") ? "bi bi-cloud text-light" : 
                          "bi bi-sun text-warning";
        } else { // Night icons
            weatherIcon = condition.includes("Rain") ? "bi bi-cloud-rain-fill text-primary" : 
                          condition.includes("Cloud") ? "bi bi-cloud-moon text-secondary" : 
                          "bi bi-moon text-dark";
        }

        // Update Weather Card Content
        $('#weather-location').text(data.name)
        $('#weather-degree').text(`${Math.round(temp)}°C`)
        $('#weather-text').text(condition)
        $('#weather-wind').text(`${wind} km/h`)
        $('#weather-humid').text(`${humidity}%`)
        $('#weather-icon').attr('class', `${weatherIcon} fs-1`);
    }

    function displayError(message) {
        $("#weather-info").html(`<p>${message}. Weather data unavailable.</p>`);

        console.error(`<p>${message}. Weather data unavailable.</p>`);
    }

    fetchWeather();
    clock();
</script>
