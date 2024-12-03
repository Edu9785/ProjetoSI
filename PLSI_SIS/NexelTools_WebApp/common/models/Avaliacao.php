<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "avaliacoes".
 *
 * @property int $id
 * @property int $id_user
 * @property string $desc
 * @property string $avaliacao
 * @property int $id_produto
 *
 * @property Produtos $produto
 * @property Profile $user
 */
class Avaliacao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avaliacoes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'desc', 'avaliacao', 'id_produto'], 'required'],
            [['id_user', 'id_produto'], 'integer'],
            [['desc', 'avaliacao'], 'string', 'max' => 45],
            [['id_produto'], 'exist', 'skipOnError' => true, 'targetClass' => Produtos::class, 'targetAttribute' => ['id_produto' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'desc' => 'Desc',
            'avaliacao' => 'Avaliacao',
            'id_produto' => 'Id Produto',
        ];
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produtos::class, ['id' => 'id_produto']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Profile::class, ['id' => 'id_user']);
    }
}
