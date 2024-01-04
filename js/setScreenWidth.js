var screenWidth = window.innerWidth;

$.ajax({
    type: "POST",
    url: "setScreenWidth.inc.php",
    data: { screenWidth: screenWidth },
    success: function(response) {
        console.log(response, screenWidth);
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
    }
});