<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2017 Power Kernel
 */


namespace powerkernel\support\models;

use common\models\Account;
use MongoDB\BSON\UTCDateTime;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TicketSearch represents the model behind the search form about `powerkernel\ticket\models\Ticket`.
 */
class TicketSearch extends Ticket
{
    public $userSearch=false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat', 'title', 'status', 'created_at', 'created_by'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Ticket::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]],
            //'pagination'=>['pageSize'=>20],
        ]);

        $this->load($params);

        if($this->userSearch){
            $query->andFilterWhere(['created_by'=>Yii::$app->user->id]);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
            'cat' => $this->cat,
            'status' => $this->status,
            //'created_by' => $this->created_by,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        if(!empty($this->created_by)) {
            if(Yii::$app->params['mongodb']['account']){
                $key='_id';
            }
            else {
                $key='id';
            }
            $ids = [];
            $owners=Account::find()->select([$key])->where(['like', 'fullname', $this->created_by])->asArray()->all();
            foreach ($owners as $owner) {
                if(Yii::$app->params['mongodb']['account']){
                    $ids[] = (string)$owner[$key];
                }
                else {
                    $ids[] = (int)$owner[$key];
                }
            }
            $query->andFilterWhere(['created_by' => empty($ids)?'0':$ids]);
        }

        if(!empty($this->created_at)){
            if (is_a($this, '\yii\mongodb\ActiveRecord')) {
                $query->andFilterWhere([
                    'created_at' => ['$gte'=>new UTCDateTime(strtotime($this->created_at)*1000)],
                ])->andFilterWhere([
                    'created_at' => ['$lt'=>new UTCDateTime((strtotime($this->created_at)+86400)*1000)],
                ]);
            }
            else {
                $query->andFilterWhere([
                    'DATE(CONVERT_TZ(FROM_UNIXTIME(`created_at`), :UTC, :ATZ))' => $this->created_at,
                ])->params([
                    ':UTC'=>'+00:00',
                    ':ATZ'=>date('P')
                ]);
            }

        }

        return $dataProvider;
    }
}
