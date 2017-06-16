<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Note
 * @package app\models
 *
 * @property string $uid
 * @property string $password_hash
 * @property string $body
 * @property string $email
 * @property string $password
 * @property string $passwordRepeat
 * @property string $file_path
 * @property integer $lifetime
 */
class Note extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';

    const SCENARIO_ENTER_PASSWORD = 'enter_password';

    public $password;

    public $passwordRepeat;

    private $passwordEntered = false;

    public $lifetimeOption;

    public $file;

    public static function tableName()
    {
        return '{{%note}}';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => [
                'body',
                'password',
                'passwordRepeat',
                'email',
                'lifetimeOption',
                'file',
            ],
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
            ['email', 'email', 'on' => self::SCENARIO_CREATE],
            ['lifetimeOptions', 'in', 'range' => array_keys(self::getLifetimeOptions()), 'on' => self::SCENARIO_CREATE],
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
            'lifetimeOptions' => 'Время жизни',
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

            if ($this->lifetimeOption > 0) {
                $this->lifetime = time() + ($this->lifetimeOption * 60 * 60);
            }

            if (!empty($this->file)) {
                $this->file_path = $this->file['path'] ?? '';
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

    public static function getLifetimeOptions()
    {
        return [
            0 => 'после прочтения',
            1 => 'спустя 1 час',
            24 => 'спустя 24 часа',
            168 => 'спустя 7 дней',
            720 => 'спустя 30 дней',
        ];
    }

    public function sendNotify()
    {
        (new \rmrevin\yii\postman\ViewLetter())
            ->setSubject('Уведомление об уничтожении')
            ->setBodyFromView('delete-note-notify', ['model' => $this])
            ->addAddress([$this->email])
            ->send();
    }
}
