<?php

namespace app\controllers;

use Yii;
use app\classes\process\FileManager;
use app\classes\process\ParseManager;
use app\models\File;
use app\models\FileForm;
use yii\base\Controller;
use yii\web\UploadedFile;

class PlotterController extends Controller
{
    const NO_CONTENT = 'У файла нет контента';
    public $enableCsrfValidation = false;
    public $layout = 'plotter-main';

    /**
     * Action to load the page first and after sending the form with the file
     *
     * @return string
     */
    public function actionIndex()
    {
        $result = null;
        $message = null;
        $model = new FileForm();

        if (\Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file && $model->validate()) {
                $result = FileManager::loadFileService($model);
                if (!$result) $message = self::NO_CONTENT;
            }
        }

        return $this->render('index', [
            'model' => $model,
            'result' => $result,
            'message' => $message
        ]);
    }

    /**
     * Action on asynchronous request to the server.
     * The query array to plot as a result of parsing the attached file
     *
     * @return bool|string
     */
    public function actionParse()
    {
        $result = false;
        $file = File::findOne(['save' => 1]);
        $content = FileManager::fileGetContent($file->name);
        if ($file && $content) {
            $result = ParseManager::getParseArray($file, $content);
        }
        if (Yii::$app->request->isAjax) {
            return json_encode($result);
        }
    }

    /**
     * Here lies the test task
     *
     * @return string
     */
    public function actionTest()
    {
        return $this->render('test');
    }


}