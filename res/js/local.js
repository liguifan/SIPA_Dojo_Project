function redirect_url(url)
{
    if(url === "")
        url = document.location.href;
    document.location.href = url;
}
function DoAJAX(url, postData, retData)
{
    if (window.XMLHttpRequest) {              
        AJAX=new XMLHttpRequest();              
    } else {                                  
        AJAX=new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (AJAX) {
        try
        {
            AJAX.open("POST", url, false);
            AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            AJAX.send(postData);

            retData.data = AJAX.responseText;

            var indexStr = retData.data.indexOf("<!-- Hosting24 Analytics Code -->");
            if(indexStr >= 0)
                retData.data = retData.data.substring(0, indexStr - 2);
            return true;
        }
        catch(err)
        {
            //alert("Unknown error occured!!");
        }
    }   
    return false;
}
function DoAJAXJason(url, postData)
{
    var postMix = "";
    if(postData)
    {
        $.each(postData, function(k,v)
        {
            if(postMix != "")
                postMix += "&";
            postMix += k;
            postMix += "=";
            postMix += encodeURIComponent(v);
        });
        //alert(postMix);
    }
    var retData = {data:""};
    if(DoAJAX(url, postMix, retData))
    {
        try{
            return JSON.parse(retData.data);
        }catch(err){}
    }
    return null;
}
function DoAJAXPost(url, postData)
{
    var retData = DoAJAXJason(url, postData);
    if(retData)
    {
        var pass = false;
        $.each(retData, function(k,v)
        {
            //alert(k);
            if(k == "Message")
            {
                alert(v);
            }
            else if(k == "ErrorCode")
            {
                pass = (v == 0);
            }
        });
    }
    return pass;
}
function parse_date(string) {  
    var date = new Date();  
    var parts = String(string).split(/[- :]/);  

    date.setFullYear(parts[0]);  
    date.setMonth(parts[1] - 1);  
    date.setDate(parts[2]);  
    date.setHours(parts[3]);  
    date.setMinutes(parts[4]);  
    date.setSeconds(parts[5]);  
    date.setMilliseconds(0);  

    return date;  
}function parse_time(string) {  
    var date = new Date();  
    var parts = String(string).split(':');  
    if(parts.length >= 2)
        date = new Date(date.getFullYear(), date.getMonth(), date.getDate(), parts[0], parts[1]);
    return date;  
}
function parse_date_js(string) {  

    try{
        var parts = String(string).split(/[- :\\]/);  
        //console.log(parts);
        if(parts.length == 3)
        {
            var hours = parseInt(parts[0]);
            if(parts[2] == "PM")
                hours += 12;
            else if(hours >= 12)
                hours = 0;

            var today = new Date();
            var date = new Date(    today.getFullYear(),
                                    today.getMonth(),
                                    today.getDate(),
                                    hours,
                                    parseInt(parts[1]));
        }
        else
        {
            var hours = parseInt(parts[3]);
            if(parts[5] == "PM")
                hours += 12;
            else if(hours >= 12)
                hours = 0;

            var date = new Date(parseInt(parts[2]),
                                    parseInt(parts[1] - 1),
                                    parseInt(parts[0]),
                                    hours,
                                    parseInt(parts[4]));
        }
        //console.log(date);
        return date;  
    }catch(err){}
    return null;  
}
// Source: http://stackoverflow.com/questions/497790
var dates = {
    convert:function(d) {
        // Converts the date in d to a date-object. The input can be:
        //   a date object: returned without modification
        //  an array      : Interpreted as [year,month,day]. NOTE: month is 0-11.
        //   a number     : Interpreted as number of milliseconds
        //                  since 1 Jan 1970 (a timestamp) 
        //   a string     : Any format supported by the javascript engine, like
        //                  "YYYY/MM/DD", "MM/DD/YYYY", "Jan 31 2009" etc.
        //  an object     : Interpreted as an object with year, month and date
        //                  attributes.  **NOTE** month is 0-11.
        return (
            d.constructor === Date ? d :
            d.constructor === Array ? new Date(d[0],d[1],d[2]) :
            d.constructor === Number ? new Date(d) :
            d.constructor === String ? new Date(d) :
            typeof d === "object" ? new Date(d.year,d.month,d.date) :
            NaN
        );
    },
    compare:function(a,b) {
        // Compare two dates (could be of any type supported by the convert
        // function above) and returns:
        //  -1 : if a < b
        //   0 : if a = b
        //   1 : if a > b
        // NaN : if a or b is an illegal date
        // NOTE: The code inside isFinite does an assignment (=).
        return (
            isFinite(a=this.convert(a).valueOf()) &&
            isFinite(b=this.convert(b).valueOf()) ?
            (a>b)-(a<b) :
            NaN
        );
    },
    inRange:function(d,start,end) {
        // Checks if date in d is between dates in start and end.
        // Returns a boolean or NaN:
        //    true  : if d is between start and end (inclusive)
        //    false : if d is before start or after end
        //    NaN   : if one or more of the dates is illegal.
        // NOTE: The code inside isFinite does an assignment (=).
       return (
            isFinite(d=this.convert(d).valueOf()) &&
            isFinite(start=this.convert(start).valueOf()) &&
            isFinite(end=this.convert(end).valueOf()) ?
            start <= d && d <= end :
            NaN
        );
    }
};

function RefreshButtonsRadio(group, newVal, Clicked){
    var hidden  = $(group).find('input:hidden');
    hidden.val(newVal);
    $(group).find('button').each(function(){
        var button = $(this);
        button.blur();
        button.removeClass('btn-selected btn-default active');
        if(button.val() == hidden.val())
            if(Clicked)
                button.addClass('btn-selected');
            else
                button.addClass('btn-selected active');
        else
            button.addClass('btn-default');
    });
}

$(function($) {
  $('.buttons-radio').each(function() {
    var group = $(this);
    $(group).find('button').each(function(){
      var button = $(this);
      button.on('click', function(){
        RefreshButtonsRadio(group, button.val(), true);
      });
    });
  });
});
