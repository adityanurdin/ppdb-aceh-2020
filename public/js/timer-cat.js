var timeoutHandle;
function countdown(minutes,stat,url) {
    var seconds = 60;
    var mins = minutes*1;
    // var url = url;
	 
	if(getCookie("minutes")&&getCookie("seconds")&&stat)
	{
		var seconds = getCookie("seconds");
		var mins = getCookie("minutes");
	}
	 
    function tick() {
        var counter = document.getElementById("timer");
		setCookie("minutes",mins,1)
		setCookie("seconds",seconds,1)
        var current_minutes = mins-1;
        seconds--;
        counter.innerHTML = current_minutes.toString() + " Menit : " + (seconds < 10 ? "0" : "") + String(seconds) + " Detik";
		//save the time in cookie
        if(seconds > 0) {
            timeoutHandle=setTimeout(tick, 1000);
        }else{
            if(mins > 1){
               setTimeout(function () { countdown(parseInt(mins)-1,false); }, 1000);
            }
        }
        // if((current_minutes==0)&&(seconds==00)){
        //     UpdateSemuaJawaban();
        //     var i;
        //     var cookies = document.cookie.split(";");
        //     for(var i=1; i <= 10; i++){
        //         deleteAllCookies();
        //     }
        //     for (
        //         var i = 0; i < cookies.length; i++) {
        //         var cookie = cookies[i];
        //         var eqPos = cookie.indexOf("=");
        //         var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        //         document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        //     }
        //     document.cookie = 'minutes=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        //     document.cookie = 'seconds=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        //     for (var c = 0; c < cookies.length; c++) {
        //         var d = window.location.hostname.split(".");
        //         while (d.length > 0) {
        //             var cookieBase = encodeURIComponent(cookies[c].split(";")[0].split("=")[0]) + '=; expires=Thu, 01-Jan-1970 00:00:01 GMT; domain=' + d.join('.') + ' ;path=';
        //             var p = location.pathname.split('/');
        //             document.cookie = cookieBase + '/';
        //             while (p.length > 0) {
        //                 document.cookie = cookieBase + p.join('/');
        //                 p.pop();
        //             };
        //             d.shift();
        //         }
        //     }
        //     ExportJawaban('frans_table');
        //     return document.location=url;
        // }
        if((current_minutes==0)&&(seconds==00)){
            UpdateSemuaJawaban();
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
            document.cookie = 'minutes; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            document.cookie = 'seconds; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
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
            ExportJawaban('frans_table');
            return document.location=url;
        }
    }
    tick();
}
function setCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname+"="+cvalue+"; "+expires;
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function deleteAllCookies() {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}