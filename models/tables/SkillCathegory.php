<?php

namespace app\models\tables;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "SkillCathegory".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Skill[] $skills
 */
class SkillCathegory extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SkillCathegory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Category',
        ];
    }

    /**
     * Gets query for [[Skills]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkills()
    {
        return $this->hasMany(Skill::class, ['SkillCathegory_id' => 'id']);
    }

    public static function getCathegories(): array
    {
        return ArrayHelper::map(
            self::find()->orderBy(['name' => SORT_ASC])->all(),
            'id',
            'name'
        );
    }

    public static function dropdownList(): array
    {
        return self::getCathegories();
    }

}
