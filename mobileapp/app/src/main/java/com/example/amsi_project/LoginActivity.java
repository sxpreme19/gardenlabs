package com.example.amsi_project;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;

import androidx.activity.EdgeToEdge;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.amsi_project.listeners.LoginListener;
import com.example.amsi_project.listeners.ResetPasswordListener;
import com.example.amsi_project.modelo.BDHelper;
import com.example.amsi_project.modelo.SingletonGardenLabsManager;

public class LoginActivity extends AppCompatActivity implements LoginListener {

    private EditText etUsername, etPassword;
    public static final  int MIN_PASS=8;
    public BDHelper BD = null;
    private String apihost = "10.0.2.2";

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

        SharedPreferences sharedPreferences = getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
        apihost = sharedPreferences.getString("apihost", "10.0.2.2");
        Log.d("DEBUG", "API Host from SharedPreferences: " + apihost);


        SingletonGardenLabsManager.getInstance(getApplicationContext()).setLoginListener(this);
        SingletonGardenLabsManager.getInstance(getApplicationContext()).getUsersAPI(this);

        etUsername=findViewById(R.id.etUsername);
        etPassword=findViewById(R.id.etPassword);
    }

    @Override
    public void onUpdateLogin(int id,String token,String username,String email,int profileid,int servicecartid) {
        //Guardar o token da shared preferences
        //Intent para o MenuMainActivity

        SharedPreferences sharedPreferences = getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);

        // Guardar o token
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putInt("id", id);
        editor.putString("token", token);
        editor.putString("username", username);
        editor.putString("email", email);
        editor.putInt("profileid", profileid);
        editor.putInt("servicecartid", servicecartid);
        editor.apply(); // Salvar as mudanças

        // Redirecionar para MenuMainActivity
        Intent intent = new Intent(this, MenuMainActivity.class);
        startActivity(intent);

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

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        if(apihost!=null) {
            getMenuInflater().inflate(R.menu.menu_api,menu);
            return super.onCreateOptionsMenu(menu);
        }
        return false;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        if(item.getItemId()==R.id.itemAPIHost) {
            showAPIDialog();
        }
        return false;
    }

    private void showAPIDialog() {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle("API Host Config");

        final EditText input = new EditText(this);
        input.setHint(apihost);
        builder.setView(input);

        builder.setPositiveButton("Submit", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int id) {
                String apiText = input.getText().toString();
                apihost = apiText;
                SharedPreferences sharedPreferences = getSharedPreferences("AppPreferences", Context.MODE_PRIVATE);
                SharedPreferences.Editor editor = sharedPreferences.edit();
                editor.putString("apihost", apihost);
                editor.apply();
            }
        });
        builder.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int id) {
                dialog.cancel();
            }
        });

        builder.create().show();
    }
}