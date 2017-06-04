<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Note
 * @package app\models
 *
 * @property $uid string
 * @property $password_hash string
 * @property $body string
 *
 * @property $password string
 * @property $passwordRepeat string
 */
class Note extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';

    const SCENARIO_ENTER_PASSWORD = 'enter_password';

    public $password;

    public $passwordRepeat;

    private $passwordEntered = false;

    public static function tableName()
    {
        return '{{%note}}';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['body', 'password', 'passwordRepeat'],
            self::SCENARIO_ENTER_PASSWORD => ['password'],
        ];
    }

    public function rules()
    {
        return [
            ['body', 'required', 'on' => self::SCENARIO_CREATE],
            [['password', 'passwordRepeat'], 'string', 'min' => 6, 'max' => 32],
            ['password', 'compare', 'compareAttribute' => 'passwordRepeat', 'on' => self::SCENARIO_CREATE],
            ['password', 'required', 'on' => self::SCENARIO_ENTER_PASSWORD],
            ['password', 'validateEnterPassword', 'on' => self::SCENARIO_ENTER_PASSWORD],
        ];
    }

    public function validateEnterPassword($attribute, $params)
    {
        if (!$this->validatePassword($this->$attribute)) {
            $this->addError($attribute, 'Неверный пароль.');
        }
    }

    public function attributeLabels()
    {
        return [
            'body' => 'Текст записки',
            'password' => 'Секретный пароль',
            'passwordRepeat' => 'Повторите пароль',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $security = \Yii::$app->security;

            if (empty($this->password)) {
                $this->password = $security->generateRandomString(8);
            } else {
                $this->passwordEntered = true;
            }

            $this->uid = $security->generateRandomString(16);
            $this->setPassword($this->password);

            return true;
        } else {
            return false;
        }
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password, 8);
    }

    public function getLink()
    {
        $id = '';

        if ($this->passwordEntered === false) {
            $id .= $this->uid . '!' . $this->password;
        } else {
            $id .= $this->uid;
        }

        return \Yii::$app->request->getHostInfo() . '/' . $id;
    }
}