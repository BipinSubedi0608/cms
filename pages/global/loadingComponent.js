const loader = `
<div class="loader">
    <div class="loadingio-spinner-chunk-w4qklb0qa1">
        <div class="ldio-p8rt08m3njs">
            <div>
                <div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .loader {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
    }

    @keyframes ldio-p8rt08m3njs-r {

        0%,
        25%,
        50%,
        75%,
        100% {
            animation-timing-function: cubic-bezier(0, 1, 0, 1)
        }

        0% {
            transform: scale(0.7000000000000001) rotate(180deg)
        }

        25% {
            transform: scale(0.7000000000000001) rotate(270deg)
        }

        50% {
            transform: scale(0.7000000000000001) rotate(360deg)
        }

        75% {
            transform: scale(0.7000000000000001) rotate(450deg)
        }

        100% {
            transform: scale(0.7000000000000001) rotate(540deg)
        }
    }

    @keyframes ldio-p8rt08m3njs-z {

        0%,
        50%,
        100% {
            animation-timing-function: cubic-bezier(1, 0, 0, 1)
        }

        0% {
            transform: scale(1)
        }

        50% {
            transform: scale(1)
        }

        100% {
            transform: scale(.5)
        }
    }

    @keyframes ldio-p8rt08m3njs-p {

        0%,
        50%,
        100% {
            animation-timing-function: cubic-bezier(1, 0, 0, 1)
        }

        0% {
            transform: scale(0)
        }

        50% {
            transform: scale(1)
        }

        100% {
            transform: scale(1)
        }
    }

    @keyframes ldio-p8rt08m3njs-c {

        0%,
        25%,
        50%,
        75%,
        100% {
            animation-timing-function: cubic-bezier(0, 1, 0, 1)
        }

        0% {
            background: #e15b64
        }

        25% {
            background: #f47e60
        }

        50% {
            background: #f8b26a
        }

        75% {
            background: #abbd81
        }

        100% {
            background: #e15b64
        }
    }

    .ldio-p8rt08m3njs>div {
        animation: ldio-p8rt08m3njs-r 4s linear infinite;
        transform-origin: 100px 100px;
    }

    .ldio-p8rt08m3njs>div>div {
        width: 200px;
        height: 200px;
        position: absolute;
        animation: ldio-p8rt08m3njs-z 1s linear infinite;
        transform-origin: 200px 200px;
    }

    .ldio-p8rt08m3njs>div>div div {
        position: absolute;
        width: 100px;
        height: 100px;
        background: #e15b64;
        transform-origin: 50px 50px
    }

    .ldio-p8rt08m3njs>div>div div:nth-child(1) {
        left: 0px;
        top: 0px;
        animation: ldio-p8rt08m3njs-p 1s linear infinite, ldio-p8rt08m3njs-c 4s linear infinite;
    }

    .ldio-p8rt08m3njs>div>div div:nth-child(2) {
        left: 100px;
        top: 0px;
        animation: ldio-p8rt08m3njs-p 1s linear infinite, ldio-p8rt08m3njs-c 4s linear infinite;
    }

    .ldio-p8rt08m3njs>div>div div:nth-child(3) {
        left: 0px;
        top: 100px;
        animation: ldio-p8rt08m3njs-p 1s linear infinite, ldio-p8rt08m3njs-c 4s linear infinite;
    }

    .ldio-p8rt08m3njs>div>div div:nth-child(4) {
        left: 100px;
        top: 100px;
        transform: scale(1);
        animation: ldio-p8rt08m3njs-c 4s linear infinite
    }

    .loadingio-spinner-chunk-w4qklb0qa1 {
        width: 200px;
        height: 200px;
        display: inline-block;
        overflow: hidden;
        background: transparent;
    }

    .ldio-p8rt08m3njs {
        width: 100%;
        height: 100%;
        position: relative;
        transform: translateZ(0) scale(1);
        backface-visibility: hidden;
        transform-origin: 0 0;
    }

    .ldio-p8rt08m3njs div {
        box-sizing: content-box;
    }
</style>
`;

export default loader;
