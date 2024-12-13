<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "favorito".
 *
 * @property int $id
 * @property int $userprofile_id
 * @property int|null $servico_id
 * @property int|null $produto_id
 */
class Favorito extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorito';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userprofile_id'], 'required'],
            [['userprofile_id', 'servico_id', 'produto_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userprofile_id' => 'Userprofile ID',
            'servico_id' => 'Servico ID',
            'produto_id' => 'Produto ID',
        ];
    }

    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['id' => 'userprofile_id']);
    }
}
