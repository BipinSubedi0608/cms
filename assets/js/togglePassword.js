export default function togglePassword() {
    if ($('.eyeBtn').hasClass('fa-eye')) {

        $('.eyeBtn').removeClass('fa-eye');
        $('.eyeBtn').addClass('fa-eye-slash');
        $('.eyeBtn').siblings('input').attr('type', 'password');
    } else {

        $('.eyeBtn').removeClass('fa-eye-slash');
        $('.eyeBtn').addClass('fa-eye');
        $('.eyeBtn').siblings('input').attr('type', 'text');
    }
}