<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "Skill".
 *
 * @property int $id
 * @property int $SkillCathegory_id
 * @property string|null $name
 * @property string|null $count
 *
 * @property SkillCathegory $skillCathegory
 */
class Skill extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Skill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'default', 'value' => null],
            [['count'], 'default', 'value' => '1'],
            [['SkillCathegory_id'], 'required'],
            [['id', 'SkillCathegory_id'], 'integer'],
            [['name', 'count'], 'string', 'max' => 45],
            [['SkillCathegory_id'], 'exist', 'skipOnError' => true, 'targetClass' => SkillCathegory::class, 'targetAttribute' => ['SkillCathegory_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'SkillCathegory_id' => 'Skill Cathegory ID',
            'name' => 'Name',
            'count' => 'Count',
        ];
    }

    /**
     * Gets query for [[SkillCathegory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkillCathegory()
    {
        return $this->hasOne(SkillCathegory::class, ['id' => 'SkillCathegory_id']);
    }

}
