import carouselItems from "../Models/carouselItems";

document.addEventListener("DOMContentLoaded", function () {

    // Get the container for dynamic carousel items
    var dynamicCarouselContainer = document.getElementById(
        "dynamicCarouselItems"
    );

    // Loop through carousel items and create dynamic HTML
    carouselItems.forEach(function (item, index) {
        var isActive = index === 0 ? "active" : "";

        var dynamicCarouselItem = `
        <div class="carousel-item ${isActive}">
          <div class="container custom-container">
            <div class="row align-items-center">
              <div class="col-md-9 col-lg-6 col-sm-12">
                <div class="detail-box text-center text-md-start">
                  <h1 class = "font-style: italic">${item.title}</h1>
                  <p>${item.description}</p>
                  <div class="btn-box">
                    <button class="hover:bg-red-600 hover:text-white transition ease-in-out duration-300 text-white border-2 border-red-600 font-bold py-2 px-4 rounded-full">
                      Order Now
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      `;
        // Append the dynamic carousel item to the container
        dynamicCarouselContainer.innerHTML += dynamicCarouselItem;
    });
});