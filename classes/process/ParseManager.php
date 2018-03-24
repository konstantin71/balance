<?php

namespace app\classes\process;

use app\classes\ParseHtml;
use app\models\File;

class ParseManager
{

    /**
     * A request for the formation in the process of parsing an array of json
     *
     * @param File $file
     * @param $content
     * @return bool|string
     */
    public static function getParseArray(File $file, $content)
    {
        $parseObject = self::parseObjectSelect($file);
        if ($parseObject) {
            $dom = $parseObject->getDom($content);
            $result = $parseObject->getParse($dom);
        } else $result = false;
        return $result;
    }

    /**
     * Object definition for parsing depending on the type of incoming file
     *
     * @param File $file
     * @return ParseHtml|bool
     */
    private static function parseObjectSelect(File $file)
    {
        switch ($file->extension) {
            case 'html' :
                $parseObject = new ParseHtml();
                break;
            default:
                $parseObject = false;
        }
        return $parseObject;
    }


}