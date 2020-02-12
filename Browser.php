<?php

class Browser {
    /**
    Trouve le nom du navigateur, sa version et la plateforme
    sur laquelle il est utilisé.
     */
    public static function detect() {
        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

        // Identify the browser. Check Opera and Safari first in case of spoof. Let Google Chrome be identified as Safari.
        if (preg_match('/opera/', $userAgent)) {
            $nom = 'opera';
        }
        elseif (preg_match('/webkit/', $userAgent)) {
            $nom = 'safari';
        }
        elseif (preg_match('/msie/', $userAgent)) {
            $nom = 'msie';
        }
        elseif (preg_match('/mozilla/', $userAgent) && !preg_match('/compatible/', $userAgent)) {
            $nom = 'mozilla';
        }
        else {
            $nom = 'non reconnu';
        }

        // Quelle version?
        if (preg_match('/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/', $userAgent, $matches)) {
            $version = $matches[1];
        }
        else {
            $version = 'inconnu';
        }

        // Running on what platform?
        if (preg_match('/linux/', $userAgent)) {
            $plateforme = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/', $userAgent)) {
            $plateforme = 'mac';
        }
        elseif (preg_match('/windows|win32/', $userAgent)) {
            $plateforme = 'windows';
        }
        else {
            $plateforme = 'non reconnu';
        }

        return array(
            'nom'      => $nom,
            'version'   => $version,
            'platform'  => $plateforme,
            'userAgent' => $userAgent
        );
    }
}


$browser = Browser::detect();