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
 * @property int $id_metodopagamento
 * @property int $id_expedicao
 *
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
            [['precofatura', 'datahora', 'id_profile', 'id_metodopagamento', 'id_expedicao'], 'required'],
            [['precofatura'], 'number'],
            [['datahora'], 'safe'],
            [['id_profile', 'id_metodopagamento', 'id_expedicao'], 'integer'],
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
            'precofatura' => 'Precofatura',
            'datahora' => 'Datahora',
            'id_profile' => 'Id Profile',
            'id_metodopagamento' => 'Id Metodopagamento',
            'id_expedicao' => 'Id Expedicao',
        ];
    }

    /**
     * Gets query for [[Linhafaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafatura()
    {
        return $this->hasMany(Linhafatura::class, ['id_fatura' => 'id']);
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
