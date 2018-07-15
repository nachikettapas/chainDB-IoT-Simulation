$('.ui.accordion')
    .accordion();
var id = getParameterByName('id');
$.getJSON("http://localhost:5000/verify/" + id, function(data) {
    console.log(data['reading']);
    // JSON.stringify(jsObj, null, "\t");
    $('#reading').append(JSON.stringify(JSON.parse(data['reading']), null, "\t"));
    readingFormatter(data['reading']);
    $('#message').val(data['message']);
    $('#input_hash').val(data['message']);
    $('#public_key').val(data['public_key']);
    $('#signature').val(data['signature']);
    hljs.initHighlightingOnLoad();

});
console.log($('#input_hash').val())
$.ajax({
    url: "http://localhost:5000/hash",
    type: 'POST',
    dataType: 'text',
    data: $('#input_hash').val(),
    success: function(response) {
        $('#generated_hash').val(response);
    }
});
var step = 1;
topStep1 = $("#top-step-1");
topStep2 = $("#top-step-2");
topStep3 = $("#top-step-3");

function readingFormatter(reading) {
    console.log(reading['altitude']);
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

function syncSteps() {

    if (step == 1) {
        $(".step-2").hide(400);
        $(".step-1").show(400);
        $(".step-3").hide();
        $(".step-4").hide();
        $("#success").hide();
        $("#failure").hide();
    } else if (step == 2) {
        $(".step-1").hide(400);
        $(".step-2").show(400);
        $(".step-3").hide(400);
        topStep2.toggleClass("active");
        if (topStep2.hasClass("disabled")) {
            topStep2.removeClass("disabled");
            // if(!topStep1.hasClass("disabled")) {
            // topStep1.addClass("disabled");
            // }
            if (!topStep3.hasClass("disabled")) {
                topStep3.addClass("disabled");
            }
        }
    } else if (step == 3) {
        $(".step-2").hide(400);
        $(".step-3").show(400);
        $(".step-4").hide(400);
        topStep3.toggleClass("active");
        $("#success").hide();
        $("#failure").hide();
        if (topStep3.hasClass("disabled")) {
            topStep3.removeClass("disabled");
        }
    } else if (step == 4) {
        $(".step-3").hide(400);
        $(".step-4").show(400);

    }
}

syncSteps();
$('#step-1-button').on('click', function() {
    step = 2;
    topStep1.removeClass('active');
    topStep1.addClass('completed');
    syncSteps();
});
$('#step-2-button-b').on('click', function() {
    step = 1;
    topStep2.removeClass('active');
    topStep2.addClass('disabled');
    topStep1.removeClass('completed');
    syncSteps();
});
$('#step-2-button').on('click', function() {
    step = 3;
    topStep2.removeClass('active');
    topStep2.addClass('completed');
    console.log($('#input_hash').val())
    $.ajax({
        url: "http://localhost:5000/hash",
        type: 'POST',
        dataType: 'text',
        data: $('#input_hash').val(),
        success: function(response) {
            $('#generated_hash').val(response);
            console.log(response);
        }
    });
    syncSteps();

});
$('#step-3-button-b').on('click', function() {
    step = 2;
    topStep3.removeClass('active');
    topStep3.addClass('disabled');
    topStep2.removeClass('completed');
    syncSteps();
});
$('#step-3-button').on('click', function() {
    step = 4;
    var dataObject = {
        "message": $('#input_hash').val(),
        "hash": $('#generated_hash').val(),
        "public_key": $('#public_key').val(),
        "signature": $('#signature').val()
    }
    $.ajax({
        url: "http://localhost:5000/verify/signature",
        type: 'POST',
        dataType: 'json',
        data: JSON.stringify(dataObject),
        success: function(data) {
            console.log(data);
            if (data['result'] == true) {
                topStep3.removeClass('active');
                topStep3.addClass('completed');
                $('#success').show();
            } else {
                $("#failure").show();
            }
        }
    });
    // topStep2.removeClass('completed');
    syncSteps();
});
$('#step-4-button-b').on('click', function() {
    step = 3;
    topStep3.addClass('active');
    topStep3.removeClass('completed');
    syncSteps();
});
$('#step-4-button').on('click', function() {
    location.reload();
});