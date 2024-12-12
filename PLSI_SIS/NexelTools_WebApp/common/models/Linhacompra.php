<?php

namespace common\models;

use Yii;

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
}
