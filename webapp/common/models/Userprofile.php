<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "userprofile".
 *
 * @property int $id
 * @property string|null $morada
 * @property int|null $nif
 * @property int|null $telefone
 * @property string|null $nome
 * @property int $user_id
 *
 * @property User $user
 */
class Userprofile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userprofile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nif', 'telefone', 'user_id'], 'integer'],
            [['user_id'], 'required'],
            [['morada', 'nome'], 'string', 'max' => 80],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'morada' => 'Morada',
            'nif' => 'Nif',
            'telefone' => 'Telefone',
            'nome' => 'Nome',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getCarrinhoproduto()
    {
        return $this->hasOne(Carrinhoproduto::class, ['userprofile_id' => 'id']);
    }

    public function getCarrinhoservico()
    {
        return $this->hasOne(Carrinhoservico::class, ['userprofile_id' => 'id']);
    }

    public function getFavoritos()
    {
        return $this->hasMany(Favorito::class, ['userprofile_id' => 'id']);
    }

    public function getReviews()
    {
        return $this->hasMany(Review::class, ['userprofile_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $id = $this->id;
        $nome = $this->nome;
        $morada = $this->morada;
        $telefone = $this->telefone;
        $nif = $this->nif;

        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->nome = $nome;
        $myObj->morada = $morada;
        $myObj->telefone = $telefone;
        $myObj->nif = $nif;


        $myJSON = json_encode($myObj);
        if ($insert)
            $this->FazPublishNoMosquitto("UserProfileCreate", $myJSON);
        else
            $this->FazPublishNoMosquitto("UserProfileUpdate", $myJSON);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $id = $this->id;
        $nome = $this->nome;
        $morada = $this->morada;
        $telefone = $this->telefone;
        $nif = $this->nif;

        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->nome = $nome;
        $myObj->morada = $morada;
        $myObj->telefone = $telefone;
        $myObj->nif = $nif;
        
        $myJSON = json_encode($myObj);
        $this->FazPublishNoMosquitto("UserProfileDelete", $myJSON);
    }

    public function FazPublishNoMosquitto($canal, $msg)
    {
        $server = "127.0.0.1";
        $port = 1883;
        $username = "";
        $password = "";
        $client_id = "phpMQTT-publisher";
        $mqtt = new \backend\mosquitto\phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL, $username, $password)) {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        } else {
            file_put_contents("debug.output", "Time out!");
        }
    }
}
