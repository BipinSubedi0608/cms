export function loginCall(formData) {
    Swal.fire({
        title: 'Loading...',
        html: `<div style="overflow: hidden"><div class="spinner-border"></div></div>`,
        allowOutsideClick: false,
        showConfirmButton: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        },
    });

    $.ajax({
        url: '../../php/general/login.php',
        type: 'POST',
        data: { 'operation': 'login', ...formData },
        success: function (response) {
            Swal.close();
            console.log(response);
            response = JSON.parse(response);

            if (response.status != undefined && response.status != 200) {
                Swal.fire({
                    icon: 'error',
                    title: `Error ${response.status}`,
                    text: response.message,
                    timer: 3000
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Login Successful!',
                    showConfirmButton: false,
                    timer: 1000
                }).then(() => {
                    location.reload(true);
                });
            }
        },
        error: function (error) {
            Swal.close();
            console.log(`Error ${error.status}: ${error.statusText}`);
            Swal.fire({
                icon: 'error',
                title: `Error ${error.status}`,
                text: error.message,
                timer: 3000
            });
        }
    });
}

export function logoutCall() {
    $.ajax({
        url: '../../php/general/login.php',
        type: 'POST',
        data: { 'operation': 'logout' },
        success: function (response) {
            location.reload(true);
        },
        error: function (error) {
            console.log(`Error ${error.status}: ${error.statusText}`);
        }
    });
}
