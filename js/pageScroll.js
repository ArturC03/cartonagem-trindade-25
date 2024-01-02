var dataMinima = $("#mindate").val();
var dataMaxima = $("#maxdate").val();
var horaMinima = $("#mintime").val();
var horaMaxima = $("#maxtime").val();
var ids = $("#sensores").val().replace("[", "").replace("]", "").split(",");
var mesMinPesquisa = -1;
var anoMinPesquisa = -1;
var offset = -1;

function load_data() {
    $('#loader-holder').removeClass("d-none");
    setTimeout(function() {
        $.ajax({
            url: "load_data.php",
            method: 'POST',
            data: { offset: offset == -1 ? $('.table-body table > tbody > tr').length : offset,
                    dataMinima: dataMinima,
                    dataMaxima: dataMaxima,
                    horaMinima: horaMinima,
                    horaMaxima: horaMaxima,
                    ids: ids,
                    mesMinPesquisa: mesMinPesquisa == -1 ? new Date(dataMinima).getMonth() + 1 : mesMinPesquisa,
                    anoMinPesquisa: anoMinPesquisa == -1 ? new Date(dataMinima).getFullYear().toString().slice(2, 4) : anoMinPesquisa
                },
            dataType: 'json',
            error: err => {
                console.log(err)
            },
            success: function(resp) {
                mesMinPesquisa = resp['mesMinPesquisa'];
                anoMinPesquisa = resp['anoMinPesquisa'];
                offset = resp['offset'];
                if (resp.length > 0) {
                    Object.keys(resp['sql']).forEach(k => {
                        const row = resp['sql'][k];
                        const newRow = `
                            <tr>  
                                <td>${row["id_sensor"]}</td>
                                <td>${row["hour"]}</td>
                                <td>${row["date"]}</td>
                                <td>${String(row["temperature"]).replace(/^0+/, '')}</td>
                                <td>${String(row["humidity"]).replace(/^0+/, '')}</td>
                                <td>${String(row["pressure"]).replace(/^0+/, '')}</td>
                                <td>${String(row["eCO2"]).replace(/^0+/, '')}</td>
                                <td>${String(row["eTVOC"]).replace(/^0+/, '')}</td>
                            </tr>
                        `;
                        $('.table-body table > tbody').append(newRow);
                    });
                }
            },
            complete: function() {
                $('#loader').addClass("d-none");
            }
        })
    }, 800)
}
$(function() {
    load_data();
})
$(window).scroll(function() {
    var scrollHeight = $('body').get(0).scrollHeight;
    var _scrolled = $(window).get(0).innerHeight + $(window).get(0).scrollY + 1;

    if (scrollHeight <= _scrolled) {
        if ($('#loader').is(':visible') == false){
            load_data();
        }
    }
});