<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Review;

/**
 * ReviewForm is the model behind the review form.
 */
class ReviewForm extends Model
{
    public $conteudo;
    public $avaliacao;
    public $produto_id;
    public $userprofile_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['conteudo', 'avaliacao', 'produto_id', 'userprofile_id'], 'required'],
            ['avaliacao', 'integer', 'min' => 1, 'max' => 5],
            ['conteudo', 'string', 'min' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'conteudo' => 'Your Review',
            'avaliacao' => 'Your Rating',
        ];
    }

    /**
     * Saves the review to the database.
     * 
     * @return bool whether the saving succeeds
     */
    public function saveReview()
    {
        if ($this->validate()) {
            $review = new Review();

            $review->conteudo = $this->conteudo;
            $review->avaliacao = $this->avaliacao;
            $review->produto_id = $this->produto_id;
            $review->userprofile_id = $this->userprofile_id;
            $review->datahora = date('Y-m-d H:i:s');

            if ($review->save()) {
                Yii::info('Review successfully saved: ' . var_export($review->attributes, true));
                return true;
            } else {
                Yii::error('Validation errors: ' . json_encode($this->errors));
                return false;
            }
        }
        return false;
    }
}
