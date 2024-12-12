<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mbway".
 *
 * @property int $id
 * @property int $numero
 * @property int $id_profile
 *
 * @property Metodopagamento[] $metodopagamentos
 * @property Profile $profile
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
            [['numero', 'id_profile'], 'required'],
            [['numero', 'id_profile'], 'integer'],
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
            'numero' => 'Numero',
            'id_profile' => 'Id Profile',
        ];
    }

    /**
     * Gets query for [[Metodopagamentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodopagamentos()
    {
        return $this->hasMany(Metodopagamento::class, ['id_metodo' => 'id']);
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
