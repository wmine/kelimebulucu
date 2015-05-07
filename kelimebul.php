<!DOCTYPE html>
<html lang="tr-TR">
<head>
    <title>Kelime Bulucu</title>
    <meta charset="UTF-8">
<style type="text/css">
    *{font-family: "Helvetica Neue", Helvetica, Arial, Verdana, sans-serif; font-size: 1em; color: #333; margin: 0; padding: 0; outline: 0}
    body{background-color: #FEFFFF}
    form{width: 300px; margin: 0 auto 20px auto; padding: 20px 0}
    #formbg{background: #B28888;width: 100%; height: auto}
    .bKelimeler{margin: 0 auto; height: auto; display: table; max-width: 1200px}
    .bKelimeler div{width: 250px; float: left; height: 220px; overflow: auto; margin: 0 25px 20px 25px}
    input[type=text]{margin: 10px 0; border: 1px solid #e9e9e9; height: 35px; width: 300px; text-indent: 10px;
        border-radius: 4px;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;}
    input[type=submit]{cursor: pointer; background-color:#333; color: #fff ;border: none; height: 35px; width: 300px;
        border-radius: 4px;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;}
    label{color: #fff; margin:0 15px 0 3px}
    p{margin-bottom: 5px}
    .bKelimeler div p:first-child{font-size: 1.1em}
</style>
</head>
<body>
<div id="formbg">
<form action="#" method="post" name="form1">
    <input type="radio" name="joker" value="0" checked><label for="0">Jokersiz</label>
    <input type="radio" name="joker" value="1"><label for="1">Tek Joker</label>
    <input type="radio" name="joker" value="2"><label for="2">Çift Joker</label>
<input type="text" name="harfler" required placeholder="Harfleri Giriniz" maxlength="15"/>
<input type="submit" value="Kelime Bul"/>
</form>
</div>
<?php
//sozluk.txtdeki kelimelerin diziye atılması
$dosya=fopen("sozluk.txt","r");
$sozluk=array();
While(!feof($dosya)){

    $sozluk[]=trim(fgets($dosya));
}
fclose($dosya);
array_shift($sozluk);

//kelimenin harflere ayrılması
function kelimeAyir($kelime){
    return preg_split('//u', $kelime, -1, PREG_SPLIT_NO_EMPTY);
}
function kelimeBul($sozluk,$harfler,$jsay){
    $bulunan=array();
    foreach ($sozluk as $deger) {

        $verilen=$harfler;
        $ayir = kelimeAyir($deger);

        if(count($ayir)>2) {
            $say=0;

            //verilen harflerin ve kelimenin karşılaştırılması
            foreach ($ayir as $key => $value) {
                if (!in_array($value, $verilen)) {
                    $say += 1;

                    unset($ayir[$key]);

                } else {
                    unset($verilen[array_search($value, $verilen)]);
                }
            }
            if ( $say == $jsay ) {

                //bulunan kelimenin diziye atılması
                $bulunan[count(kelimeAyir($deger))][] = $deger;

                sort($bulunan[count(kelimeAyir($deger))]);

            }
        }
    }
    return $bulunan;
}
if($_POST)
{
    $harfler = kelimeAyir(mb_strtolower((trim($_POST['harfler'],'utf8'))));
    $joker= $_POST['joker'];

    $bulunan= (kelimeBul($sozluk,$harfler,$joker));
    krsort($bulunan);


echo "<div class='bKelimeler'>";
  foreach($bulunan as $indis => $ilkdizi){
      echo "<div><p>$indis harfli kelimeler:</p>";
      foreach($ilkdizi as $kelime){
                echo "<p>".$kelime."</p>";
      }
      echo "</div>";
  }
echo "</div>";
}
?>
</body></html>