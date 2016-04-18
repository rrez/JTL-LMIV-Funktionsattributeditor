<html>
<head>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="lib.js"></script>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<form id="formular">
    <div id="header">
        <h1 id="produktname">Produkt</h1>
        <button type="button" id="portionzuhundert">Portion zu 100g</button><button type="button" id="kaptogramm">Kapsel zu 100g</button><button type="button" id="zueinzel">Kapseln zu Einzel</button><button type="button" id="jsonfy">JSON</button>   <input id="submitbtn" type="submit" /><input type="reset" id="resetvalues" /> <button type="button" id="checkAllBoxes">Alles markieren</button>
    </div>
    <div id="content"><!-- content open-->
        <?php

        /*$data:
        0 : a = Funktionsattributname
        1 : b = label
        2 : c = Funktionsattributwert
        3 : d = unit
        4 : e = pflichtfeld
        5 : f = nrv
        6 : g = category
        7 : h = Beschreibung (Info)
        8 : i = nichteingepflegt
        9 : j = calc
        10 : k = textfield
        */

        $row = 1;
        $pflichtfeld = '<span style="background-color:#f00; padding: 0 3px;"><strong style="color: #fff;">!</strong></span>';

        if (($handle = fopen("attribute.csv", "r")) !== FALSE) {
            echo '';
            echo '<input type="hidden" name="kArtikel" />';
            echo '<textarea id="jsonresult" style="width: 100%; height: 100px;"></textarea>';
            echo '<table style="float:left;">';
            echo '<tr style="background-color: #fcc;">';
            echo '<td></td>';
            echo '<td><strong>Artikelnummer</strong></td>';
            echo '<td><input type="text" name="artikelnummer" required="required">' . $pflichtfeld . '</td>';
            echo '<td colspan="3" style="text-align:right;"></td>';
            echo '</tr>';
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row % 2 == 0){
                    echo "<tr style='background: #eee;'>";
                } else {
                    echo "<tr class='style2'>";
                }
                if($row == 1) {
                    echo '<input type="hidden"  name="' . $data[0]. '" value="' . $data[2]. '">';
                    echo '<th></th>';
                    echo '<th>' . $data[1] . '</th>';
                    echo '<th>' . $data[2] . '</th>';
                    echo '<th>' . $data[3] . '</th>';
                    echo '<th>' . $data[0] . '</th>';
                    echo '<th></th>';
                } else {
                    echo '<td class="'. $data[6] .'">' . $row . '</td>';
                    echo '<td>' . $data[1] . '</td>';
                    if($data[10]) {
                        echo '<td class="inputfield"><textarea maxlength="4000" rows="4" name="' . $data[0]. '">' . $data[2] . '</textarea></td>';

                    } else {
                        echo '<td class="inputfield"><input type="text" name="' . $data[0]. '"' . ($data[4]  ? ' required="required"' : ''). ($data[3]  ? ' onchange="pruefeKomma(event)"' : '').'>' .($data[9]  ? ' <input type="checkbox">' : '') . ($data[4]  ? $pflichtfeld : '').'</td>';

                    }
                    echo '<td>' . $data[3] . ' ' . ($data[5]  ? ' <small style="color: #ccc;">(nrv:'.$data[5].')</small>' : '').' </td>';
                    echo '<td>' . $data[0] . '</td>';
                    echo '<td>';
                    if($data[7]){
                        echo '<div class="wrapper"><strong>i</strong><div class="tooltip">' . $data[7] . '</div></div>';
                    }
                    echo '</td>';

                }
                echo '</tr>';
                $row++;
            }
            echo '</table>';
            echo '</form>';
            fclose($handle);
        }
        ?>
        <div id="searchbox">
            <form role="form" method="post">
                <input type="text" class="form-control" id="keyword" placeholder="Artikel suchen"><button id="artikelsuchen" onclick="return false;">Suchen</button><input type="reset" id="resetkeyword" />
            </form>
            <ul id="result">
            </ul>
        </div>
        <div>
            <p>Inhalt immer pro 100g!</p>
            <p><span style="background-color:#ffccff; width: 15px;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Daten aus der Suche aktuallisiert. Wenn in der rechten Spalte ein Arikel gesucht wird und übernommen, so werden die übernommen Daten in der Farbe angezeigt.<br />
                <span style="background-color:yellow; width: 15px;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Hier dürfen nur Zahlen eingegeben werden. Die Eingabefelder erhalten die Farbe sobald man statt Zahlen Buchstaben eingegeben werden.<br />
                <span style="width: 15px;" class="amino">&nbsp;&nbsp;&nbsp;&nbsp;</span> Aminosäuren <br />
                <span style="width: 15px;" class="mineralvitamin">&nbsp;&nbsp;&nbsp;&nbsp;</span> Mineralien und Vitamine <br />
                <span style="width: 15px;" class="naehrwerte ">&nbsp;&nbsp;&nbsp;&nbsp;</span> Nährwertangaben<br />

                <?php echo $pflichtfeld; ?> Muss ausgefüllt werden</p>
        </div>
        <br style="clear:both;" />
    </div><!-- content close-->

    <!--<div id="footer">
        <button type="button" id="kaptogramm">Kapsel zu 100g</button>   <input type="submit" /><input style="float:right;" type="reset" id="resetvalues" />
    </div>-->


</body>
</html>
