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
    // console.log("Fullscreen Mode On");
});

// Full Screen
$(document).mousemove(function(event) {
    var elem = document.documentElement;
    if( window.innerWidth != screen.width || window.innerHeight != screen.height) {
        // Cek Full Screen
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.mozRequestFullScreen) {
            /* Firefox */
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) {
            /* Chrome, Safari & Opera */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            /* IE/Edge */
            elem.msRequestFullscreen();
        }
    }
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
    UpdateSemuaJawaban();
    document.cookie = 'minutes=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/CAT/store/ujian';
    document.cookie = 'seconds=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/CAT/store/ujian';
    document.cookie = 'cat_ujian=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
    document.cookie = 'kode_soal=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
    ExportJawaban('frans_table');
    return document.location=url;
}
