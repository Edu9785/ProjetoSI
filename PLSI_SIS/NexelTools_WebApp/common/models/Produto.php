<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "produtos".
 *
 * @property int $id
 * @property int $id_vendedor
 * @property string $desc
 * @property int $id_imagem
 * @property float $preco
 * @property int $id_tipo
 * @property int $id_avaliacao
 *
 * @property Avaliacao $avaliacao
 * @property Compra[] $compras
 * @property Imagens $imagem
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
            [['id_vendedor', 'desc', 'id_imagem', 'preco', 'id_tipo', 'id_avaliacao'], 'required'],
            [['id_vendedor', 'id_imagem', 'id_tipo', 'id_avaliacao'], 'integer'],
            [['preco'], 'number'],
            [['desc'], 'string', 'max' => 45],
            [['id_avaliacao'], 'exist', 'skipOnError' => true, 'targetClass' => Avaliacao::class, 'targetAttribute' => ['id_avaliacao' => 'id']],
            [['id_imagem'], 'exist', 'skipOnError' => true, 'targetClass' => Imagens::class, 'targetAttribute' => ['id_imagem' => 'id']],
            [['id_tipo'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['id_tipo' => 'id']],
            [['id_vendedor'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['id_vendedor' => 'id']],
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
            'id_imagem' => 'Id Imagem',
            'preco' => 'Preco',
            'id_tipo' => 'Id Tipo',
            'id_avaliacao' => 'Id Avaliacao',
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
     * Gets query for [[compra]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompras()
    {
        return $this->hasMany(Compra::class, ['id_produto' => 'id']);
    }

    /**
     * Gets query for [[Imagem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagem()
    {
        return $this->hasOne(Imagens::class, ['id' => 'id_imagem']);
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
