(function($){
    $.fn.downCount = function(options,callback)
    {
        var settings = $.extend({
            date:null,
            offset:null
        },options);

        if(!settings.date){
            $.error('La date n\'est pas définie.')
        }

        if(!Date.parse(settings.date)) {
            $.error('format de date incorect, 01/01/2023 12:00:00.')
        }

        var container   = this;
        var currentDate = function() {
        var date        = new Date();
        var utc         = date.getTime() + (date.getTimezoneOffset()*60000);
        var new_date    = new Date(utc+(3600000*settings.offset));
            return new_date
        };

        function countdown() {
            var target_date  = new Date(settings.date),
                current_date = currentDate();

            var difference = target_date-current_date;

            if (difference < 0) {
                clearInterval(interval);
                if (callback && typeof callback === 'function')
                    callback();
                return
            }

            var _second = 1000,
                _minute = _second*60,
                _hour   = _minute*60,
                _day    = _hour*24,
                _years  = _day*365;

            var years    = Math.floor(difference/_years),
                days     = Math.floor((difference%_years)/_day),
                hours    = Math.floor((difference%_day)/_hour),
                minutes  = Math.floor((difference%_hour)/_minute),
                seconds  = Math.floor((difference%_minute)/_second);

                years    = (String(years).length>=2)   ? years   : '0'+years;
                days     = (String(days).length>=2)    ? days    : '0'+days;
                hours    = (String(hours).length>=2)   ? hours   : '0'+hours;
                minutes  = (String(minutes).length>=2) ? minutes : '0'+minutes;
                seconds  = (String(seconds).length>=2) ? seconds : '0'+seconds;

            var ref_years    = (years   === 1) ?'year'   :'years',
                ref_days     = (days    === 1) ?'day'    :'days',
                ref_hours    = (hours   === 1) ?'hour'   :'hours',
                ref_minutes  = (minutes === 1) ?'minute' :'minutes',
                ref_seconds  = (seconds === 1) ?'second' :'seconds';

                container.find('.years').text(years);
                container.find('.days').text(days);
                container.find('.hours').text(hours);
                container.find('.minutes').text(minutes);
                container.find('.seconds').text(seconds);

                container.find('.years_ref').text(ref_years);
                container.find('.days_ref').text(ref_days);
                container.find('.hours_ref').text(ref_hours);
                container.find('.minutes_ref').text(ref_minutes);
                container.find('.seconds_ref').text(ref_seconds)
        };
        var interval = setInterval(countdown,1000)
    }
    if ($(".counter-widget").length > 0) {
        var countCurrent = $(".counter-widget").attr("data-countDate");
        var countfuseau = $(".counter-widget").attr("data-fuseau");
        $(".countdown").downCount({
            date: countCurrent,
            offset: countfuseau
        });
    }
})(jQuery);

(function($){'use strict';
    $.ajaxChimp={responses:{'We have sent you a confirmation email':0,'Please enter a value':1,'An email address must contain a single @':2,'The domain portion of the email address is invalid (the portion after the @: )':3,'The username portion of the email address is invalid (the portion before the @: )':4,'This email address looks fake or invalid. Please enter a real email address':5},translations:{'en':null},init:function(selector,options){$(selector).ajaxChimp(options)}};$.fn.ajaxChimp=function(options){$(this).each(function(i,elem){var form=$(elem);var email=form.find('input[type=text]');var label=form.find('label[for='+email.attr('id')+']');var settings=$.extend({'url':form.attr('action'),'language':'en'},options);var url=settings.url.replace('/post?','/post-json?').concat('&c=?');form.attr('novalidate','true');email.attr('name','EMAIL');form.submit(function(){var msg;function successCallback(resp){if(resp.result==='success'){msg='We have sent you a confirmation email';label.removeClass('error').addClass('valid');email.removeClass('error').addClass('valid')}else{email.removeClass('valid').addClass('error');label.removeClass('valid').addClass('error');var index=-1;try{var parts=resp.msg.split(' - ',2);if(parts[1]===undefined){msg=resp.msg}else{var i=parseInt(parts[0],10);if(i.toString()===parts[0]){index=parts[0];msg=parts[1]}else{index=-1;msg=resp.msg}}}catch(e){index=-1;msg=resp.msg}}if(settings.language!=='en'&&$.ajaxChimp.responses[msg]!==undefined&&$.ajaxChimp.translations&&$.ajaxChimp.translations[settings.language]&&$.ajaxChimp.translations[settings.language][$.ajaxChimp.responses[msg]]){msg=$.ajaxChimp.translations[settings.language][$.ajaxChimp.responses[msg]]}label.html(msg);label.show(2000);if(settings.callback){settings.callback(resp)}}var data={};var dataArray=form.serializeArray();$.each(dataArray,function(index,item){data[item.name]=item.value});$.ajax({url:url,data:data,success:successCallback,dataType:'jsonp',error:function(resp,text){console.log('mailchimp ajax submit error: '+text)}});var submitMsg='Submitting...';if(settings.language!=='en'&&$.ajaxChimp.translations&&$.ajaxChimp.translations[settings.language]&&$.ajaxChimp.translations[settings.language]['submit']){submitMsg=$.ajaxChimp.translations[settings.language]['submit']}label.html(submitMsg).show(2000);return false})});return this}})(jQuery);
    var $one = $(".mm-parallax"),
        browserPrefix = "",
        usrAg = navigator.userAgent;
    if (usrAg.indexOf("Chrome") > -1 || usrAg.indexOf("Safari") > -1) browserPrefix = "-webkit-";
    else if (usrAg.indexOf("Opera") > -1) browserPrefix = "-o";
    else if (usrAg.indexOf("Firefox") > -1) browserPrefix = "-moz-";
    else if (usrAg.indexOf("MSIE") > -1) browserPrefix = "-ms-";
    $(".hero-wrap").mousemove(function (a) {
        var b = Math.ceil(window.innerWidth / 1.5),
            c = Math.ceil(window.innerHeight / 1.5),
            d = a.pageX - b,
            e = a.pageY - c,
            f = e / c,
            g = -(d / b),
            h = Math.sqrt(Math.pow(f, 2) + Math.pow(g, 2)),
            i = 10 * h;
        $one.css(browserPrefix + "transform", "rotate3d(" + f + ", " + g + ", 0, " + i + "deg)");
    });
$('head').append('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">');
document.addEventListener('gesturestart', function (e) {
    e.preventDefault();
});
 