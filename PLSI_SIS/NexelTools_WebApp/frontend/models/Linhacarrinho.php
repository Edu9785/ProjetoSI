<?php

namespace frontend\models;

use common\models\Produto;
use frontend\models\Carrinhocompra;
use Yii;

/**
 * This is the model class for table "linhacarrinho".
 *
 * @property int $id
 * @property int $id_carrinho
 * @property int $id_produto
 *
 * @property Carrinhocompra $carrinho
 * @property Produto $produto
 */
class Linhacarrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhacarrinho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_carrinho', 'id_produto'], 'required'],
            [['id_carrinho', 'id_produto'], 'integer'],
            [['id_produto'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['id_produto' => 'id']],
            [['id_carrinho'], 'exist', 'skipOnError' => true, 'targetClass' => Carrinhocompra::class, 'targetAttribute' => ['id_carrinho' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_carrinho' => 'Id Carrinho',
            'id_produto' => 'Id Produto',
        ];
    }

    /**
     * Gets query for [[Carrinho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinho()
    {
        return $this->hasOne(Carrinhocompra::class, ['id' => 'id_carrinho']);
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
