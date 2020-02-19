<?php

include("Browser.php");
include("Language.php");
include("db.php");

$fingerprint_raw = "";

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
    $fingerprint_raw .= 'Internet explorer';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
    $fingerprint_raw .= 'Internet explorer';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
    $fingerprint_raw .= 'Mozilla Firefox';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
    $fingerprint_raw .= 'Google Chrome';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
    $fingerprint_raw .= "Opera Mini";
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
    $fingerprint_raw .= "Opera";
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
    $fingerprint_raw .= "Safari";
else
    $fingerprint_raw .= 'Something else';

/* Nom, version, OS et userAgent */
$browserInfo = Browser::detect();
foreach ($browserInfo as $key => $value) {
    $fingerprint_raw .= "{$key} => {$value}";
}

/* Langages acceptés */
$languages = Language::get_accepted_languages();
foreach ($languages as $key => $value) {
    $fingerprint_raw .= "{$key} => {$value}";
}

/* Page précédemment visitée */
if(isset($_SERVER['HTTP_REFERER'])) {
    $pagePrécédente = $_SERVER['HTTP_REFERER'];
    echo "<b>Page précédemment visitée : </b>$pagePrécédente";
    $fingerprint_raw .= $pagePrécédente;
}
else
{
   // echo 'HTTP_REFERER pas envoyé par le navigateur !';
}

$fingerprint_hash = md5($fingerprint_raw, false);
$sql = "SELECT * FROM fingerprint WHERE fingerprint_hash = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$fingerprint_hash]);
$hash = $stmt->fetch();

if($hash == null) {
    $sql = "INSERT INTO fingerprint (fingerprint_raw, fingerprint_hash, first_visit) VALUES (:fingerprint_raw, :fingerprint_hash, CURRENT_TIMESTAMP)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':fingerprint_raw', $fingerprint_raw);
    $stmt->bindParam(':fingerprint_hash', $fingerprint_hash);
    $stmt->execute();
}
else {
    $sql = "SELECT first_visit FROM fingerprint WHERE fingerprint_raw = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$fingerprint_raw]);
    $raws = $stmt->fetch();

    if ($raws == null) {
        $sql = "INSERT INTO fingerprint (fingerprint_raw, fingerprint_hash, first_visit) VALUES (:fingerprint_raw, :fingerprint_hash, CURRENT_TIMESTAMP)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':fingerprint_raw', $fingerprint_raw);
        $stmt->bindParam(':fingerprint_hash', $fingerprint_hash);
        $stmt->execute();
    }
    else {
        $derniereVisite = array_values($raws)[0];
        echo("<br><br>Vous êtes déjà venu sur ce site le : $derniereVisite ");
    }
}

echo '<img src="canard.jpg" alt="coin">';