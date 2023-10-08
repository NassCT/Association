var script = document.createElement('script');
script.src = "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js";
script.integrity = "sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==";
script.crossOrigin = "anonymous";
script.referrerPolicy = "no-referrer";
document.head.appendChild(script);

script.onload = function() {
    $(document).ready(function () {
        $(".message a").click(function () {
            $(".register-form").toggle("slow");
            $(".login-form").toggle("slow");
        });
    });
};