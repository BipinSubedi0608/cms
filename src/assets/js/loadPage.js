export function loadContent(page) {
    $.ajax({
        url: '../../src/php/loadContent.php',
        type: 'POST',
        data: { page: page },
        success: function (response) {
            // console.log('Response:', response);
            $('#root').html(response);
        },
        error: function (error) {
            console.log(`Error ${error.status}: ${error.statusText}`);
        }
    });
}

$(document).ready(function () {
    // loadContent('home');
    $('.navbarBtn').click(function (e) {
        e.preventDefault();
        var page = $(this).data('page');
        [...$('.navbarBtn')].forEach((element) => {
            $(element).removeClass('active')
        });
        $(this).addClass('active');
        loadContent(page);
    });

    $('.profileBtn').click(function (e) {
        e.preventDefault();
        [...$('.navbarBtn')].forEach((element) => {
            $(element).removeClass('active')
        });
        loadContent('profile');
    });

    $('.orderBtn').click(function (e) {
        e.preventDefault();
        console.log('hello');
        loadContent('menu');
    })
});