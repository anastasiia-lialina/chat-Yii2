<?php

namespace app\models;

use Yii;

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
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'text' => 'Сообщение',
            'is_visible' => 'Бан',
            'created_at' => 'Время отправления',
            'author' => 'Автор'
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
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
}
