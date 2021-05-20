<?php

namespace app\models\search;

use app\models\Users;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Messages;
use kartik\daterange\DateRangeBehavior;

/**
 * MessagesSearch represents the model behind the search form of `app\models\Messages`.
 */
class MessagesSearch extends Messages
{
    public $username;
    public $date;
    public $from_date;
    public $to_date;


    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'date',
                'dateStartAttribute' => 'from_date',
                'dateEndAttribute' => 'to_date',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'username','created_at','id', 'user_id'], 'safe'],
            [['is_visible'], 'boolean'],
            [['date'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
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

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'is_visible',
                'created_at',
                'date' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC]
                ],
                'username' => [
                    'asc' => [Users::tableName().'.username' => SORT_ASC],
                    'desc' => [Users::tableName().'.username' => SORT_DESC],
                ],
            ],
            'defaultOrder' => ['created_at' => SORT_DESC]
        ]);

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
            'is_visible' => $this->is_visible
        ]);

        if($this->date){
            $query->andFilterWhere(['>=', 'messages.created_at', $this->from_date])
                ->andFilterWhere(['<', 'messages.created_at', $this->to_date]);
        }

            $query->andFilterWhere(['ilike', 'text', $this->text])
                ->andFilterWhere(['ilike', 'username', $this->username]);

        return $dataProvider;
    }
}
