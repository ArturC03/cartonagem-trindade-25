var screenWidth = window.innerWidth;

$.ajax({
    type: "POST",
    url: "tools/setScreenWidth.php",
    data: { screenWidth: screenWidth },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
    }
});