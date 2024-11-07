<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metodopagamentos".
 *
 * @property int $id
 * @property int $id_metodo
 * @property int $tipometodo
 *
 * @property Compra[] $compras
 * @property Fatura[] $faturas
 * @property Mbway $metodo
 * @property Visa $metodo0
 */
class Metodopagamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metodopagamentos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_metodo', 'tipometodo'], 'required'],
            [['id_metodo', 'tipometodo'], 'integer'],
            [['id_metodo'], 'exist', 'skipOnError' => true, 'targetClass' => Mbway::class, 'targetAttribute' => ['id_metodo' => 'id']],
            [['id_metodo'], 'exist', 'skipOnError' => true, 'targetClass' => Visa::class, 'targetAttribute' => ['id_metodo' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_metodo' => 'Id Metodo',
            'tipometodo' => 'Tipometodo',
        ];
    }

    /**
     * Gets query for [[compra]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompras()
    {
        return $this->hasMany(Compra::class, ['id_metodopagamento' => 'id']);
    }

    /**
     * Gets query for [[Fatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Fatura::class, ['id_metodopagamento' => 'id']);
    }

    /**
     * Gets query for [[Metodo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodo()
    {
        return $this->hasOne(Mbway::class, ['id' => 'id_metodo']);
    }

    /**
     * Gets query for [[Metodo0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodo0()
    {
        return $this->hasOne(Visa::class, ['id' => 'id_metodo']);
    }
}
