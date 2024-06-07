// エリア検索・ジャンル検索・店名検索

$(document).ready(function () {
    $('#Sort_Select').keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#Sort_Form').submit();
        }
    });


    $('#Area_Select').keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#Area_Form').submit();
        }
    });

    $('#Genre_Select').keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#Genre_Form').submit();
        }
    });

    $('#Shop_Select').keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#Name_Form').submit();
        }
    });
});

