<?php
namespace app\modules\blog\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class PostSearch extends Post
{
    public $searchTitle;
    public $searchContent;
    public $dateFrom;
    public $dateTo;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'searchTitle', 'searchContent', 'dateFrom', 'dateTo'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find()->select('posts.*')
            ->innerJoin('post_i18ns', '`post_i18ns`.`parent_id` = `posts`.`id`')
            ->groupBy('`posts`.`id`');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'       => ['defaultOrder' => '`published_at` DESC'],
            'pagination' => ['pageSize' => 20],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
        ]);
        if (!empty($this->dateFrom)) {
            $query->andFilterWhere(['>=', 'DATE(published_at)', date('Y-m-d', strtotime($this->dateFrom))]);
        }

        if (!empty($this->dateTo)) {
            $query->andFilterWhere(['<=', 'DATE(published_at)', date('Y-m-d', strtotime($this->dateTo))]);
        }
//        if ($this->published_at) {
//            $query->andFilterWhere(['DATE(published_at)' => date('Y-m-d', strtotime($this->published_at))]);
//        }
        $query->andFilterWhere(['like', 'post_i18ns.title', $this->searchTitle]);
        $query->andFilterWhere(['like', 'post_i18ns.content', $this->searchContent]);

        return $dataProvider;
    }
}