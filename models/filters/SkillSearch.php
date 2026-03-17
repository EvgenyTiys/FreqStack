<?php

namespace app\models\filters;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\tables\Skill;

/**
 * SkillSearch represents the model behind the search form of `app\models\tables\Skill`.
 */
class SkillSearch extends Skill
{
    public $skillCathegoryName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'SkillCathegory_id'], 'integer'],
            [['name', 'count', 'skillCathegoryName'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Skill::find()->joinWith(['skillCathegory']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];
        $dataProvider->sort->attributes['skillCathegoryName'] = [
            'asc' => ['SkillCathegory.name' => SORT_ASC],
            'desc' => ['SkillCathegory.name' => SORT_DESC],
        ];

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'SkillCathegory_id' => $this->SkillCathegory_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'count', $this->count]);

        $query->andFilterWhere(['like', 'SkillCathegory.name', $this->skillCathegoryName]);

        return $dataProvider;
    }
}
