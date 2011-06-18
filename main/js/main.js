var g_url= "", g_jqxhr= null;
var init= function() {
    $("#swfurl_textfield").focus();
    
    $("#main_form").submit( function(event) {
        event.preventDefault();
        var url= $.trim($("#swfurl_textfield").val());
        if (url.length === 0) {
            showErrorMessage("Please input an swf url");
        }
        else { //client-side checks are done by now
            hideErrorMessage();

            g_url= url;
            fetchSwf(url, function(data) { 
                getScreenShot(url, function(data) {
                    $("#screenshot").attr("src", data);
                    showScreenShot();
                });
            });
        }
        return false;
    });

    $("#swfurl_textfield").keydown( function(event) {
        //User started modifying url, so hide old url error message
        hideErrorMessage();
    });
};

$(document).ready(init);

//helptext - 
//Enter swf url and click generate to display screenshot of the file.
function fetchSwf(url, successHandler){
    showLoader();
    hideScreenShot();
    var jqxhr= $.get(   'api.php',  
                        {url: url, action: "start"},  
                        function(data){
                            g_jqxhr= null;
                            hideLoader();
                            successHandler(data);
                        } 
                );
    g_jqxhr= jqxhr;
    jqxhr.error( function () {
        g_jqxhr= null;
        hideLoader();
        showErrorMessage("Error fetching swf. Please verify url.");
    });
}

function getScreenShot(url, successHandler){
    showLoader();
    var jqxhr= $.get(   'api.php',
                        {url: url, action: "captureframe"},  
                        function(data){
                            g_jqxhr= null;
                            hideLoader();
                            successHandler(data);
                        } 
                );
    g_jqxhr= jqxhr;
    jqxhr.error( function () {
        g_jqxhr= null;
        hideLoader();
        showErrorMessage("Error getting screenShot. Please try another url.");
    });
}

function abortAjaxRequest(){
    if (g_jqxhr){
        g_jqxhr.abort();
        g_jqxhr= null;
    }
}

function showErrorMessage(message){
    $("#message").text(message).fadeIn();
}

function hideErrorMessage(){
    $("#message").text("").fadeOut();
}

function showLoader(){
    $("#loader").show();
}

function hideLoader(){
    $("#loader").hide();
}

function showScreenShot(){
    $("#screenshot").show();
}

function hideScreenShot(){
    $("#screenshot").hide();
}
