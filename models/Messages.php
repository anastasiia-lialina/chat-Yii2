<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $text
 * @property bool|null $is_visible
 * @property int $created_at
 *
 * @property Users $user
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{messages}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['user_id', 'created_at'], 'default', 'value' => null],
            [['user_id', 'created_at'], 'integer'],
            [['text'], 'string'],
            [['is_visible'], 'boolean'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID автора',
            'text' => Yii::t('common', 'Message'),
            'is_visible' => Yii::t('common', 'Is visible'),
            'created_at' => Yii::t('common', 'Date and time'),
            'date' => Yii::t('common', 'Date and time'),
            'username' => Yii::t('common', 'Username'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * имя автора сообщений
     * @return string
     */
    public function getUsername()
    {
        return $this->user->username;
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDatetime($this->created_at);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->user_id = Yii::$app->getUser()->id;
            $this->is_visible = true;
            $this->created_at = time();
        }

        return true;
    }

    /**
     * Блокировака/ Разблокировка сообщения
     * @param bool $visible
     * @return bool
     */
    public function toggleBan(bool $visible)
    {
        $this->is_visible = $visible;

        return $this->save();
    }
}
