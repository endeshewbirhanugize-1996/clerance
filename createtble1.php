<?php
if (!isset($_SESSION["logined"]) || $_SESSION["logined"] !== true) {
    header("Location: login.php");
    exit;
}
include("database.php");
$queries = [];
/* student_table */
$queries[] = "
CREATE TABLE student_table (
    stu_id VARCHAR(100) PRIMARY KEY,
    Full_name VARCHAR(100),
    College VARCHAR(100),
    depa_name VARCHAR(100),
    password VARCHAR(1000),
    sex VARCHAR(45),
    Program_type VARCHAR(45),
    Enrolment_type VARCHAR(100),
    Class_year VARCHAR(100),
    Semester VARCHAR(100),
    Reason_of_clearance VARCHAR(100)
)";
/* mekdela_amba_info */
$queries[] = "
CREATE TABLE mekdela_amba_info (
    user_id VARCHAR(45) PRIMARY KEY,
    Full_name VARCHAR(100),
    age INT,
    email VARCHAR(100),
    password VARCHAR(10000),
    phone VARCHAR(100),
    User_role VARCHAR(100),
    sex VARCHAR(45)
)";
/* status_table */
$queries[] = "
CREATE TABLE status_table (
    stat_id VARCHAR(100) PRIMARY KEY,
    stut_department VARCHAR(100),
    Stut_Full_name VARCHAR(100),
    password VARCHAR(100)
)";
/* enrolment_form */
$queries[] = "
CREATE TABLE enrolment_form (
    user_id VARCHAR(45),
    Full_name VARCHAR(100),
    stat_id VARCHAR(100),
    Class1_year VARCHAR(100),
    CONSTRAINT fk_enrol_user
        FOREIGN KEY (user_id) REFERENCES mekdela_amba_info(user_id),
    CONSTRAINT fk_enrol_status
        FOREIGN KEY (stat_id) REFERENCES status_table(stat_id)
)";
/* case_table */
$queries[] = "
CREATE TABLE case_table (
    user_id VARCHAR(45),
    Full_name VARCHAR(100),
    stat_id VARCHAR(100),
    Class1_year VARCHAR(100),
    CONSTRAINT fk_case_user
        FOREIGN KEY (user_id) REFERENCES mekdela_amba_info(user_id),
    CONSTRAINT fk_case_status
        FOREIGN KEY (stat_id) REFERENCES status_table(stat_id)
)";
/* Execute queries */
try {
    foreach ($queries as $sql) {
        if (!mysqli_query($conn, $sql)) {
            throw new Exception(mysqli_error($conn));
        }
    }
    echo "All tables created successfully";
} catch (Exception $e) {
    echo "Failed: " . $e->getMessage();
}
?>
