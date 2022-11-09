<?php

class User
{
    private $connection;

    function __construct()
    {
        include_once('../database/db.php');
        $db = new Database();
        $this->connection = $db->connect();
    }

    private function userAlreadyExists($email)
    {
        $pre_stmt = $this->connection->prepare("SELECT id from user WHERE email = ?");
        $pre_stmt->bind_param('s', $email);
        $pre_stmt->execute() or die($this->connection->error);
        $result = $pre_stmt->get_result();
        if ($result->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function createUserAccount($username, $email, $password, $role)
    {
        if ($this->userAlreadyExists($email)) {
            return "EMAIL ADDRESS ALREADY EXISTS";
        } else {
            $date = date("Y-m-d");
            $hasedPassword = password_hash($password, PASSWORD_BCRYPT, ["cost" => 8]);
            $notes = "";
            $pre_stmt = $this->connection->prepare("INSERT INTO `user` (`username`, `email`, `password`, `role`, `last_login`, `register_date`, `notes`)
            Values (?,?,?,?,?,?,?) ");
            $pre_stmt->bind_param('sssssss', $username, $email, $hasedPassword, $role, $date, $date, $notes);
            $result = $pre_stmt->execute() or die($this->connection->error);
            if ($result) {
                return $this->connection->insert_id;
            } else {
                return "Something Went Wrong";
            }
        }
    }

    public function userLogin($email, $password)
    {
        $pre_stmt = $this->connection->prepare("SELECT id,username, password ,last_login FROM user WHERE email = ?");
        $pre_stmt->bind_param('s', $email);
        $pre_stmt->execute() or die($this->connection->error);
        $result = $pre_stmt->get_result();
        echo $result->num_rows;
        if ($result->num_rows < 1) {
            return "Email Address is Not Registered";
        } else {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                $_SESSION["userid"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["last_login"] = $row["last_login"];
                //Here we are updating user last login time when he is performing login
                $last_login = date("Y-m-d h:m:s");
                $pre_stmt = $this->connection->prepare("UPDATE user SET last_login = ? WHERE email = ?");
                $pre_stmt->bind_param("ss", $last_login, $email);
                $result = $pre_stmt->execute() or die($this->connection->error);
                if ($result) {
                    return "Logged in";
                } else {
                    return 0;
                }
            } else {
                return "INVALID PASSWORD";
            }
        }
    }
}
