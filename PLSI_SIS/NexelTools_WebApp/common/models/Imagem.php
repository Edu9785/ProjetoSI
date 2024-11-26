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

    public $ficheiro;

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
            [['ficheiro'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['ficheiro'], 'required'],
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

    public function upload()
    {
        if ($this->validate()) {

            $pasta = Yii::getAlias('@common') . '/img/';

            $nomeFicheiro = Yii::$app->security->generateRandomString(10) . '.' . $this->ficheiro->extension;
            $caminho = $pasta . $nomeFicheiro;

            if ($this->ficheiro->saveAs($caminho)) {
                $this->imagens = $nomeFicheiro;
                return $this->save();
            }
        }
        return false;
    }
}
