<?php 

if (isset($_POST["reset-password-submit"])) {

    $selector= $_POST["selector"];
    $validator= $_POST["validator"];
    $password= $_POST["pwd"];
    $passwordRepeat= $_POST["pwd-repeat"];

    if (empty($password) || empty($passwordRepeat)) {
        header("Location: ../create_new_pass.php?newpwd=empty");
        exit();
    } else if ($password != $passwordRepeat) {
        header("Location: ../create_new_pass.php?newpwd=pwdnotmatch");
        exit();
    }

    $currentDate = date("U");

    require '../database/dbcon.php'; 

    $sql = "SELECT * FROM pass_reset WHERE reset_selector=?";
    $stmt = mysqli_stmt_init($con);

    mysqli_stmt_prepare($stmt, $sql);

        mysqli_stmt_bind_param($stmt, "s", $selector);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt); 
        if (!$row = mysqli_fetch_assoc($result)) {
            echo "Resubmit your reset password request.";
            exit();
        } else {

            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row["reset_token"]); 

            if ($tokenCheck === false) {
                echo "Resubmit your reset password request.";
                exit();
            } elseif ($tokenCheck === true) {
                    $tokenEmail = $row['reset_email'];

                    $sql = "SELECT * FROM user WHERE email=?";

                    $stmt = mysqli_stmt_init($con);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "There was an error selecting user!";
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt); 
                        if (!$row = mysqli_fetch_assoc($result)) {
                            echo "There was no user with this email.";
                            exit();
                        } else {
                            $sql = "UPDATE user SET password=? WHERE email=?";
                            $stmt = mysqli_stmt_init($con);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "There was an error updating your password!";
                                exit();
                            } else {
                                //$newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                                $newPwdHash = $password;
                                mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                                mysqli_stmt_execute($stmt);

                                $sql = "DELETE FROM pass_reset WHERE reset_email=?";
                                $stmt = mysqli_stmt_init($con);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    echo "There was an error removing ur forgot password session!";
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                    header("Location: ../index.php?newpwd=passwordupdated");
                                }
                            }
                        }
                    }

            }

        }
    

} else {
    header("Location: ../index.php");
}