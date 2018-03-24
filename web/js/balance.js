$("document").ready(function () {

    helpBlockReplac();

    $('#js_parse').on('click', '.js_parse', function () {
        $.ajax({
            url: '?r=plotter/parse',
            type: 'POST',
            dataType: 'text',
            success: function (res) {
                var result = JSON.parse(res);
                // var error =  $('#error');
                if ((typeof result) === 'boolean') {
                    if (result == false) {
                        $('#error').text('Содержание файла не соответствует формату,' +
                            ' необходимому для построения графика');
                    }
                }
                else {

                    //--------------plotter------------------------------

                    var profit = result['profit'];
                    var backgroundColor = [];
                    for (var i = 0; i < profit.length; i++) {
                        backgroundColor[i] = 'rgba(23, 173, 26, 0.69)';
                    }
                    var ctx = document.getElementById("js_plotter").getContext('2d');
                    var plotter = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: result['time'],
                            datasets: [{
                                label: 'Возрастающий баланс',
                                data: result['profit'],
                                backgroundColor: backgroundColor,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                    //----------------------------------------------------
                }
            },
            error: function () {
                alert('Сбой передачи данных');
            }
        });
        return false;
    });

//--------------------------------------------------------------------------
    function helpBlockReplac() {
        var helpBlock = $('div.help-block').text();
        if (helpBlock === 'Разрешена загрузка файлов только со следующими расширениями: html.') {
            $('div.help-block').text('Файл не соответствует формату html ')
        }
    }
});


