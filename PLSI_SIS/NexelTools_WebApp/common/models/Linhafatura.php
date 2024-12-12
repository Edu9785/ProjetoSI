<?php

namespace common\models;

use frontend\models\Faturas;
use frontend\models\Produtos;

/**
 * This is the model class for table "linhafatura".
 *
 * @property int $id
 * @property int $id_fatura
 * @property int $id_produto
 *
 * @property Fatura $fatura
 * @property Produto $produto
 */
class Linhafatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhafatura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_fatura', 'id_produto'], 'required'],
            [['id_fatura', 'id_produto'], 'integer'],
            [['id_fatura'], 'exist', 'skipOnError' => true, 'targetClass' => Fatura::class, 'targetAttribute' => ['id_fatura' => 'id']],
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
            'id_fatura' => 'Id Fatura',
            'id_produto' => 'Id Produto',
        ];
    }

    /**
     * Gets query for [[Fatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFatura()
    {
        return $this->hasOne(Fatura::class, ['id' => 'id_fatura']);
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
