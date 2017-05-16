$("body").on("contextmenu", function (e) {
    return false;
});

$('body').bind('cut copy', function (e) {
    e.preventDefault();
});

$(window).bind('keydown', function (event) {
    if (event.ctrlKey || event.metaKey) {
        switch (String.fromCharCode(event.which).toLowerCase()) {
            case 's':
                event.preventDefault();
                break;
        }
    }
});
