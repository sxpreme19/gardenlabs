package com.example.amsi_project;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.appcompat.widget.Toolbar;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import com.google.android.material.navigation.NavigationView;

public class MenuMainActivity extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener {

    private NavigationView navigationView;
    private DrawerLayout drawer;
    private String username;
    private FragmentManager fragmentManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu_main);

        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        drawer = findViewById(R.id.drawerLayout);
        navigationView = findViewById(R.id.navView);


        ActionBarDrawerToggle toogle = new ActionBarDrawerToggle(this,drawer, toolbar, R.string.ndOpen, R.string.ndClose);
        toogle.syncState();
        drawer.addDrawerListener(toogle);

        carregarCabecalho();

        navigationView.setNavigationItemSelectedListener(this);
        fragmentManager=getSupportFragmentManager();

        CarregarFragmentoInicial();
    }

    private boolean CarregarFragmentoInicial() {
        Menu menu = navigationView.getMenu();
        MenuItem item = menu.getItem(0);
        item.setChecked(true);

        return onNavigationItemSelected(item);
    }

    private void carregarCabecalho() {

        SharedPreferences sharedPrefUser = getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);

        username = sharedPrefUser.getString("username", "");

        View hView = navigationView.getHeaderView(0);
        TextView tvEmail = hView.findViewById(R.id.tvEmail);
        tvEmail.setText(username);

    }

    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem item) {
        Fragment fragment = null;
        if (item.getItemId()==R.id.navServices) {
            setTitle(item.getTitle());
            fragment = new ListaServicosFragment();
        }
        else if (item.getItemId()==R.id.navCarrinho) {
            setTitle(item.getTitle());
        }
        else {
            enviarEmail();
        }

        if (fragment!=null)
            fragmentManager.beginTransaction().replace(R.id.contentFragment,fragment).commit();

        drawer.closeDrawer(GravityCompat.START);

        return true;
    }

    private void enviarEmail() {
        //TODO
    }
}