<?php

namespace app\controllers;

use app\models\Note;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class NoteController extends Controller
{
    public function actionCreate()
    {
        $model = new Note(['scenario' => Note::SCENARIO_CREATE]);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->render('created', [
                'model' => $model,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionView($hash = null)
    {
        list($uid, $password) = array_pad(explode('!', $hash), 2, null);

        $model = Note::findOne(['uid' => $uid]);

        if (is_null($model)) {
            throw new NotFoundHttpException(
                'Записка с ID: ' . $uid . ' уже была прочитана и безвозвратно уничтожена. '
                . 'Если вы забыли переписать текст – попросите отправителя отправить новую записку.'
            );
        }

        if (!empty($password) && !$model->validatePassword($password)) {
            return $this->render('enterPasswordForm', [
                'model' => $model,
            ]);
        }

        if (empty($password)) {
            $model->setScenario(Note::SCENARIO_ENTER_PASSWORD);
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->delete()) {
                return $this->render('view', [
                    'model' => $model,
                ]);
            } else {
                return $this->render('enterPasswordForm', [
                    'model' => $model,
                ]);
            }
        }

        if ($model->lifetime === 0 || (time() >= $model->lifetime)) {
            $model->delete();

            if (!empty($model->email)) {
                $model->sendNotify();
            }
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionDelete($uid)
    {
        $model = Note::findOne(['uid' => $uid]);

        if (!is_null($model)) {
            $model->delete();
        }

        return $this->redirect(\Yii::$app->homeUrl);
    }
}
