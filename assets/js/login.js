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
            response = JSON.parse(response);

            if (response.status != undefined && response.status != 200) {
                Swal.fire({
                    icon: 'error',
                    title: `Error ${response.status}`,
                    text: response.message,
                    showConfirmButton: true,
                    timer: 3000,
                    timerProgressBar: true,
                });

            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Login Successful!',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                }).then(() => {
                    location.reload(true);
                });
            }
        },
        error: function (error) {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: `Error ${error.status}`,
                text: error.message,
                showConfirmButton: true,
                timer: 3000,
                timerProgressBar: true,
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
