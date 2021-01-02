<?php
namespace SzymonKadelskiRekrutacjaHRtech\src\Console;

require_once ("FileMethods.php");

class Console{
    public const DELIMITER = "|";

    private string $writeType; 
    private string $url;
    private string $path;

    public function __construct()
    {
        $FileMethods = new File;

        if(count($_SERVER['argv'])!=4)
        {
            echo"Please pass 3 agruments to run this code.";
            return ;
        }
    
        $writeType = $_SERVER['argv'][1];            
        $url = $_SERVER['argv'][2];
        $path = $_SERVER['argv'][3];

        if($writeType!="csv:simple" && $writeType != "csv:extended")
        {
            echo"Invalid first parameter";
            return;
        }

        if(strlen($url)<6)
        {
            echo "Invalid second parameter";
            return;
        }

        $xml = file_get_contents($url);
        $xmlFile = simplexml_load_string($xml, null, LIBXML_NOCDATA);
        $file = $FileMethods->OpenFile($path, $writeType);

        if( !file_exists($path) || $writeType=="csv:simple") 
        {
            $FileMethods->writeHeadersColumn($file);
        }

        $FileMethods->writeInFile($file,$xmlFile);
        $FileMethods->CloseFile($file);
    }
}

$new = new Console();