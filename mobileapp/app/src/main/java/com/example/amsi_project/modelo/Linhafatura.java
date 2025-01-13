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

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getQuantidade() {
        return quantidade;
    }

    public void setQuantidade(int quantidade) {
        this.quantidade = quantidade;
    }

    public int getFatura_id() {
        return fatura_id;
    }

    public void setFatura_id(int fatura_id) {
        this.fatura_id = fatura_id;
    }

    public int getServico_id() {
        return servico_id;
    }

    public void setServico_id(int servico_id) {
        this.servico_id = servico_id;
    }

    public double getPrecounitario() {
        return precounitario;
    }

    public void setPrecounitario(double precounitario) {
        this.precounitario = precounitario;
    }
}
