package com.example.amsi_project;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentActivity;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;

import com.example.amsi_project.listeners.HomeListener;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;
import com.google.android.material.floatingactionbutton.FloatingActionButton;


public class HomeFragment extends Fragment implements HomeListener {

    TextView serviceCount;
    Button btnGoToServices;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_home, container, false);

        serviceCount = view.findViewById(R.id.tvSubtitle);

        SingletonGardenLabsManager.getInstance(getContext()).setHomeListener(this);
        SingletonGardenLabsManager.getInstance(getContext()).getServiceCountAPI(getContext());

        return view;
    }

    @Override
    public void onRefreshHome(int n) {
        serviceCount.setText("Explore our " + n + " services!");
    }
}