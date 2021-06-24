function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function goTop() {
    $("html, body").animate({scrollTop: 0}, "slow");
    return false;
}

function sepetCount() {

    const url = document.getElementsByTagName('base')[0].href;

    $.get(url+"sepet/count", function (repsonse) {
        let count = 0;
        if (repsonse) {
            count = repsonse;
        }
        $('a.sepetm span').html(count);
        $('#sepet span').html(count);
        $('#sepet_adet').html(count);
        $('.sepet i span').html(count);
    });
}