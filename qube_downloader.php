<?php

abstract class Downloader {
    public const LATEST_PHP_BINARY = "https://github.com/DaisukeDaisuke/AndroidPHP/releases/latest/download/php"; //Special thanks to @DaisukeDaisuke
    abstract public function process():void;
    public function deleteRecursive($foldername) {
        if (is_dir($foldername)) {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($foldername)) as $filename) {
                if ($filename->isDir()) continue;
                unlink($filename);
            }
            rmdir($foldername);
        }
    }

}

class PocketMineMP extends Downloader {

    public const POCKETMINE_GITHUB = "https://github.com/pmmp/PocketMine-MP/";

    public const LATEST_RELEAS_PHAR = "https://github.com/pmmp/PocketMine-MP/releases/latest/download/PocketMine-MP.phar";

    public function process() : void {
        shell_exec("git clone " . self::POCKETMINE_GITHUB);
        chdir("PocketMine-MP");
        shell_exec("chmod +x start.sh");
        // PHAR
        shell_exec("wget " . self::LATEST_RELEAS_PHAR);
        // PHP BINARY
        shell_exec("mkdir -p bin/php7/bin");
        chdir("bin/php7/bin");
        shell_exec("wget ".self::LATEST_PHP_BINARY);
        shell_exec("chmod +x php");
        chdir("../../../../");
        shell_exec("mv PocketMine-MP ../");
        $foldername = substr(__DIR__, strrpos(__DIR__, '/') + 1);
        chdir("../");
        $this->deleteRecursive($foldername);
    }
}

class Altay extends Downloader {
    public const ALTAY_GITHUB = "https://github.com/Benedikt05/BetterAltay";

    public const LATEST_RELEAS_PHAR = "https://github.com/Benedikt05/BetterAltay/releases/latest/download/BetterAltay.phar";
    
    public function process() : void {
        shell_exec("git clone " . self::ALTAY_GITHUB);
        chdir("BetterAltay");
        shell_exec("chmod +x start.sh");
        // PHAR
        shell_exec("wget " . self::LATEST_RELEAS_PHAR);
        // PHP BINARY
        shell_exec("mkdir -p bin/php7/bin");
        chdir("bin/php7/bin");
        shell_exec("wget ".self::LATEST_PHP_BINARY);
        shell_exec("chmod +x php");
        chdir("../../../../");
        shell_exec("mv BetterAltay ../");
        $foldername = substr(__DIR__, strrpos(__DIR__, '/') + 1);
        chdir("../");
        $this->deleteRecursive($foldername);
    }
    
}

function which_qube() {
    $log = new Log();
    $lang = new Language();
    if (stristr(PHP_OS, "LINUX")) {
        $log->log($lang->out("if_using_termux_linux"), "NOTICE");
    }
    $log->log($lang->out("question1_which_software"));
    $ss = readline($log->log($lang->out("answer1_question1"), "normal", true));
    if (!((1 <= $ss) && ($ss <= 2))) {
        $log->log($lang->out("unkown_server_software"), "FAILURE");
        delay(1);
        $log->log($lang->out("closing_file"));
        exit();
        return;
    }
    delay(0.50);
    switch ($ss) {
        case 1:
            $log->log($lang->out("selected_pocketminemp"));
            $pmmp = new PocketMineMP();
            $pmmp->process();
            break;

        case 2:
            $log->log($lang->out("selected_altay"));
            $altay = new Altay();
            $altay->process();
            break;
    }
}

which_qube();
