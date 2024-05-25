function showIpLocation() {
    $(".robotx-location").text("正在查询...");
    $(".robotx-ip").each(function () {
        var myd = $(this);
        fetch('https://ip.zxinc.org/api.php?ip=' + myd.text())
            .then(response => response.text())
            .then(data => {
                // Parse the XML response
                let parser = new DOMParser();
                let xmlDoc = parser.parseFromString(data, "text/xml");

                // Extract the location information
                let location = xmlDoc.getElementsByTagName('location')[0].childNodes[0].nodeValue;
                myd.next().text(location).css("color", "#BD6800");
            })
            .catch(error => {
                myd.next().text("无该 IP 详细信息").css("color", "#f00");
                console.error('Error:', error)
            });
    });
}

$(document).ready(function () {
    $(".check-ip-location").click(showIpLocation);
    $(".robotx-ip").click(function () {
        $('.search-ip').val($(this).data('ip'));
        $('.search-btn').trigger('click');
    });
    $(".robotx-bot-name").click(function () {
        $('.search-bot').val($(this).data('bot'));
        $('.search-btn').trigger('click');
    });
    $(".clear-search-ip").click(function () {
        $('.search-ip').val("");
        $('.search-btn').trigger('click');
    });
});