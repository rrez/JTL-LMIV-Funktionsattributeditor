/**
 * Created by r.rez on 13.07.2016.
 */
//var Nutrition = Nutrition || {};
//Nutrition.read

function Nutrition() {
    this.read = function(value) {

        var row = value.split('\n'),
            attribute = this.attribute;

        for(var i = 0, len = row.length; i < len; i++) {
            var myRow = row[i];
            for(var j = 0, jlen = attribute.length; i < jlen; j++) {
                var myAttribut = attribute[j]
                if(!myAttribut) break;

                // Umlaute umwandeln, und komma durch punkte ersetzen.
                myRow = myRow.replace(/�/g,"ae").replace(/�/g,"oe").replace(/�/g,"ue").replace(/�/g,"Ae").replace(/�/g,"Oe").replace(/�/g,"Ue").replace(/�/g,"ss").replace(/,/g,".");
                if(new RegExp("\\b" + myAttribut.Funktionsattributname + "\\b","i").test(myRow)) {

                    // Zahlen aus dem String holen, achtung es wird immer nur die erste Zahl geholt (z.B. 100 g 50% nrv, oder 1333kj 133 kcal)
                    if(myRow) {
                        var regex = /[+-]?\d+(\.\d+)?/g,
                            zahlenwert = myRow.match(regex).map(function(v) { return parseFloat(v); });

                        console.log(myAttribut.Funktionsattributname + ': ' + zahlenwert[0]);
                        //console.log(myAttribut.Funktionsattributname + ': ' + myRow)
                        $("[name='"+myAttribut.Funktionsattributname+"']").val(zahlenwert[0])
                    }

                }
            }
        }
    };

    this.attribute;

    this.init = function() {
        $.ajax({
            url: 'attribute.json',
            dataType: 'json',
            success: function(data) {
                nutrition.setAttribute(data);
            }
        });
    };

    this.setAttribute = function(data) {
        this.attribute = data;
    };

    this.init();
}

nutrition = new Nutrition();