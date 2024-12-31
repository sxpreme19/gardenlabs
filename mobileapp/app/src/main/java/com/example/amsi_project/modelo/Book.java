package com.example.amsi_project.modelo;

public class Servico {
    private int id,duracao, prestador_id;
    private String titulo, descricao;
    private double preco;


    public Servico(int id, String titulo, String descricao, int duracao,double preco, int prestador_id) {
        this.id = id;
        this.titulo = titulo;
        this.descricao = descricao;
        this.duracao = duracao;
        this.prestador_id = prestador_id;
        this.preco = preco;
    }

    // Getters and Setters for the fields

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getDuracao() {
        return duracao;
    }

    public void setDuracao(int duracao) {
        this.duracao = duracao;
    }

    public int getPrestador_id() {
        return prestador_id;
    }

    public void setPrestador_id(int prestador_id) {
        this.prestador_id = prestador_id;
    }

    public String getTitulo() {
        return titulo;
    }

    public void setTitulo(String titulo) {
        this.titulo = titulo;
    }

    public String getDescricao() {
        return descricao;
    }

    public void setDescricao(String descricao) {
        this.descricao = descricao;
    }

    public double getPreco() {
        return preco;
    }

    public void setPreco(double preco) {
        this.preco = preco;
    }
}
