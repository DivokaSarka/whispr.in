<?php

namespace app\controllers;

use yii\web\Controller;

class FileController extends Controller
{
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'trntv\filekit\actions\UploadAction',
                'multiple' => true,
                'disableCsrf' => false,
                'validationRules' => [
                    ['file', 'file', 'extensions' => 'pdf, doc, docx'],
                ],
            ]
        ];
    }

    public function actionDelete($path = null)
    {
        $filePath = \Yii::getAlias('@webroot/uploads/' . $path);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
