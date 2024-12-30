<?php

namespace common\models;

use frontend\models\Carrinhocompra;
use frontend\models\Favorito;
use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int $nif
 * @property string $morada
 * @property string $nome
 * @property int $id_user
 * @property int $telemovel
 * @property float|null $avaliacao
 *
 * @property Avaliacao[] $avaliacoes
 * @property Carrinhocompra[] $carrinhocompras
 * @property Compra[] $compras
 * @property Fatura[] $faturas
 * @property Favorito[] $favoritos
 * @property Produto[] $produtos
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nif', 'morada', 'nome', 'id_user', 'telemovel'], 'required'],
            [['nif', 'id_user', 'telemovel'], 'integer'],
            [['avaliacao'], 'number'],
            [['morada', 'nome'], 'string', 'max' => 200],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nif' => 'Nif',
            'morada' => 'Morada',
            'nome' => 'Nome',
            'id_user' => 'Id User',
            'telemovel' => 'Telemovel',
            'avaliacao' => 'Avaliacao',
        ];
    }

    /**
     * Gets query for [[Avaliacoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacoes()
    {
        return $this->hasMany(Avaliacao::class, ['id_user' => 'id']);
    }

    /**
     * Gets query for [[Carrinhocompras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhocompras()
    {
        return $this->hasMany(Carrinhocompra::class, ['id_profile' => 'id']);
    }

    /**
     * Gets query for [[Compras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompras()
    {
        return $this->hasMany(Compra::class, ['id_profile' => 'id']);
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Fatura::class, ['id_profile' => 'id']);
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Favorito::class, ['id_user' => 'id']);
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['id_vendedor' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }
}
