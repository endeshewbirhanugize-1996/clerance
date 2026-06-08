<?php
     if(isset($_POST["Submit"])){
     $id=$_POST['ID'];
    $name=$_POST['name'];
    $college=$_POST['college'];
    $dep=$_POST['dep'];
    $pass=$_POST['pass'];
     $gender=$_POST['gender'];
     $program=$_POST['program'];
     $enroll=$_POST['enroll'];
     $Year1=$_POST['Year1'];
    $Semester=$_POST['Semester'];
    $end=$_POST['end'];
    if(empty( $name)&&empty(  $college)&&empty(  $college)&&empty($dep)&&empty($sec)&&empty($pass)
        &&empty($sex)&&empty($program)&&empty( $enroll)&&empty($Year1)){
         echo "please enter full informition"; }
    else{
        
               echo "<tr> 
              <td> $id</td>
               <td>  $name</td>
                <td>$college</td>
                 <td>$dep</td>
                  <td> $pass</td>
                <td> $gender</td>
                <td> $program</td>
                 <td> $enroll</td>
                <td> $Year1</td>
                 <td>$Semester</td>
                <td>$end</td>
               </tr>"."<br>";
             echo "table";
}  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MAU Clearance Form</title>

<style>
body{
    margin: 0;
    padding: 0px;
    height: 170vh;
     display: flex;
    font-family: Arial, Helvetica, sans-serif;
    justify-content: center;
    align-items: center;
 background: #f0f4f8;
}
.box1{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    max-width: px;
    padding: 10px;
    font-size: 1.5em;
    border-radius: 5px;
    outline: none;
 
}
.card{
    width: 90%;
    max-width: 11000px;
  margin-top: 25px;
    color: hsl(60, 11%, 4%);
   background: #ffffff;
   border-radius: 10px;

   
}
.card:focus{
    box-shadow: 0 0 8px rgb(0, 234, 255);
}
.b{
    padding: 10px;
    margin-top: 10px;
    outline: none;
    border-radius: 5px 4px ;
    border: 1px solid;
    text-transform: capitalize ;
    font-weight: bold;
    font-size: 0.7em;
}
.b:focus{
 box-shadow: 0 0  8px rgb(0, 225, 255);
}
.box{
    margin-top: 30px;
    box-shadow: 10px 5px 5px 10px white;
    font-size: 1.5em;
    font-weight: bold;
    font-family: Arial, Helvetica, sans-serif;
   
 
}
.section-title{
    color: rgba(18, 46, 202, 0.537);
      margin-left: 10px;

}
.radio-group{
    margin-top: 10px ;
    padding: 15px;
    box-shadow: 0 4px 5px rgb(239, 239, 248);
     margin-left: 5px;
}
h1{
    text-align: center;
    align-items: center;

    color:  rgba(18, 46, 202, 0.537);
    font-size: 3em;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: bold;
    margin-top: 25px;
} .j {
   font-size: 1.5em; 
}
f{
    width: 250px;
    padding: 10px;
    margin-left: 50%;
    align-items: center;
    margin-bottom: 15px;
    border-radius: 10px;
    color: white;
    font-size: 1.5em;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: bold;
    border: none;
    background-color: aqua;
    cursor: pointer;
}
f:hover{
   background-color: rgb(11, 173, 173);  
}
</style>
</head>

<body>
<div class="card">

    <h1>MAU Student Clearance Form</h1>
<form action="tableOfdatabase.php" method="post">
    <div class="auto-grid">

        <div class="box1">
            <input type="text" placeholder="user ID" class="b" name="ID">
            <input type="text" placeholder="Full Name" class="b" name="name">
            <input type="text" placeholder="College" class="b"   name="college">
            <input type="text" placeholder="Department" class="b" name="dep">
            <input type="password" placeholder="password" class="b" name="pass">
        </div>
        <div class="box">
            <div class="section-title">Gender</div>
            <div class="radio-group">
                <label><input type="radio" name="gender" value="Male"> Male</label>
                <label><input type="radio" name="gender" value="Female"> Female</label>
            </div>
            <div class="section-title" style="margin-top:15px;">Program Type</div>
            <div class="radio-group">
                <label><input type="radio" name="program" value="Postgraduate" checked> Postgraduate</label>
                <label><input type="radio" name="program" value=" Graduate"> Graduate</label>
                <label><input type="radio" name="program"  value="Postgraduate Diploma"> Postgraduate Diploma</label>
                <label><input type="radio" name="program"  value=" Undergraduate"> Undergraduate</label>
            </div>
        </div>
        <div class="box">
            <div class="section-title">Enrollment Type</div>
            <div class="radio-group">
                <label><input type="radio" name="enroll" value="Regular Full Time"> Regular Full Time</label>
                <label><input type="radio" name="enroll"  value="Regular Part Time"> Regular Part Time</label>
                <label><input type="radio" name="enroll"  value=" Extension"> Extension</label>
                <label><input type="radio" name="enroll"   value="Summer"> Summer</label>
                <label><input type="radio" name="enroll"    value=" Distance Education"> Distance Education</label>
            </div>
        </div>

        <div class="box" id="c">
            <div class="section-title" style="height: 10vh; margin-top: 10px;">Class Year</div>
            <select  name="Year1" style="width: 500px; padding: 5px ;font: 0.7em sans-serif;  margin-left: 25px;
            border: 1px solid; outline: none; border-radius: 5px;
          font-family: Arial, Helvetica, sans-serif;font-weight: bold;margin-bottom:20px; " >
                <option  value="1 Year" selected>1 Year</option>
                <option   value="2 Year">2 Year</option>
                <option   value="3 Year">3 Year</option>
                <option   value="4 Year">4 Year</option>
                <option   value="5 Year">5 Year</option>
                <option   value="6 Year">6 Year</option>
                <option  value="7 Year">7 Year</option>
            </select>
            <select   name="Semester" style="width: 500px; padding: 5px ;font: 0.7em sans-serif; margin-left: 10px;
            border: 1px solid; outline: none; border-radius: 5px;
           margin-left: 0; " >
                <option   value="1st Semester" >1st Semester</option>
                <option   value="2nd Semester" selected>2nd Semester</option>
            </select>
        </div>

        <div class="box" style="grid-column: 1 / -1;">
            <div class="section-title">Reason for Clearance</div>
            <select  name="end"  style=" width: 500px; padding: 5px ;font: 0.7em sans-serif; margin-left: 10px;
            border: 1px solid; outline: none; border-radius: 5px;
            margin-left: 15px; margin-top: 30px; font-family: Arial, Helvetica, sans-serif;
            font-weight: bold; text-transform: capitalize;">
                <option class="j"  value="End of Academic Year" >End of Academic Year</option>
                <option class="j"  value="Disciplinary Case" selected>Disciplinary Case</option>
                <option class="j"   value="Forced Withdrawal">Forced Withdrawal</option>
                <option class="j"   value="Withdrawal Due to Health/Family Problem">Withdrawal Due to Health/Family Problem</option>
                <option class="j"  value="Academic Dismissal">Academic Dismissal</option>
                <option class="j"  value="Graduation">Graduation</option>
                <option class="j"   value="ID Replacement">ID Replacement</option>
            </select>
        </div>
          <input type="submit" value="Submit" name="Submit" class="f">
    </div>
</form>
</div>
</body>
</html>