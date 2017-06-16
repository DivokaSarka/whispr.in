<?php

namespace app\commands;

use rmrevin\yii\postman\models\LetterModel;
use yii\console\Controller;

class SendMailController extends Controller
{
    public function actionIndex()
    {
        LetterModel::cron($num_letters_per_step = 10);
    }
}
