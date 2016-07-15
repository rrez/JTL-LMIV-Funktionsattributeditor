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
                var myAttribut = attribute[j];
                if(!myAttribut) break;

                // Umlaute umwandeln, und komma durch punkte ersetzen.
                myRow = myRow.replace(/ä/g,"ae").replace(/ö/g,"oe").replace(/ü/g,"ue").replace(/Ä/g,"Ae").replace(/Ö/g,"Oe").replace(/Ü/g,"Ue").replace(/ß/g,"ss").replace(/,/g,".");

                //console.log(this._findValue(myAttribut.Funktionsattributname, myRow))
                //console.log($("[name='" + myAttribut.Funktionsattributname + "']"))
                var value;
                if(myAttribut.searchKeys) {
                    value = this._getSearchKey(myAttribut.searchKeys, myRow);

                } else {
                    value = this._findValue(myAttribut.Funktionsattributname, myRow);
                }


                if(value) {
                    $("[name='" + myAttribut.Funktionsattributname + "']").val(value);
                }
            }
        }
    };

    this._getSearchKey = function(searchKeys, row) {
        var value;
        for(var i = 0, len = searchKeys.length; i < len; i++) {
            value = this._findValue(searchKeys[i], row);
            if(value) break;
        }

        return value;
    };

    this._findValue = function(value, row) {
        //if(value == "vitamin c") {
            //onsole.log(value)
            //console.log(new RegExp("\\b" + value + "\\b","i").test(row))


        if(new RegExp("\\b" + value + "\\b","i").test(row)) {

            // Zahlen aus dem String holen, achtung es wird immer nur die erste Zahl geholt (z.B. 100 g 50% nrv, oder 1333kj 133 kcal)
            if(row) {
                var regex = /[+-]?\d+(\.\d+)?/g,
                    zahlenwert = row.match(regex).map(function(v) { return parseFloat(v); });



                return zahlenwert[0];
            }
        }
    };

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