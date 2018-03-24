<?php

namespace app\classes\process;

use app\models\File;
use app\models\FileForm;

class FileManager
{

    /**
     * Downloading a new file to the server
     *
     * @param FileForm $model
     * @return bool
     */
    static public function loadFileService(FileForm $model)
    {
        $fileNew = \Yii::getAlias("file/") . $model->file->name;
        $extension = $model->file->extension;
        if ($fileNew) {
            $model->file->saveAs($fileNew);
            chmod("$fileNew", 0777);
            $result = self::securityContent($fileNew, $extension);
        } else $result = false;
        return $result;
    }

    /**
     * Deleting a file from the server
     *
     * @param $file
     */
    static private function unLoadFileService($file)
    {
        if (file_exists($file)) {
            unlink($file);
        }
    }

    /**
     * Clearing the server from old files
     *
     * @param $file
     */
    static private function cleanFileService($file)
    {
        $filesService = glob("file/*");
        foreach ($filesService as $fileService) {
            if ($fileService != $file) {
                self::unLoadFileService($fileService);
            }
        }
    }

    /**
     * Writing a file to a database
     *
     * @param $file
     * @param $extension
     */
    static private function saveFileDb($file, $extension)
    {
        self::cleanFileDb();
        $fileDb = new File();
        $fileDb->save = 1;
        $fileDb->name = $file;
        $fileDb->extension = $extension;
        $fileDb->save();
    }

    /**
     *Clearing the table with files in the database
     */
    static private function cleanFileDb()
    {
        $file = File::findOne(['save' => 1]);
        if ($file) {
            $file->delete();
        }
    }

    /**
     * Check for content in a file
     *
     * @param $file
     * @param $extension
     * @return bool|string
     */
    private static function securityContent($file, $extension)
    {
        $content = self::fileGetContent($file);
        if ($content) {
            self::saveFileDb($file, $extension);
            self::cleanFileService($file);
            return $content;
        } else self::unLoadFileService($file);
        return false;
    }

    /**
     * Receiving content of the file
     *
     * @param $file
     * @return bool|string
     */
    public static function fileGetContent($file)
    {
        $content = file_get_contents($file);
        $dom =  \phpQuery::newDocumentHTML($content, $charset = 'utf-8');
        if($dom->find('body')->html() == null) $content = false;
        return $content;
    }
}
