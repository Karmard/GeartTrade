document.addEventListener('DOMContentLoaded', function () {
    const menuIcon = document.querySelector('.menu-icon');
    const nav = document.querySelector('nav');

    menuIcon.addEventListener('click', function () {
        nav.classList.toggle('active');
    });
});







$(document).ready(function () {
    console.log("JS code is running."); // Log that the JavaScript code is running

    function getCarListingsFromServer() {
        return $.ajax({
            url: 'cars.php',
            method: 'GET',
            dataType: 'json',
        });
    }

    const carListingsSection = $('#carListings');

    // Fetch car listings from the server
    getCarListingsFromServer()
        .done(function (carListings) {
            console.log("Received car listings:", carListings); // Log the received car listings

            carListings.forEach(car => {
                const priceFormatted = formatPrice(car.price);

                const carHTML = `
                    <div class="carListing">
                        <img src="${car.frontimage}" alt="${car.carName}">
                        <h3>${car.carName}</h3>
                        <p>Price: ${priceFormatted}</p>
                        <p>Listed by: ${car.username}</p>
                    </div>
                `;

                carListingsSection.append(carHTML);
            });
        })
        .fail(function (error) {
            console.error('Error fetching car listings:', error);
        });
});
