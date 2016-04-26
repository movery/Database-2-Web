package movery.dbviewer;

import java.util.ArrayList;
import org.json.JSONArray;
import org.json.JSONObject;
import android.os.AsyncTask;
import android.os.Bundle;
import android.app.Activity;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;

import android.widget.AutoCompleteTextView;
import android.widget.TextView;

public class MainActivity extends Activity {
    JSONObject jsonobject;
    JSONArray jsonarray;
    ArrayList<String> studentlist;
    ArrayList<Student> students;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        new DownloadJSON().execute();
    }

    private class DownloadJSON extends AsyncTask<Void, Void, Void> {

        @Override
        protected Void doInBackground(Void... params) {
            students = new ArrayList<Student>();
            studentlist = new ArrayList<String>();

            try {
                jsonobject = JSONfunctions.readJsonFromUrl("http://54.191.203.114/moveryDBProject/studentInfo.json");

                jsonarray = jsonobject.getJSONArray("Students");
                for (int i = 0; i < jsonarray.length(); i++) {
                    jsonobject = jsonarray.getJSONObject(i);

                    Student S = new Student();

                    S.setSID(jsonobject.optString("SID"));
                    S.setName(jsonobject.optString("name"));
                    S.setAdviser(jsonobject.optString("adviser"));
                    S.setMajor(jsonobject.optString("major"));
                    S.setDegreeHeld(jsonobject.optString("degree"));
                    S.setCareer(jsonobject.optString("career"));
                    S.setGPA(jsonobject.optString("GPA"));
                    S.setGradStrings(jsonobject.optString("GradStatus"));
                    students.add(S);

                    studentlist.add(S.getSID() + " - " + S.getName());

                }
            } catch (Exception e) {
                Log.e("Error", e.getMessage());
                e.printStackTrace();
            }
            return null;
        }

        @Override
        protected void onPostExecute(Void args) {

            AutoCompleteTextView acTextView = (AutoCompleteTextView) findViewById(R.id.autoComplete);
            ArrayAdapter<String> adapter = new ArrayAdapter<String>(MainActivity.this, android.R.layout.simple_dropdown_item_1line, studentlist);
            acTextView.setAdapter(adapter);

            acTextView.setOnItemClickListener(new AdapterView.OnItemClickListener() {

                @Override
                public void onItemClick(AdapterView<?> parent, View arg1, int position, long id) {
                    TextView txtSID = (TextView) findViewById(R.id.SID);
                    TextView txtName = (TextView) findViewById(R.id.Name);
                    TextView txtAdviser = (TextView) findViewById(R.id.Adviser);
                    TextView txtMajor = (TextView) findViewById(R.id.Major);
                    TextView txtDegreeHeld = (TextView) findViewById(R.id.DegreeHeld);
                    TextView txtCareer = (TextView) findViewById(R.id.Career);
                    TextView txtGPA = (TextView) findViewById(R.id.GPA);
                    TextView txtGradString = (TextView) findViewById(R.id.GradString);

                    String selection = (String)parent.getItemAtPosition(position);

                    txtSID.setText(students.get(studentlist.indexOf(selection)).getSID());
                    txtName.setText(students.get(studentlist.indexOf(selection)).getName());
                    txtAdviser.setText(students.get(studentlist.indexOf(selection)).getAdviser());
                    txtMajor.setText(students.get(studentlist.indexOf(selection)).getMajor());
                    txtDegreeHeld.setText(students.get(studentlist.indexOf(selection)).getDegreeHeld());
                    txtCareer.setText(students.get(studentlist.indexOf(selection)).getCareer());
                    txtGPA.setText(students.get(studentlist.indexOf(selection)).getGPA());
                    txtGradString.setText(students.get(studentlist.indexOf(selection)).getGradStrings());
                }
            });
        }
    }
}