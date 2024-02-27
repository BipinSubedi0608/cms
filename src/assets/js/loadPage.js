export default function loadPageInRootContainer(page) {
    console.log('Hello');
    $.ajax({
        url: '../../src/php/general/loadContent.php',
        type: 'POST',
        data: { page: page },
        success: function (response) {
            console.log(response);
            if (page == 'login') {
                $('body').html(response);
            } else {
                $('#root').html(response);
            }
        },
        error: function (error) {
            console.log(`Error ${error.status}: ${error.statusText}`);
        }
    });
}
