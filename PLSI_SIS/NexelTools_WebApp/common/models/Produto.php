<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "produtos".
 *
 * @property int $id
 * @property int $id_vendedor
 * @property string $desc
 * @property float $preco
 * @property int $id_tipo
 * @property int $id_avaliacao
 * @property string $nome
 *
 * @property Avaliacao $avaliacao
 * @property Compra[] $compra
 * @property Imagem[] $imagem
 * @property Imagemproduto[] $imagemproduto
 * @property Linhacarrinho[] $linhacarrinhos
 * @property Linhafatura[] $linhafaturas
 * @property Categoria $tipo
 * @property Profile $vendedor
 */

class Produto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $imagens;
    public static function tableName()
    {
        return 'produtos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_vendedor', 'desc', 'preco', 'id_tipo', 'id_avaliacao', 'nome'], 'required'],
            [['id_vendedor', 'id_tipo', 'id_avaliacao'], 'integer'],
            [['preco'], 'number'],
            [['desc'], 'string', 'max' => 445],
            [['nome'], 'string', 'max' => 45],
            [['id_avaliacao'], 'exist', 'skipOnError' => true, 'targetClass' => Avaliacao::class, 'targetAttribute' => ['id_avaliacao' => 'id']],
            [['id_tipo'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['id_tipo' => 'id']],
            [['id_vendedor'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['id_vendedor' => 'id']],
            [['imagens'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, jpeg', 'maxFiles' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_vendedor' => 'Id Vendedor',
            'desc' => 'Desc',
            'preco' => 'Preco',
            'id_tipo' => 'Id Tipo',
            'id_avaliacao' => 'Id Avaliacao',
            'nome' => 'Nome',
        ];
    }

    /**
     * Gets query for [[Avaliacao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacao()
    {
        return $this->hasOne(Avaliacao::class, ['id' => 'id_avaliacao']);
    }

    /**
     * Gets query for [[Compras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompras()
    {
        return $this->hasMany(Compra::class, ['id_produto' => 'id']);
    }

    /**
     * Gets query for [[Imagems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagems()
    {
        return $this->hasMany(Imagem::class, ['id' => 'id_imagem'])->viaTable('imagensprodutos', ['id_produto' => 'id']);
    }

    /**
     * Gets query for [[Imagensprodutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagensprodutos()
    {
        return $this->hasMany(Imagemproduto::class, ['id_produto' => 'id']);
    }

    /**
     * Gets query for [[Linhacarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacarrinhos()
    {
        return $this->hasMany(Linhacarrinho::class, ['id_produto' => 'id']);
    }

    /**
     * Gets query for [[Linhafaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafaturas()
    {
        return $this->hasMany(Linhafatura::class, ['id_produto' => 'id']);
    }

    /**
     * Gets query for [[Tipo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(Categoria::class, ['id' => 'id_tipo']);
    }

    /**
     * Gets query for [[Vendedor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVendedor()
    {
        return $this->hasOne(Profile::class, ['id' => 'id_vendedor']);
    }
}
