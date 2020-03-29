// Windows

// Ready Function
$(document).ready(function() {
    // Hide Soal
    $(".soal > .data").each(function(e) {
        if (e != 0) $(this).hide();
    });

    document.addEventListener('contextmenu', event => event.preventDefault());
    document.onkeydown = function() 
    {
        switch (event.keyCode) 
        {
            case 116 :
                event.returnValue = false;
                event.keyCode = 0;
                return false;
            case 27 :
                event.returnValue = false;
                event.keyCode = 0;
                return false;
            case 82 :
                if (event.ctrlKey) 
                {
                    event.returnValue = false;
                    event.keyCode = 0;
                    return false;
                }
            case 67 :
                if (event.ctrlKey) 
                {
                    event.returnValue = false;
                    event.keyCode = 0;
                    return false;
                }
            case 86 :
                if (event.ctrlKey) 
                {
                    event.returnValue = false;
                    event.keyCode = 0;
                    return false;
                }
            case 85 :
                if (event.ctrlKey) 
                {
                    event.returnValue = false;
                    event.keyCode = 0;
                    return false;
                }
            case 117 :
                if (event.ctrlKey) 
                {
                    event.returnValue = false;
                    event.keyCode = 0;
                    return false;
                }
            case 123 :
                if (event.ctrlKey) 
                {
                    event.returnValue = false;
                    event.keyCode = 0;
                    return false;
                }
        }
    }
});
document.onkeydown = function(e) {
    if (e.ctrlKey && 
        (e.keyCode === 67 || 
            e.keyCode === 86 || 
            e.keyCode === 85 || 
            e.keyCode === 117)) {
        return false;
    }
};
$(document).keydown(function (event) {
    if (event.keyCode == 123) {
        return false;
    } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73){      
        return false;
    }
});

// Event
// Full Screen
addEventListener("load", function() {
    var el = document.documentElement,
        rfs =
            el.requestFullScreen ||
            el.webkitRequestFullScreen ||
            el.mozRequestFullScreen;
    rfs.call(el);
    console.log("Fullscreen Mode On");
});

// FUNCTION 
// Soal On Reload
function SoalOnReload(){
    $('.soal > .data').hide();
    $('#Soal_1').show();
    $('#daftar1').addClass(' in-active');
    $('#nomor_soal').val('1');
}

// Send Jawaban Ke Tabel
function SendTable(no,val) {
    $('#td_'+no).html(val);
}
        
// Pindah Soal By Button Number
function Soal(i) {
    $('.soal > .data').hide();
    $('#Soal_'+i).show();
    $('.tombol > a').removeClass(' in-active');
    $('#daftar'+i).addClass(' in-active');
    $('#nomor_soal').val(i);
}

// Pindah Soal By Button Prev
function Prev() {
    var active_number = $('#nomor_soal').val();
    var prev = (active_number*1)-(1*1);
    if(active_number!=1){
        $('.soal > .data').hide();
        $('#Soal_'+prev).show();
        $('.tombol > a').removeClass(' in-active');
        $('#daftar'+prev).addClass(' in-active');
        $('#nomor_soal').val(prev);
    }
}

// Pindah Soal By Button Next
function Next(i) {
    var active_number = $('#nomor_soal').val();
    var next = (active_number*1)+(1*1);
    if(active_number!=i){
        $('.soal > .data').hide();
        $('#Soal_'+next).show();
        $('.tombol > a').removeClass(' in-active');
        $('#daftar'+next).addClass(' in-active');
        $('#nomor_soal').val(next);
    }
}

// Selesai Ujian
function selesai(url){
    var i;
    var cookies = document.cookie.split(";");
    for(var i=1; i <= 10; i++){
        deleteAllCookies();
    }
    for (
        var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
    document.cookie = 'minutes=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    document.cookie = 'seconds=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    for (var c = 0; c < cookies.length; c++) {
        var d = window.location.hostname.split(".");
        while (d.length > 0) {
            var cookieBase = encodeURIComponent(cookies[c].split(";")[0].split("=")[0]) + '=; expires=Thu, 01-Jan-1970 00:00:01 GMT; domain=' + d.join('.') + ' ;path=';
            var p = location.pathname.split('/');
            document.cookie = cookieBase + '/';
            while (p.length > 0) {
                document.cookie = cookieBase + p.join('/');
                p.pop();
            };
            d.shift();
        }
    }
    return document.location=url;
}
