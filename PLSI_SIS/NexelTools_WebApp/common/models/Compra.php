<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "compras".
 *
 * @property int $id
 * @property int $id_profile
 * @property int $id_produto
 * @property string $datacompra
 * @property float $precototal
 * @property int $id_metodopagamento
 *
 * @property Metodopagamento $metodopagamento
 * @property Produto $produto
 * @property Profile $profile
 */
class Compra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_profile', 'id_produto', 'datacompra', 'precototal', 'id_metodopagamento'], 'required'],
            [['id_profile', 'id_produto', 'id_metodopagamento'], 'integer'],
            [['datacompra'], 'safe'],
            [['precototal'], 'number'],
            [['id_metodopagamento'], 'exist', 'skipOnError' => true, 'targetClass' => Metodopagamento::class, 'targetAttribute' => ['id_metodopagamento' => 'id']],
            [['id_profile'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['id_profile' => 'id']],
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
            'id_profile' => 'Id Profile',
            'id_produto' => 'Id Produto',
            'datacompra' => 'Datacompra',
            'precototal' => 'Precototal',
            'id_metodopagamento' => 'Id Metodopagamento',
        ];
    }

    /**
     * Gets query for [[Metodopagamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodopagamento()
    {
        return $this->hasOne(Metodopagamento::class, ['id' => 'id_metodopagamento']);
    }

    public function getMetodoexpedicao()
    {
        return $this->hasOne(Metodoexpedicao::class, ['id' => 'id_metodoexpedicao']);
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

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['id' => 'id_profile']);
    }

    public function getLinhacompra()
    {
        return $this->hasMany(Linhafatura::class, ['id_fatura' => 'id']);
    }
}
