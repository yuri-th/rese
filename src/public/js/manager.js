// ----------全角を半角に自動変換---------- //

function replaceFullToHalf(str) {
    var halfVal = str.replace(/[！-～]/g, function (s) {
        return String.fromCharCode(s.charCodeAt(0) - 0xfee0);
    });
    return halfVal.replace(/ー/g, "-");
}

var PostCode = document.getElementById("postcode");
PostCode.addEventListener("change", function () {
    var strdata = document.getElementById("postcode").value;
    var handata = replaceFullToHalf(strdata);
    document.getElementById("postcode").value = handata;
});
