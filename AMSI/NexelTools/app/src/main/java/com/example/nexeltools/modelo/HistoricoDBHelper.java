package com.example.nexeltools.modelo;

import static android.content.ContentValues.TAG;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

import androidx.annotation.Nullable;

import java.text.SimpleDateFormat;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.Locale;

public class HistoricoDBHelper extends SQLiteOpenHelper {

    //nome da base de dados
    private static final String DB_NAME="bdhistorico";
    //nome da(s) tabela(s)
    private static final String Historico ="Historico";
    //nome da(s) colunas da tabela livros
    private static final String ID="id", PRECOTOTAL = "precototal", METODOEXPEDICAO = "metodoexpedicao", METODOPAGAMENTO = "metodopagamento", DATACOMPRA = "datacompra", ID_PROFILE = "id_profile";

    private final SQLiteDatabase db;


    public HistoricoDBHelper(@Nullable Context context) {
        super(context, DB_NAME, null, 1);
        this.db = getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        String sqlCriarTabela = "CREATE TABLE " + Historico +"("
                +ID + " Integer PRIMARY KEY, "
                +PRECOTOTAL + " Double NOT NULL, "
                +METODOEXPEDICAO + " TEXT NOT NULL, "
                +METODOPAGAMENTO + " TEXT NOT NULL, "
                +DATACOMPRA + " DATETIME NOT NULL,"
                +ID_PROFILE + " Integer NOT NULL"
                +");";
        sqLiteDatabase.execSQL(sqlCriarTabela);
    }

    @Override
    public void onUpgrade(SQLiteDatabase sqLiteDatabase, int i, int i1) {
        String sqlDelTabela = "DROP TABLE IF EXISTS " + Historico;
        sqLiteDatabase.execSQL(sqlDelTabela);
        onCreate(sqLiteDatabase);
    }


    public Compra adicionarHistorico(Compra c){

        ContentValues values = new ContentValues();
        values.put(ID, c.id);
        values.put(PRECOTOTAL, c.precototal);
        values.put(METODOEXPEDICAO, c.metodoexpedicao);
        values.put(METODOPAGAMENTO, c.metodopagamento);
        values.put(DATACOMPRA, c.datacompra);
        values.put(ID_PROFILE, c.id_profile);

        this.db.insert(Historico, null, values);

        return null;
    }

    public ArrayList<Compra> getComprasProfile(int id){
        ArrayList<Compra> compras = new ArrayList<>();

        Cursor cursor = this.db.query(Historico, new String[]{ID, PRECOTOTAL, DATACOMPRA}, " id_profile = " + id, null, null, null, null);
        if(cursor.moveToFirst()){
            do{
                int idcompra = cursor.getInt(0);
                double precototal = cursor.getDouble(1);
                String datacompra = cursor.getString(2);
                Compra auxCompra = new Compra(idcompra, precototal, null, null, datacompra, id, null);
                compras.add(auxCompra);
            }while(cursor.moveToNext());
            cursor.close();
        }
        return compras;
    }

    public int compraExiste(int idCompra) {
        SQLiteDatabase db = this.getReadableDatabase();
        Log.d("ID DA COMPRA", idCompra + "");
        String query = "SELECT * FROM Historico WHERE id = ?";
        Cursor cursor = db.rawQuery(query, new String[]{String.valueOf(idCompra)});

        cursor.moveToFirst();
        int existe = cursor.getCount();
        cursor.close();
        return existe;
    }
}

