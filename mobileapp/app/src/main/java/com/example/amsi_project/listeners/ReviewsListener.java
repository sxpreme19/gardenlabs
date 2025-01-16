package com.example.amsi_project.listeners;

import com.example.amsi_project.modelo.Review;

import java.util.ArrayList;

public interface ReviewsListener {
    void onRefreshListaReviews(ArrayList<Review> listReviews);
}
