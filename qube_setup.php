<?php

class Log {

    public const LOG_PREFIX = "";

    public function log($log, $type = "normal", $aswer = false) {
        if ($aswer) {
            if ($type == "normal") {
                echo date("D")." - ".date("H:m:s")." > ".$log;
                return;
            }
            echo date("D")." - ".date("H:m:s")." > [".$type."] ".$log;
        } else {
            if ($type == "normal") {
                echo date("D")." - ".date("H:m:s")." > ".$log . PHP_EOL;
                return;
            }
            echo date("D")." - ".date("H:m:s")." > [".$type."] ".$log . PHP_EOL;
        }
    }

}

class Language {

    public $log;

    public function __construct() {
        $this->log = new Log();
    }

    public function out($lang) {
        if (isset(json_decode(file_get_contents('lang.json'))-> {
            $lang
        })) {
            $key = json_decode(file_get_contents('lang.json'))-> {
                $lang
            };
            return $key;
        }
        $this->log->log("Undefined lang key '".$lang."' on line " . __LINE__);
        $this->log->log($this->out("closing_file"));
        exit();
    }
}

/* Main function of qube */
function intro_qube() {
    system("clear");
    $log = new Log();
    $lang = new Language();
    $logo_base64_format = json_decode(file_get_contents('qube_var.json'))-> {
        "logo"
    };
    echo base64_decode($logo_base64_format);
    delay(0.25);
    if (check4Lang()) {
        $log->log($lang->out("lang_found"));
    }
    delay(1);
    playTheAD();
    delay(5);
    $log->log($lang->out("start_qube_file"));
    delay(0.50);
    $log->log($lang->out("how_long_start_qube_file"));
    delay(10);
    require_once("qube_downloader.php");
}

function check4Lang() {
    if (!file_exists('lang.json')) {
        $log = new Log();
        $log->log("No lang file was found");
        $log->log("Closing this file");
        exit();
    }
    return true;
}

function delay(float $sec) {
    usleep($sec*pow(10, 6));
}

function playTheAD() {
    $log = new Log();
    $lang = new Language();
    $log->log($lang->out("github_link"));
}

intro_qube(); /* Executing the 'Main' function */