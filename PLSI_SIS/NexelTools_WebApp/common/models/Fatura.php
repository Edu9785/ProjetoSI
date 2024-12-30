<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faturas".
 *
 * @property int $id
 * @property float $precofatura
 * @property string $datahora
 * @property int $id_profile
 * @property int $id_compra
 *
 * @property Compra $compra
 * @property Linhafatura[] $linhafaturas
 * @property Metodopagamento $metodopagamento
 * @property Profile $profile
 */
class Fatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faturas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['precofatura', 'datahora', 'id_profile', 'id_compra'], 'required'],
            [['precofatura'], 'number'],
            [['datahora'], 'safe'],
            [['id_profile', 'id_compra'], 'integer'],
            [['id_compra'], 'exist', 'skipOnError' => true, 'targetClass' => Compra::class, 'targetAttribute' => ['id_compra' => 'id']],
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
            'precofatura' => 'Precofatura',
            'datahora' => 'Datahora',
            'id_profile' => 'Id Profile',
            'id_compra' => 'Id Compra',
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
     * Gets query for [[Linhafaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafaturas()
    {
        return $this->hasMany(Linhafatura::class, ['id_fatura' => 'id']);
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
