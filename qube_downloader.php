<?php

abstract class Downloader {
    public const VERSION = 1.3;
    public $dir = "";
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
    public function touchFile($unixsec) : array {
        $sec = time() - $unixsec;
        $min = $sec / 60;
        $hour = $min / 60;
        if ($min < 1)$min = 0;
        if ($hour < 1)$hour = 0;
        $filename = "qube.txt";
        $timeformatV1 = $hour."h ".$min."m ".$sec."s";
        $content = "--This server was created with the Qube Software--\nQube Version: ".self::VERSION."\nTime tooked to create: ".$timeformatV1. " (Unix)\nDownload at: github.com/EnteFanPHP/Qube";
        return [$filename,
            $content];
    }
}

class PocketMineMP extends Downloader {

    public $dir = "PocketMine-MP";

    public const POCKETMINE_GITHUB = "https://github.com/pmmp/PocketMine-MP/";

    public const LATEST_RELEAS_PHAR = "https://github.com/pmmp/PocketMine-MP/releases/latest/download/PocketMine-MP.phar";

    public function process() : void {
        $starttime = time();
        shell_exec("git clone " . self::POCKETMINE_GITHUB);
        chdir("PocketMine-MP");
        shell_exec("chmod +x start.sh");
        shell_exec("wget " . self::LATEST_RELEAS_PHAR);
        shell_exec("mkdir -p bin/php7/bin");
        chdir("bin/php7/bin");
        shell_exec("wget ".self::LATEST_PHP_BINARY);
        shell_exec("chmod +x php");
        chdir("../../../../");
        shell_exec("mv PocketMine-MP ../");
        $touch = $this->touchFile($starttime);
        file_put_contents("../".$this->dir."/".$touch[0], $touch[1]);
        $foldername = substr(__DIR__, strrpos(__DIR__, '/') + 1);
        chdir("../");
        $this->deleteRecursive($foldername);
    }
}

class Altay extends Downloader {

    public $dir = "BetterAltay";

    public const ALTAY_GITHUB = "https://github.com/Benedikt05/BetterAltay";

    public const LATEST_RELEAS_PHAR = "https://github.com/Benedikt05/BetterAltay/releases/latest/download/BetterAltay.phar";

    public function process() : void {
        $starttime = time();
        shell_exec("git clone " . self::ALTAY_GITHUB);
        chdir("BetterAltay");
        shell_exec("chmod +x start.sh");
        shell_exec("wget " . self::LATEST_RELEAS_PHAR);
        shell_exec("mkdir -p bin/php7/bin");
        chdir("bin/php7/bin");
        shell_exec("wget ".self::LATEST_PHP_BINARY);
        shell_exec("chmod +x php");
        chdir("../../../../");
        shell_exec("mv BetterAltay ../");
        $touch = $this->touchFile($starttime);
        file_put_contents("../".$this->dir."/".$touch[0], $touch[1]);
        $foldername = substr(__DIR__, strrpos(__DIR__, '/') + 1);
        chdir("../");
        $this->deleteRecursive($foldername);
    }

}

class Nukkit extends Downloader {

    public $dir = "Nukkit";

    public const JENKINS = "https://ci.opencollab.dev//job/NukkitX/job/Nukkit/job/master/lastSuccessfulBuild/artifact/target/nukkit-1.0-SNAPSHOT.jar";

    public const JAR_FILE = "nukkit-1.0-SNAPSHOT.jar";

    public function process() : void {
        $starttime = time();
        mkdir($this->dir);
        chdir($this->dir);
        shell_exec("wget ".self::JENKINS);
        $start_code = "java -Xms2G -Xms2G -jar ".self::JAR_FILE;
        file_put_contents("start.sh", $start_code);
        shell_exec("chmod +x start.sh");
        chdir("../");
        shell_exec("mv ".$this->dir." ../");
        $touch = $this->touchFile($starttime);
        file_put_contents("../".$this->dir."/".$touch[0], $touch[1]);
        $foldername = substr(__DIR__, strrpos(__DIR__, '/') + 1);
        chdir("../");
        $this->deleteRecursive($foldername);
    }

}

function which_qube() {
    $log = new Log();
    $lang = new Language();
    $log->log($lang->out("question1_which_software"));
    $ss = readline($log->log($lang->out("answer1_question1"), "normal", true));
    if (!((1 <= $ss) && ($ss <= 3))) {
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

        case 3:
            if (stristr(PHP_OS, "LINUX")) {
                $log->log($lang->out("after_downloading_nukkit"), "NOTICE");
            }
            delay(0.5);
            $log->log($lang->out("selected_nukkit"));
            $nukkit = new Nukkit();
            $nukkit->process();
            break;
    }
}

which_qube();
