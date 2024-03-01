import loader from '../../pages/global/loadingComponent.js';

export default function loadPageInRootContainer(page) {
    $('body').append(loader);

    $.ajax({
        url: '../../php/general/loadContent.php',
        type: 'POST',
        data: { page: page },
        success: function (response) {
            $('body .loader').remove();
            if (page == 'login') {
                $('body').html(response);
            } else {
                $('#root').html(response);
                loadBackground(page);
            }
        },
        error: function (error) {
            $('body .loader').remove();
            console.log(`Error ${error.status}: ${error.statusText}`);
        }
    });
}

function loadBackground(page) {
    let backgroundData = "#ffffff";
    switch (page) {
        case 'home':
            backgroundData = "url(../assets/images/Home-Background.jpg)";
            // background-image: url('../images/Home-Background.jpg');
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
