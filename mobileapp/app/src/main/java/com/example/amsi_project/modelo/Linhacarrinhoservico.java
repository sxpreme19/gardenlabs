package com.example.amsi_project.modelo;

public class Linhacarrinhoservico {
    int id,carrinhoservico_id,servico_id;
    double preco;

    public Linhacarrinhoservico(int id, double preco, int carrinhoservico_id, int servico_id) {
        this.id = id;
        this.carrinhoservico_id = carrinhoservico_id;
        this.servico_id = servico_id;
        this.preco = preco;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getCarrinhoservico_id() {
        return carrinhoservico_id;
    }

    public void setCarrinhoservico_id(int carrinhoservico_id) {
        this.carrinhoservico_id = carrinhoservico_id;
    }

    public int getServico_id() {
        return servico_id;
    }

    public void setServico_id(int servico_id) {
        this.servico_id = servico_id;
    }

    public double getPreco() {
        return preco;
    }

    public void setPreco(double preco) {
        this.preco = preco;
    }
}
