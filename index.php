<?php

include("Browser.php");
include("Language.php");

echo('<b>fonction native get_browser :</b><br><br>');
print_r(get_browser());

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
    echo 'Internet explorer';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
    echo 'Internet explorer';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
    echo 'Mozilla Firefox';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
    echo '<br><br>Google Chrome';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
    echo "Opera Mini";
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
    echo "Opera";
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
    echo "Safari";
else
    echo 'Something else';

/* Nom, version, OS et userAgent */
echo '<br><br><b>Nom, version, OS et userAgent du navigateur</b><br><br>';
$browserInfo = Browser::detect();
foreach ($browserInfo as $key => $value) {
    echo "{$key} => {$value}<br><br>";
}

/* Langages acceptés */
echo '<b>Langages acceptés avec versions</b><br><br>';
$languages = Language::get_accepted_languages();
foreach ($languages as $key => $value) {
    echo "{$key} => {$value}<br><br>";
}

/* Page précédemment visitée */
if(isset($_SERVER['HTTP_REFERER'])) {
    $pagePrécédente = $_SERVER['HTTP_REFERER'];
    echo "<b>Page précédemment visitée : </b>$pagePrécédente";
}
else
{
    echo 'HTTP_REFERER pas envoyé par le navigateur !';
}

/* Résolution d'écran */
echo '<br><br><b>Résolution de l\'écran : </b>';
session_start();
if (isset($_SESSION['screen_width']) AND isset($_SESSION['screen_height'])) {
    echo $_SESSION['screen_width'] . 'x' . $_SESSION['screen_height'];
} else if (isset($_REQUEST['width']) AND isset($_REQUEST['height'])) {
    $_SESSION['screen_width'] = $_REQUEST['width'];
    $_SESSION['screen_height'] = $_REQUEST['height'];
    header('Location: ' . $_SERVER['PHP_SELF']);
} else {
    echo '<script type="text/javascript">window.location = "' . $_SERVER['PHP_SELF'] . '?width="+screen.width+"&height="+screen.height;</script>';
}
