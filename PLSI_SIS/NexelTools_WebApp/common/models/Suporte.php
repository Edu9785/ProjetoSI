<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "suporte".
 *
 * @property int $id
 * @property string $assunto
 * @property string $desc
 * @property int $id_profile
 *
 * @property Profile $profile
 */
class Suporte extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'suporte';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assunto', 'desc', 'id_profile'], 'required', 'message' => 'Por favor, preencha todos os campos.'],
            [['id_profile'], 'integer'],
            [['assunto'], 'string', 'max' => 55],
            [['desc'], 'string', 'max' => 455],
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
            'assunto' => 'Assunto',
            'desc' => 'Desc',
            'id_profile' => 'Id Profile',
        ];
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
