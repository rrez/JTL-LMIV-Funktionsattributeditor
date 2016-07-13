$(document).ready(function () {
    $('#artikelsuchen').click(function () {
        var searchKeyword = $('#keyword').val();
        $('ul#result').empty();
        $('ul#result').append('Laden...');
        if (searchKeyword.length >= 3) {
            $.post('ajax_provider.php', {cName: searchKeyword}, function (data) {
                $('ul#result').empty();
                //if()
                if(data.length == 0) {
                    $('ul#result').append('<li>Keine Datensätze gefunden</li>');
                    return
                }
                $.each(data, function () {
                    var title = this.cName;
                    if (!title) return;
                    var rgxp = new RegExp(searchKeyword, 'gi');
                    var repl = '<span class="highlight">' + searchKeyword + '</span>';
                    title = title.replace(rgxp, repl);
                    $('ul#result').append('<li><a onclick="insertValues(\'' + encodeURIComponent(JSON.stringify(this)) + '\');" return false">' + title + ' <small style="color: #ccc;">(' + this.cArtNr + ')</small></a></li>');
                });
            }, "json");
        }
    });
    $('#kaptogramm').on('click', function () {
        kapselZuHundertGramm();
    });
    $('#zueinzel').on('click', function () {
        zueinzel();
    });
    $('#portionzuhundert').on('click', function () {
        portionZuHundertGramm();
    });


    $('#resetkeyword').on('click', function () {
        $('ul#result').empty();
    });
    $('#resetvalues').on('click', function () {
        $('input[type=text]').css('background-color', '');
    });
    $('#checkAllBoxes').on('click', function () {
        checkAllBoxes();
    });


    $('#jsonfy').on('click', function () {
        $('#jsonresult').text(JSON.stringify($('#formular').serializeObject(),null, "\t"));
    });

    $('#readNutrition').on('click', function () {
        nutrition.read($('#jsonresult').val());
    });

    $('#submitbtn').on('click', function () {

        $.ajax({
            type: "POST",
            url: 'insert.php',
            data: $( "#formular" ).serialize(),
            //success: success,
            //dataType: dataType

        });
        return false;
    });
    $('[name=artikelnummer]').keyup('input propertychange paste change', function () {
        $('h1#produktname').text('Produkt');
        var cArtNr = $(this).val();
        if (cArtNr.length >= 6) {
            setTitle(cArtNr);
        }
    });


});

$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {

        if (o[this.name] !== undefined) {

            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            if(this.value) {
                o[this.name] = this.value || '';
            }

        }
    });
    return o;
};

function setTitle(cArtNr) {
    $.post('ajax_provider.php', {cArtNr: cArtNr}, function (data) {
        $('h1#produktname').text(data);
        $('[name=cName]').val(data);
    }, "json");
}

/**
 * Funktion um Kapselwert in 100g Wert zu wandeln.
 * @returns {number}
 */
function kapselZuHundertGramm() {
    $.each($('.inputfield'), function (index, value) {
        var rowitems = $(value),
            checkbox = rowitems.children('input:checkbox')[0];

        if (checkbox && checkbox.checked) {
            $(checkbox).attr('checked', false);
            var inputfield = $(rowitems.children('input:text')),
                inputVal = inputfield.val();
            inputfield.val(errechneKaps_gramm(inputVal));
        }
    });
}

/**
 * mehrfachkapseln z.B. 6 pro portion in einzelkapsel umrechnen.
 */
function zueinzel() {
    $.each($('.inputfield'), function (index, value) {
        var rowitems = $(value),
            checkbox = rowitems.children('input:checkbox')[0];

        if (checkbox && checkbox.checked) {

            var inputfield = $(rowitems.children('input:text')),
                inputVal = inputfield.val();

            inputVal = inputVal / $('[name=portion]').val()

            inputfield.val(inputVal);
        }
    });
}

/**
 * helper fuer kapselZuHunderGramm
 * @param kapselGewicht
 * @returns {number}
 */
function errechneKaps_gramm(kapselGewicht) {
    var anzahlKapseln = $('[name=anzahl_kapseln]').val(),
        gesamtgewicht = $('[name=inhalt]').val();

    if(anzahlKapseln == '' && gesamtgewicht == '') {
        var msg = 'Anzahl Kapseln und oder Gesamtgewicht angeben';

        window.alert(msg);
        throw msg;
    }

    var ret = ((kapselGewicht * anzahlKapseln) / gesamtgewicht) * 100;
    return ret;
}

/**
 * Alle checkboxen aktivieren.
 * @returns {number}
 */
function checkAllBoxes() {
    $.each($('.inputfield'), function (index, value) {
        var rowitems = $(value),
            checkbox = rowitems.children('input:checkbox')[0];
        if (checkbox) {
            $(checkbox).attr('checked', true);
        }
    });
}

/**
 * Funktion um Kapselwert in 100g Wert zu wandeln.
 * @returns {number}
 */
function portionZuHundertGramm() {
    $.each($('.inputfield'), function (index, value) {
        var rowitems = $(value),
            checkbox = rowitems.children('input:checkbox')[0],
            errechnet,
            portion = $('[name=portion]').val();

        if (checkbox && checkbox.checked) {
            $(checkbox).attr('checked', false);
            var inputfield = $(rowitems.children('input:text')),
                inputVal = inputfield.val();



            errechnet = inputVal / portion * 100

            inputfield.val(errechnet);
        }
    });
}

function insertValues(item) {

    //$('#formular').trigger("reset");
    item = JSON.parse(decodeURIComponent(item));
    $('[name=artikelnummer]').val(item.cArtNr);
    $('[name=kArtikel]').val(item.kArtikel);
    $('input[type=text]').css('background-color', '');
    setTitle(item.cArtNr);
    for (var i = 0, len = item.attribute.length; i < len; i++) {
        var attr = item.attribute[i];
        $('[name=' + attr[0] + ']').val(attr[1]);
        $('[name=' + attr[0] + ']').css('background-color', '#ffccff');
    }
}

function pruefeKomma(event) {
    var inputVal = event.srcElement.value;
    inputVal = inputVal.replace(',', '.');
    if (isNaN(inputVal)) {
        event.target.style.backgroundColor = "yellow";
    } else {
        event.target.style.backgroundColor = "";
    }
    event.srcElement.value = inputVal;
}