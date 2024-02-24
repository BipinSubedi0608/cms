export default function loadPageInRootContainer(page) {
    $.ajax({
        url: '../../src/php/general/loadContent.php',
        type: 'POST',
        data: { page: page },
        success: function (response) {
            $('#root').html(response);
        },
        error: function (error) {
            console.log(`Error ${error.status}: ${error.statusText}`);
        }
    });
}
