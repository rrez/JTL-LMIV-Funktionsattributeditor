<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('mssql.charset', 'UTF-8');
require_once('database.php');

$arr = array();
if (!empty($_POST['cName'])) {
    $cName = $_POST['cName'];
    //$cName = 'magnesium';
    $sql = "SELECT a.cName, a.cArtNr, a.kArtikel, at.cName AS Funktionsattributname, at.cValue AS Funktionsattributwert ";
    $sql .= "FROM tartikel a ";
    $sql .= "LEFT JOIN tArtikelAttribute at ON (a.kArtikel = at.kArtikel) ";
    $sql .= "WHERE a.cName LIKE '%" . $cName . "%' ";
    //$sql .= "AND cAktiv ='Y' ";

    $sql .= "ORDER by a.cName ASC ";
    $result = mssql_query($sql);
    if (!mssql_num_rows($result)) {
        //throw new Exception('Division durch Null.');
        //echo 'Keine Datensätze gefunden';
    } else {
        for ($i = 0; $i < mssql_num_rows($result); ++$i) {
            $arr[] = array(
                'cName' => mssql_result($result, $i, 'cName'),
                'cArtNr' => mssql_result($result, $i, 'cArtNr'),
                'kArtikel' => mssql_result($result, $i, 'kArtikel'),
                'Funktionsattributname' => mssql_result($result, $i, 'Funktionsattributname'),
                'Funktionsattributwert' => mssql_result($result, $i, 'Funktionsattributwert')
            );
        }
    }
}


if (!empty($_POST['cArtNr'])) {
    $cArtNr = $_POST['cArtNr'];
    $sql = "SELECT cName, cArtNr ";
    $sql .= "FROM tartikel ";
    $sql .= "WHERE cArtNr = '" . $cArtNr . "' ";
    $result = mssql_query($sql);
			//echo json_encode($sql);
    //var_dump(mssql_num_rows($result));
    echo json_encode(mssql_result($result, 0, 'cName'));
    if (!mssql_num_rows($result)) {
        for ($i = 0; $i < mssql_num_rows($result); ++$i) {
            echo mssql_result($result, 0, 'cName');
        }
    }

    return;
    $result = $db->query($sql) or die($mysqli->error);

    if ($result->num_rows > 0) {
        while ($obj = $result->fetch_object()) {
            echo json_encode($obj->cName);

        }
    }
    return;
}


//var_dump($arr);

//echo json_encode($arr);
//return;
$newarr = array();

foreach ($arr as $key => $item) {

    if (!isset($newarr[$item['cArtNr']])) {
        $newarr[$item['cArtNr']] = array('cName' => $item['cName'], 'cArtNr' => $item['cArtNr'], 'kArtikel' => $item['kArtikel']);
        $newarr[$item['cArtNr']]['attribute'] = array();
    }
    $newarr[$item['cArtNr']]['attribute'][] = array($item['Funktionsattributname'], $item['Funktionsattributwert']);


}

//ksort($newarr, SORT_NUMERIC);
//ksort($newarr, SORT_NUMERIC);
//var_dump($newarr);
//var_dump($newarr);
$json_string = json_encode($newarr);
if ($json_string) {
    echo $json_string;
} else {
    echo "Error";
    echo "<pre>";
    print_r($newarr);
    echo "</pre>";
}
mssql_close($link);