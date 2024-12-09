<?php

namespace frontend\models;

use common\models\Produto;
use common\models\Profile;
use frontend\models\Linhacarrinho;

/**
 * This is the model class for table "carrinhocompras".
 *
 * @property int $id
 * @property int $id_profile
 * @property float $precototal
 *
 * @property Linhacarrinho[] $linhacarrinhos
 * @property Profile $profile
 */
class Carrinhocompra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinhocompras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_profile', 'precototal'], 'required'],
            [['id_profile'], 'integer'],
            [['precototal'], 'number'],
            [['id_profile'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['id_profile' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_profile' => 'Id Profile',
            'precototal' => 'Precototal',
        ];
    }

    /**
     * Gets query for [[Linhacarrinhos]].
     *
     * @return float|int
     */
    public function calcularPrecoTotal($id_carrinho){
        $linhasCarrinho = Linhacarrinho::find()->where(['id_carrinho' => $id_carrinho])->all();
        $total = 0;

        foreach ($linhasCarrinho as $linha){
            $produto = Produto::findOne([$linha->id_produto]);
            if($produto){
                $total += $produto->preco;
            }
        }

        return $total;
    }
    public function getLinhacarrinho()
    {
        return $this->hasMany(Linhacarrinho::class, ['id_carrinho' => 'id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['id' => 'id_profile']);
    }
}
