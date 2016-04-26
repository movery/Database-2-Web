package movery.dbviewer;

public class Student {
    private String SID;
    private String name;
    private String adviser;
    private String major;
    private String degreeHeld;
    private String career;
    private String GPA;
    private String gradStrings;

    public String getSID() {
        return SID;
    }

    public void setSID(String SID) {
        this.SID = SID;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getAdviser() {
        return adviser;
    }

    public void setAdviser(String adviser) {
        this.adviser = adviser;
    }

    public String getMajor() {
        return major;
    }

    public void setMajor(String major) {
        this.major = major;
    }

    public String getDegreeHeld() {
        return degreeHeld;
    }

    public void setDegreeHeld(String degreeHeld) {
        this.degreeHeld = degreeHeld;
    }

    public String getCareer() {
        return career;
    }

    public void setCareer(String career) {
        this.career = career;
    }

    public String getGPA() {
        return GPA;
    }

    public void setGPA(String GPA) {
        this.GPA = GPA;
    }

    public String getGradStrings() { return gradStrings; }

    public void setGradStrings(String gradStrings) { this.gradStrings = gradStrings; }

}
