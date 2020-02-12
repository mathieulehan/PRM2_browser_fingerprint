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