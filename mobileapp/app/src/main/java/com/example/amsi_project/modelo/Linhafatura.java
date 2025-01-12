package com.example.amsi_project.modelo;

public class Linhafatura {
    int id,quantidade,fatura_id,servico_id;
    double precounitario;

    public Linhafatura(int id,int quantidade, double precounitario, int fatura_id, int servico_id) {
        this.id = id;
        this.fatura_id = fatura_id;
        this.servico_id = servico_id;
        this.precounitario = precounitario;
        this.quantidade = quantidade;
    }
}
