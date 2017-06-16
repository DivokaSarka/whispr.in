<?php

namespace app\commands;

use app\models\Note;
use yii\console\Controller;

class DeleteNotesByLifetimeController extends Controller
{
    public function actionIndex()
    {
        $notes = Note::find()->where(['<>', 'lifetime', 0])->all();

        /* @var $notes Note[] */
        foreach ($notes as $note) {
            if (time() >= $note->lifetime) {
                if (!empty($note->email)) {
                    $note->sendNotify();
                }

                $note->delete();
            }
        }
    }
}
