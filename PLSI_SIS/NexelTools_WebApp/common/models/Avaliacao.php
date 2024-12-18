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
 * @property Produto $produto
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
            [['desc'], 'string', 'max' => 355],
            [['id_produto'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['id_produto' => 'id']],
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
        return $this->hasOne(Produto::class, ['id' => 'id_produto']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['id' => 'id_user']);
    }

    public static function mediaAvaliacao($id_vendedor){

        $produtosVendedor = Produto::find()->where(['id_vendedor' => $id_vendedor])->all();

        $somaAvaliacoes = 0;
        $totalAvaliacoes = 0;

        foreach ($produtosVendedor as $produto){
            $avaliacaoProduto = Avaliacao::find()->where(['id_produto' => $produto->id])->one();

            if($avaliacaoProduto){
                $somaAvaliacoes += $avaliacaoProduto->avaliacao;
                $totalAvaliacoes++;
            }
        }

        $mediaAvaliacoes = $somaAvaliacoes / $totalAvaliacoes;
        return $mediaAvaliacoes;
    }
}
