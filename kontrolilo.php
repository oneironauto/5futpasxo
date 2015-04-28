<?php

function kontrolilo()
{
    $uri = $_SERVER['REQUEST_URI'];
    $poz = strpos($uri, "?");
    if($poz)
        $uri = substr($uri, 0, $poz); 

    if($uri[strlen($uri)-1] == "/") 
        $nuna_dosiero = "index.php";
    else {
        $poz = strrpos($uri, "/");
        $nuna_dosiero = substr($uri, $poz+1); 
    }

    if($nuna_dosiero == "sercxrezulto.php")
        return;

    $enhavo = file_get_contents($nuna_dosiero, "r");
    preg_match_all("/<a[^\>]*href=\"([^\>]*)\">/", $enhavo, $trovoj, PREG_SET_ORDER);
    foreach($trovoj as $trovo) {
        $eroj = explode("#", $trovo[1]);

        $indikilo = "";
        $celo = "";
        if(count($eroj) >= 1)
            $indikilo = $eroj[0];
        if(count($eroj) >= 2)
            $celo = $eroj[1];

        if($indikilo == "")
            $indikilo = $nuna_dosiero;

        if(strpos($indikilo, ".php") === false)
            $indikilo .= "/index.php";

        if(!file_exists($indikilo))
            echo "la dosiero ne ekzistas: " . $indikilo . "<br>";
        else if($celo != "" and !cxu_celo($indikilo, $celo))
            echo "la celo ne ekzistas: " . $indikilo . "#" . $celo . "<br>";
    }
}

function cxu_celo($indikilo, $celo)
{
    $enhavo = file_get_contents($indikilo, "r");
    $poz = strpos($enhavo, 'id="' . $celo . '"');
    return $poz;
}

?>
