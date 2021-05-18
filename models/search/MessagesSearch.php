<?php

namespace app\models\search;

use app\models\Users;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Messages;

/**
 * MessagesSearch represents the model behind the search form of `app\models\Messages`.
 */
class MessagesSearch extends Messages
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_at'], 'integer'],
            [['text'], 'safe'],
            [['is_visible'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Messages::find();

        if (!Yii::$app->user->can('viewBannedMessages')) {
            $query->where(['is_visible' => true]);
        }

        $query->joinWith(['user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['author'] = [
            'asc' => [Users::tableName().'.username' => SORT_ASC],
            'desc' => [Users::tableName().'.username' => SORT_DESC],
        ];

        $dataProvider->setSort(['defaultOrder' => ['created_at' => SORT_DESC]]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'is_visible' => $this->is_visible,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'text', $this->text]);

        return $dataProvider;
    }
}
