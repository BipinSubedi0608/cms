import loader from "../../pages/global/loadingComponent.js";

export function showLoading() {
    $('body').append(loader);
}

export function hideLoading() {
    $('body .loader').remove();
}