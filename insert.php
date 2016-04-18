<?php
/**
 * Created by PhpStorm.
 * User: robertrez
 * Date: 28/06/15
 * Time: 19:49
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('mssql.charset', 'UTF-8');
require_once('database.php');

if ($_POST['kArtikel']) {
    // Datensatz als bearbeitet markieren.
    //mssql_query("UPDATE tartikelShop SET cInet='Y' WHERE  kArtikel=".$_POST['kArtikel']." ");
    $datensatz = mssql_fetch_row(mssql_query("SELECT nummer FROM tpk WHERE cName = 'tArtikelAttribute' "));
    $id =  $datensatz[0];
    //$datensatz = mssql_fetch_row($anfrage);
    //mssql_query("INSERT INTO tArtikelAttribute (kArtikel,cName, cValue)  VALUES (5538,test1,'test1wert'),(5538,test2,'test zwei wert') ");

    $myQuery = 'DELETE FROM tArtikelAttribute where kArtikel = '.$_POST['kArtikel'].' ';
    $myQuery.= "UPDATE tartikelShop SET cInet='Y' WHERE  kArtikel=".$_POST['kArtikel']." ";
    $itemSet = false;
    foreach ($_POST as $key => $item) {
        if ($key != 'kArtikel' && $key != 'artikelnummer')
            if ($item != null) {
                $myQuery.= "INSERT INTO tArtikelAttribute ";
                $myQuery.= "([kArtikelAttribute],[kArtikel],[cName],[cValue]) ";
                $myQuery.= "VALUES ('".$id."','".$_POST['kArtikel']."','".$key."','".$item."') ";
                $id++;
                $itemSet = true;
            }
    }
    if($itemSet){
        $myQuery .="UPDATE tpk SET nummer = ".$id." where cName = 'tArtikelAttribute' ";
        mssql_query($myQuery);
        //mysql_query("");
    }
    echo $myQuery;


}
mssql_close($link);
