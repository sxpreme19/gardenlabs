<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "servico".
 *
 * @property int $id
 * @property string $descricao
 * @property float $preco
 * @property string $titulo
 * @property int $duracao
 * @property int $prestador_id
 *
 * @property Linhacarrinho[] $linhacarrinhos
 * @property Linhafatura[] $linhafaturas
 * @property Review[] $reviews
 */
class Servico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao', 'preco', 'titulo', 'duracao', 'prestador_id'], 'required'],
            [['preco'], 'number'],
            [['duracao', 'prestador_id'], 'integer'],
            [['descricao'], 'string', 'max' => 200],
            [['titulo'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descricao',
            'preco' => 'Preco',
            'titulo' => 'Titulo',
            'duracao' => 'Duracao',
            'prestador_id' => 'Prestador ID',
        ];
    }

    /**
     * Gets query for [[Linhacarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacarrinhoprodutos()
    {
        return $this->hasMany(Linhacarrinhoservico::class, ['servico_id' => 'id']);
    }

    /**
     * Gets query for [[Linhafaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafaturas()
    {
        return $this->hasMany(Linhafatura::class, ['servico_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['servico_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $id = $this->id;
        $titulo = $this->titulo;
        $descricao = $this->descricao;
        $preco = $this->preco;
        $duracao = $this->duracao;
        $prestador_id = $this->prestador_id;

        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->titulo = $titulo;
        $myObj->descricao = $descricao;
        $myObj->preco = $preco;
        $myObj->duracao = $duracao;
        $myObj->prestador_id = $prestador_id;


        $myJSON = json_encode($myObj);
        if ($insert)
            $this->FazPublishNoMosquitto("Services","Serviço criado!" . $myJSON);
        else
            $this->FazPublishNoMosquitto("Services","Serviço atualizado!" . $myJSON);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $id = $this->id;
        $titulo = $this->titulo;
        $descricao = $this->descricao;
        $preco = $this->preco;
        $duracao = $this->duracao;
        $prestador_id = $this->prestador_id;

        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->titulo = $titulo;
        $myObj->descricao = $descricao;
        $myObj->preco = $preco;
        $myObj->duracao = $duracao;
        $myObj->prestador_id = $prestador_id;

        $myJSON = json_encode($myObj);
        $this->FazPublishNoMosquitto("Services","Serviço removido!" . $myJSON);
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
