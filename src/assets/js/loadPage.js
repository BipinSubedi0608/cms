import displayMenu from "./menuBox.js";

export default function loadPageInRootContainer(page) {
    $.ajax({
        url: '../../src/php/loadContent.php',
        type: 'POST',
        data: { page: page },
        success: function (response) {
            $('#root').html(response);
            (page == 'menu') && displayMenu();
        },
        error: function (error) {
            console.log(`Error ${error.status}: ${error.statusText}`);
        }
    });
}
