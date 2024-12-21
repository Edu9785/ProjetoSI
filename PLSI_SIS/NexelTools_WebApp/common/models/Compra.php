<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "compras".
 *
 * @property int $id
 * @property int $id_profile

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
            [['id_profile',  'datacompra', 'precototal', 'id_metodopagamento'], 'required'],
            [['id_profile', 'id_metodopagamento'], 'integer'],
            [['datacompra'], 'safe'],
            [['precototal'], 'number'],
            [['id_metodoexpedicao'], 'integer'],
            [['id_metodoexpedicao'], 'exist', 'skipOnError' => true, 'targetClass' => Metodoexpedicao::class, 'targetAttribute' => ['id_metodoexpedicao' => 'id']],
            [['id_metodopagamento'], 'exist', 'skipOnError' => true, 'targetClass' => Metodopagamento::class, 'targetAttribute' => ['id_metodopagamento' => 'id']],
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
    public function getLinhacompras()
    {
        return $this->hasMany(Linhacompra::class, ['id_compra' => 'id']);
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
