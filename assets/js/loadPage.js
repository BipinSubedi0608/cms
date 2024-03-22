import loader from '../../pages/global_pages/loadingComponent.js';

export default function loadPageInRootContainer(page) {
    $('body').append(loader);
    $('body').css("pointer-events", "none");
    $('.active').removeClass("active");
    $(`.navbarBtn[data-page=${page}]`).addClass("active");

    $.ajax({
        url: '../../php/general/loadContent.php',
        type: 'POST',
        data: { page: page },
        success: async function (response) {
            $('body .loader').remove();
            $('body').css("pointer-events", "all");
            if (page == 'login') {
                $('body').html(response);
            } else {
                $('#root').html(response);
                loadBackground(page);
            }
        },
        error: function (error) {
            $('body .loader').remove();
            $('body').css("pointer-events", "all");
            console.log(`Error ${error.status}: ${error.statusText}`);
        }
    });
}

function loadBackground(page) {
    let backgroundData = "#ffffff";
    switch (page) {
        case 'home':
            backgroundData = "url(../assets/images/Home-Background.jpg)";
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

export async function getCurrentPage() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '../../php/general/loadContent.php',
            type: 'GET',
            data: { 'operation': 'get' },
            success: function (response) {
                resolve(response);
            },
            error: function (error) {
                console.log(`Error ${error.status}: ${error.statusText}`);
                reject(error.statusText);
            }
        });
    });
}