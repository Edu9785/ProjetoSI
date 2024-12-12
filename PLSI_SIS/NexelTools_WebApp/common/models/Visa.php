<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "visa".
 *
 * @property int $id
 * @property int $numerocartao
 * @property string $nome
 * @property string $validade
 * @property int $cvv
 * @property int $id_profile
 *
 * @property Metodopagamento[] $metodopagamentos
 */
class Visa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numerocartao', 'nome', 'validade', 'cvv', 'id_profile'], 'required'],
            [['numerocartao', 'cvv', 'id_profile'], 'integer'],
            [['nome', 'validade'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'numerocartao' => 'Numerocartao',
            'nome' => 'Nome',
            'validade' => 'Validade',
            'cvv' => 'Cvv',
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
}
