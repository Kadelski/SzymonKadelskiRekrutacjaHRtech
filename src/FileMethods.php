<?php

namespace SzymonKadelskiRekrutacjaHRtech\Console;

use DateTime;

class File
{
    public function OpenFile($path, $writeType)
    {
        $file = fopen($path, $writeType == "csv:simple"?"w":"a");
        return $file;
    }

    public function writeHeadersColumn($file)
    {
        fwrite(
            $file,
            "title".Console::DELIMITER.
            "description".Console::DELIMITER.
            "link".Console::DELIMITER.
            "pubDate".Console::DELIMITER.
            "creator\n");
    }

    public function writeInFile($file,$xmlFile)
    {          
        foreach ($xmlFile->channel->item as $item)
        {
            fwrite($file, $item->title . Console::DELIMITER);
            fwrite($file, preg_replace("(http:\S+|<\/?\S+>)", "", $item->description) . Console::DELIMITER);
            fwrite($file, $item->link . Console::DELIMITER);
            fwrite($file, date_format(new DateTime($item->pubDate), 'd F Y H:i:s') . Console::DELIMITER);
            fwrite($file, $item->xpath("//dc:creator")[0]);
            fwrite($file, "\n");
        }
    }

    public function CloseFile($file)
    {
        if (fclose($file) == false)
        {
            echo "Failed to close file";
        }
    }



}