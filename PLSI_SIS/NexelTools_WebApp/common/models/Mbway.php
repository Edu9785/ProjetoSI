<?php

namespace common\models;

use frontend\models\Metodopagamentos;

/**
 * This is the model class for table "mbway".
 *
 * @property int $id
 * @property int $numero
 *
 * @property Metodopagamento[] $metodopagamentos
 */
class Mbway extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mbway';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numero'], 'required'],
            [['numero'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'numero' => 'Numero',
        ];
    }

    /**
     * Gets query for [[Metodopagamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodopagamentos()
    {
        return $this->hasMany(Metodopagamentos::class, ['id_metodo' => 'id']);
    }
}
