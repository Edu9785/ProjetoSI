<?php

namespace common\models;

use frontend\models\Linhacarrinho;

/**
 * This is the model class for table "produtos".
 *
 * @property int $id
 * @property int $id_vendedor
 * @property string $desc
 * @property float $preco
 * @property int $id_tipo
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

    const DISPONIVEL = 0;
    const EM_PROCESSAMENTO = 1;
    const EM_ENTREGA = 2;
    const ENTREGUE = 3;
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
            [['id_vendedor', 'desc', 'preco', 'id_tipo', 'nome'], 'required'],
            [['id_vendedor', 'id_tipo'], 'integer'],
            [['preco'], 'number', 'min' => 0],
            [['desc'], 'string', 'max' => 445],
            [['nome'], 'string', 'max' => 45],
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
            'nome' => 'Nome',
        ];
    }

    /**
     * Gets query for [[Compras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaCompra()
    {
        return $this->hasMany(Compra::class, ['id_produto' => 'id']);
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
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'id_tipo']);
    }

    /**
     * Gets query for [[Vendedor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['id' => 'id_vendedor']);
    }

    public function getAvaliacao()
    {
        return $this->hasOne(Avaliacao::class, ['id_produto' => 'id']);
    }

}
