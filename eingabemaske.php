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


$string = file_get_contents("attribute.json");
$json = json_decode(utf8_encode($string));
//var_dump($json[0])


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
            //foreach($user->data as $mydata)
            //while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            foreach($json as $data) {


                if ($row % 2 == 0){
                    echo "<tr style='background: #eee;'>";
                } else {
                    echo "<tr class='style2'>";
                }
                if($row == 1) {
                    echo '<input type="hidden"  name="' . $data->Funktionsattributname. '" value="' . $data->Funktionsattributwert. '">';
                    echo '<th></th>';
                    echo '<th>' . $data->label . '</th>';
                    echo '<th>' . $data->Funktionsattributwert . '</th>';
                    echo '<th>' . $data->unit . '</th>';
                    echo '<th>' . $data->Funktionsattributname . '</th>';
                    echo '<th></th>';
                } else {
                    echo '<td class="'. $data->category .'">' . $row . '</td>';
                    echo '<td>' . $data->label . '</td>';
                    if($data->textfield) {
                        echo '<td class="inputfield"><textarea maxlength="4000" rows="4" name="' . $data->Funktionsattributname. '">' . $data->Funktionsattributwert . '</textarea></td>';

                    } else {
                        echo '<td class="inputfield"><input type="text" name="' . $data->Funktionsattributname. '"' . ($data->pflichtfeld  ? ' required="required"' : ''). ($data->unit  ? ' onchange="pruefeKomma(event)"' : '').'>' .($data->calc  ? ' <input type="checkbox">' : '') . ($data->pflichtfeld  ? $pflichtfeld : '').'</td>';

                    }
                    echo '<td>' . $data->unit . ' ' . ($data->nrv  ? ' <small style="color: #ccc;">(nrv:'.$data->nrv.')</small>' : '').' </td>';
                    echo '<td>' . $data->Funktionsattributname . '</td>';
                    echo '<td>';
                    if($data->Beschreibung){
                        echo '<div class="wrapper"><strong>i</strong><div class="tooltip">' . $data->Beschreibung . '</div></div>';
                    }
                    echo '</td>';

                }
                echo '</tr>';
                $row++;
            }
            echo '</table>';
            echo '</form>';

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
