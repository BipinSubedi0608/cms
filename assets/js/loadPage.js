import { showLoading, hideLoading } from "./loading.js";

export default function loadPageInRootContainer(page) {
    showLoading();
    $.ajax({
        url: '../../php/general/loadContent.php',
        type: 'POST',
        data: { page: page },
        success: function (response) {
            hideLoading();
            if (page == 'login') {
                $('body').html(response);
            } else {
                $('#root').html(response);
                loadBackground(page);
            }
        },
        error: function (error) {
            hideLoading();
            console.log(`Error ${error.status}: ${error.statusText}`);
        }
    });
}

function loadBackground(page) {
    let backgroundData = "#ffffff";
    switch (page) {
        case 'home':
            backgroundData = "url(../images/Home-Background.jpg)";
            break;
        case 'about':
            backgroundData = "#222831";
            break;
        default:
            backgroundData = "#ffffff";
            break;
    }

    $('body').css('background', backgroundData);
}
