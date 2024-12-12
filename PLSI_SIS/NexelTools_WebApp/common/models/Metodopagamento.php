<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metodopagamentos".
 *
 * @property int $id
 * @property string $nomemetodo
 *
 * @property Compras[] $compras
 * @property Faturas[] $faturas
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
            [['nomemetodo'], 'required'],
            [['nomemetodo'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomemetodo' => 'Nomemetodo',
        ];
    }

    /**
     * Gets query for [[Compras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompras()
    {
        return $this->hasMany(Compras::class, ['id_metodopagamento' => 'id']);
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Faturas::class, ['id_metodopagamento' => 'id']);
    }
}
