<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "imagens".
 *
 * @property int $id
 * @property resource $imagens
 *
 * @property Produto[] $produtos
 */
class Imagem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */


    public static function tableName()
    {
        return 'imagens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imagens'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imagens' => 'Imagens',
        ];
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['id' => 'id_produto'])
            ->viaTable('imagensprodutos', ['id_imagem' => 'id']);
    }

    public function getCategorias()
    {
        return $this->hasMany(Categoria::class, ['id_imagem' => 'id']);
    }

}
