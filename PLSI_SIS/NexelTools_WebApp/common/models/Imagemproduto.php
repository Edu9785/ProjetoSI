<?php

namespace common\models;

use common\models\Imagem;
use common\models\Produto;

/**
 * This is the model class for table "imagensprodutos".
 *
 * @property int $id_produto
 * @property int $id_imagem
 *
 * @property Imagem $imagem
 * @property Produto $produto
 */
class Imagemproduto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagensprodutos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_produto', 'id_imagem'], 'required'],
            [['id_produto', 'id_imagem'], 'integer'],
            [['id_produto', 'id_imagem'], 'unique', 'targetAttribute' => ['id_produto', 'id_imagem']],
            [['id_imagem'], 'exist', 'skipOnError' => true, 'targetClass' => Imagem::class, 'targetAttribute' => ['id_imagem' => 'id']],
            [['id_produto'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['id_produto' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_produto' => 'Id Produto',
            'id_imagem' => 'Id Imagem',
        ];
    }

    /**
     * Gets query for [[Imagem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagem()
    {
        return $this->hasOne(Imagem::class, ['id' => 'id_imagem']);
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'id_produto']);
    }
}
