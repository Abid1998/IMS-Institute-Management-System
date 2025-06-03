<?php

class Model{
    protected $connection="";
    protected $servername="localhost";
    protected $username="root";
    protected $password="";
    protected $db="IMS";

    function __construct(){
        mysqli_report(MYSQLI_REPORT_STRICT);
        try{
            $this->connection=new mysqli($this->servername,$this->username, $this->password,$this->db);
        }
        catch(Exception $ex){
            echo "Connection failed".$ex->getMessage();
            exit;
        }
    }
  
    //Insert data function
    function InsertData($tbl, $data){
        // Check if email already exists
        if(!empty($email)){
            $email = $data['email']; // Assuming the email key is 'email'
            $checkSql = "SELECT * FROM $tbl WHERE email = '$email'";
            $checkEx = $this->connection->query($checkSql);
            if ($checkEx->num_rows > 0) {
                $response['Data'] = null;
                $response['Code'] = false;
                $response['Message'] = 'Duplicate Email ID!';
                exit;
            }
        }

            // Prepare columns and values for insertion
            $clms = implode(',', array_keys($data));
            $vals = implode("','", array_map([$this->connection, 'real_escape_string'], array_values($data)));
            
            // Construct the SQL insert statement
            $sql = "INSERT INTO $tbl ($clms) VALUES ('$vals')";
            $insertEx = $this->connection->query($sql);
            
            
            if ($insertEx) {
                $response['Data'] = null;
                $response['Code'] = true;
                $response['Message'] = 'Inserted Successfully!';
            } else {
                $response['Data'] = null;
                $response['Code'] = false;
                $response['Message'] = 'Insertion Failed!';
            }
    
        return $response;
    }

  //Select data function
    function SelectData($tblName, array $where = []){
        $selectSql = "SELECT * FROM $tblName";
        if (!empty($where)) {
            $selectSql .= " WHERE ";
            foreach ($where as $key => $value) {
                $selectSql .= "$key = '$value' AND";
            }
            $selectSql = rtrim($selectSql, 'AND');
        }

        // Execute the query
        $sqlEx = $this->connection->query($selectSql);
        if ($sqlEx->num_rows > 0) {
            while ($FetchData = $sqlEx->fetch_object()) {
                $allData[] = $FetchData;
            }
            $response['Data'] = $allData;
            $response['Code'] = true;
            $response['Message'] = 'Data retrieved successfully!';
        }
        else{
            $response['Data'] = [];
            $response['Code'] = false;
            $response['Message'] = 'Data not retrieved!';
        }
        return $response;
    }
    
    function getInvoicedata($where){
        $CenterName=$where['center_name'];
        
        if($CenterName=='Adhartal' || $CenterName=='Rampur' || $CenterName=='Belkhadu'){
        $sql="SELECT a.*, SUM(b.amount) AS totalPay FROM students AS a INNER JOIN receipt AS b ON a.role_number = b.role_number LEFT JOIN users AS u ON u.center_name = a.center_name where a.center_name='$CenterName' GROUP BY a.role_number";
        }
     if($CenterName=='All'){
            $sql="SELECT a.*, SUM(b.amount) AS totalPay FROM students AS a INNER JOIN receipt AS b ON a.role_number = b.role_number LEFT JOIN users AS u ON u.center_name = a.center_name  GROUP BY a.role_number";
        }

 
       
        $sqlEx = $this->connection->query($sql);

        if ($sqlEx->num_rows > 0) {
            while ($FetchData = $sqlEx->fetch_object()) {
                $allData[] = $FetchData;
            }
            $response['Data'] = $allData;
            $response['Code'] = true;
            $response['Message'] = 'Data retrieved successfully!';
        }
        else{
            $response['Data'] = [];
            $response['Code'] = false;
            $response['Message'] = 'Data not retrieved!';
        }
        return $response;
    }
    
    //Update data function
    function updateData($tbl, $data, $where) {
        $update = "UPDATE $tbl SET ";
        $updateValues = "";
      
        foreach ($data as $key => $value) {
          $updateValues .= " $key = '$value',";
        }
      
        $update .= rtrim($updateValues, ',');
        $update .= " WHERE ";
        $whereClause = "";
        foreach ($where as $key => $value) {
          $whereClause .= " $key = '$value' AND";
        }
        $update .= rtrim($whereClause, ' AND');
        $updateEx = $this->connection->query($update);
        if ($updateEx) {
          $response['Data'] = null;
          $response['Code'] = true;
          $response['Message'] = 'Updated Successfully!';
        } else {
          $response['Data'] = null;
          $response['Code'] = false;
          $response['Message'] = 'Update Failed!';
        }
      
        return $response;
      }

    //Delete data function
    function deleteData($tbl, $where) {
        $deleteSql = "DELETE FROM $tbl WHERE";
        foreach($where as $Key => $value){
            $deleteSql .=" $Key ='$value'";
        }
        $deleteEx = $this->connection->query($deleteSql);
          if ($deleteEx) {
            $response['Data'] = null;
            $response['Code'] = true;
            $response['Message'] = 'Updated Successfully!';
          } else {
            $response['Data'] = null;
            $response['Code'] = false;
            $response['Message'] = 'Update Failed!';
          }
          return $response;
        }
      
    //Login Function
    function LoginData($email, $password) {
        // Escape the email input to prevent SQL injection
        $email = $this->connection->real_escape_string($email);
    
        // Prepare the SQL statement
        $loginSql = "SELECT * FROM users WHERE email = '$email'";
        $loginEx = $this->connection->query($loginSql);
        
        if($loginEx->num_rows > 0) {
            $user = $loginEx->fetch_assoc();
            // Verify the password
            if (password_verify($password, $user['password'])) {
                $response['Data'] = $user;
                $response['Code'] = true;
                $response['Message'] = 'Login Successful!';
            } else {
                $response['Data'] = null;
                $response['Code'] = false;
                $response['Message'] = 'Login Failed - Email or Password Incorrect!';
            }
        } else {
            $response['Data'] = null;
            $response['Code'] = false;
            $response['Message'] = 'Login Failed - Email or Password Incorrect!';
        }
    
        return $response;
    }    


    // validation function remove white space and / % f
    public function htmlValidation($form_data) {
        $form_data=trim(stripcslashes(htmlspecialchars($form_data)));
        $form_data = mysqli_real_escape_string($this->connection, $form_data);
        return $form_data;
    }
}
?>