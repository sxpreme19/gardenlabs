package com.example.amsi_project;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.amsi_project.listeners.LoginListener;
import com.example.amsi_project.listeners.ResetPasswordListener;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

public class LoginActivity extends AppCompatActivity implements LoginListener {

    private EditText etUsername, etPassword;
    public static final  int MIN_PASS=8;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_login);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        SingletonGardenLabsManager.getInstance(getApplicationContext()).setLoginListener(this);

        etUsername=findViewById(R.id.etUsername);
        etPassword=findViewById(R.id.etPassword);
    }

    public void onClickLogin(View view) {
        String username = etUsername.getText().toString();
        String passwrd = etPassword.getText().toString();

        if(!isUsernameValid(username)){
            etUsername.setError(getString(R.string.txt_username_inval));
            return;
        }

        if (!isPasswrdValid(passwrd)) {
            etPassword.setError(getString(R.string.txt_ncaracteres_insuf));
            return;
        }

        SingletonGardenLabsManager.getInstance(getApplicationContext()).loginAPI(getApplicationContext(),username, passwrd);
        //Toast.makeText(this, getString(R.string.txt_login_sucess), Toast.LENGTH_SHORT).show();
        //Intent intent = new Intent(this, MainActivity.class);
        //Intent intent = new Intent(this, MenuMainActivity.class);
        //intent.putExtra(LoginActivity.EMAIL, email);
        //startActivity(intent);
        //finish();
    }

    @Override
    public void onUpdateLogin(int id,String token,String username,int profileid,int servicecartid) {
        //Guardar o token da shared preferences
        //Intent para o MenuMainActivity

        SharedPreferences sharedPreferences = getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);

        // Guardar o token
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putInt("id", id);
        editor.putString("token", token);
        editor.putString("username", username);
        editor.putInt("profileid", profileid);
        editor.putInt("servicecartid", servicecartid);
        editor.apply(); // Salvar as mudanças

        // Redirecionar para MenuMainActivity
        Intent intent = new Intent(this, MenuMainActivity.class);
        startActivity(intent);

    }

    public void onClickRegisterLink(View view) {
        Intent intent = new Intent(this, RegisterActivity.class);
        startActivity(intent);
    }

    public void onClickResetPassword(View view) {
        Intent intent = new Intent(this, ResetPasswordActivity.class);
        startActivity(intent);
    }

    public boolean isUsernameValid(String username) {
        if (username==null)
            return false;
        return !username.isEmpty();
    }

    public boolean isPasswrdValid(String passwrd) {
        if (passwrd==null)
            return false;

        return passwrd.length()>=MIN_PASS;
    }
}