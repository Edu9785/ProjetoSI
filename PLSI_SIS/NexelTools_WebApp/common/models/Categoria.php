<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categorias".
 *
 * @property int $id
 * @property string $tipo
 *
 * @property Produto[] $produtos
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $imagemCat;

    public static function tableName()
    {
        return 'categorias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo'], 'required'],
            [['tipo'], 'string', 'max' => 45],
            [['id_imagem'], 'integer'],
            [['imagemCat'], 'file', 'checkExtensionByMimeType' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo' => 'Tipo',
            'imagem_id' => 'Imagem'
        ];
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['id_tipo' => 'id']);
    }

    public function getImagem()
    {
        return $this->hasOne(Imagem::class, ['id' => 'id_imagem']);
    }
}
