<?php

namespace common\models;

require '../../mosquitto/phpMQTT.php';
use mosquitto\phpMQTT;

/**
 * This is the model class for table "linhacompra".
 *
 * @property int $id
 * @property int $id_compra
 * @property int $id_produto
 *
 * @property Compra $compra
 * @property Produto $produto
 */
class Linhacompra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhacompra';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_compra', 'id_produto'], 'required'],
            [['id_compra', 'id_produto'], 'integer'],
            [['id_compra'], 'exist', 'skipOnError' => true, 'targetClass' => Compra::class, 'targetAttribute' => ['id_compra' => 'id']],
            [['id_produto'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['id_produto' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_compra' => 'Id Compra',
            'id_produto' => 'Id Produto',
        ];
    }

    /**
     * Gets query for [[Compra]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompra()
    {
        return $this->hasOne(Compra::class, ['id' => 'id_compra']);
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'id_produto']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $comprador = $this->compra->profile;
        $vendedor = $this->produto->profile;
        $produto = $this->produto;
        $preco = $produto->preco;

        $mensagem = "{$comprador->nome} comprou {$produto->nome} de {$vendedor->nome} no valor de {$preco}€";

        $this->FazPublishNoMosquitto("COMPRAS", $mensagem);
    }

    public function FazPublishNoMosquitto($canal, $msg)
    {
        $server = "127.0.0.1";  // Endereço do servidor MQTT
        $port = 1883;            // Porta do broker MQTT
        $username = "";          // Username do broker MQTT (se necessário)
        $password = "";          // Senha do broker MQTT (se necessário)
        $client_id = "phpMQTT-publisher";  // ID único para o cliente MQTT


        $mqtt = new phpMQTT($server, $port, $client_id);

        if ($mqtt->connect(true, NULL, $username, $password)) {

            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        } else {
            file_put_contents("debug.output", "Time out!");
        }
    }
}