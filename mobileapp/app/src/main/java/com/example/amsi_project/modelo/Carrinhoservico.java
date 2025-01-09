package com.example.amsi_project.modelo;

public class Carrinhoservico {
    int id,userprofile_id;
    double total;

    public Carrinhoservico(int id, double total, int userprofile_id) {
        this.id = id;
        this.userprofile_id = userprofile_id;
        this.total = total;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getUserprofile_id() {
        return userprofile_id;
    }

    public void setUserprofile_id(int userprofile_id) {
        this.userprofile_id = userprofile_id;
    }

    public double getTotal() {
        return total;
    }

    public void setTotal(double total) {
        this.total = total;
    }
}
