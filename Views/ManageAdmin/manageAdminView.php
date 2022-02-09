<?php
    // prevent direct access
    require_once __DIR__ . "/../../Utilities/preventDirectAccess.php";
?>
<style>
    <?php
        require_once __DIR__ . "/manageProviderView.css";
    ?>
</style>
<div id="providerContainer">
    <h1>Admins</h1>
    <p style="color:red">
        <?php
            if (isset($_SESSION['createUserError'])){
                echo $_SESSION['createUserError'];
                unset($_SESSION['createUserError']);
            }
        ?>
    </p>
    <table id="providerList" class="w-100">
        <tr>
            <th>Name: </th>
            <th>Email: </th>
            <th>Username: </th>
            <th>Phone: </th>
            <th>Actions: </th>
        </tr>
        
        <?php 
            foreach ($admins as $key => $value) {
                $currentUser = new UserModel($pdo);
                $currentUser -> id = $value['user_id'];
                $currentUser -> readOne();
                echo "<tr>";
                echo "<td>".$currentUser -> name."</td>";
                echo "<td>".$currentUser -> email."</td>";
                echo "<td>".$currentUser -> username."</td>";
                echo "<td>".$currentUser -> phone."</td>";
                echo "<td>";
                $deleteActive = "";
                $deleteDisabledToolTip = "";
                if ($currentUser -> id == $_SESSION['user_id']){
                    $deleteActive = "disabled";
                    $deleteDisabledToolTip = 'title="You cannot delete yourself! Do it from My Account Page"';
                }
                echo '<button class="btn btn-info" data-toggle="collapse" data-target="#user'.$currentUser -> id.'">Show Info</button>
                <form '.$deleteDisabledToolTip.' onsubmit=\'return confirm("Do you really want to remove this user as admin?")\' style="display:inline-block" method="POST" action="Controllers/deleteOtherUser.php"><input type="hidden" name="access_level" value="4"><input type="hidden" name="user_id" value="'.$currentUser -> id.'"><button  type="submit" name="submit" class="btn btn-warning" '.$deleteActive.'>Delete Admin</button></form><form '.$deleteDisabledToolTip.' action="Controllers/deleteOtherUser.php" method="POST" onsubmit=\'return confirm("Do you really want to delete this user?")\' class="pl-1 d-inline-block"><input type="hidden" name="user_id" value="'.$currentUser -> id.'"><input type="hidden" name="access_level" value="4"><input type="hidden" name="delete_user" value="1"><button name="submit" value="submit" class="btn btn-danger" '.$deleteActive.'>Delete User Permanently</button></form>';
                

                echo "</td></tr>";
                echo '<tr class="collapse" id="user'.$currentUser -> id.'" data-parent="#providerContainer"><td colspan="5"> 
                <b>Name: </b> '.$currentUser -> name.' <br>
                <b>Email: </b> '.$currentUser -> email.' <br>
                <b>Username: </b> '.$currentUser -> username.' <br>
                <b>Phone: </b> '.$currentUser -> phone.' <br>
                <b>Address: </b> '.$currentUser -> address.' <br>
                <b>City: </b> '.$currentUser -> getCity().' <br>
                <b>Gender: </b> '.$currentUser -> getGender().' <br>
                </td></tr>';

            }

        ?>
              
    </table>
    <div class="p-2">
        <button class="btn btn-primary" data-toggle="modal" data-target="#createUserModal">Create Admin</button>
    </div>

    <div class="modal fade" id="createUserModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="Controllers/createUser.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Create User</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table>
                                <div class="form-group">
                                    <label for="input_name">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" maxlength="64" placeholder="Enter Fullname" required>
                                </div>
                                <div class="form-group">
                                    <label for="input_username">Username:</label>
                                    <input type="text" class="form-control" name="username" id="input_username" placeholder="Enter Username" title="Should not have any space or special characters" pattern="\w*" maxlength="64" required>
                                </div>
                                <div class="form-group">
                                    <label for="input_email">Email:</label>
                                    <input type="email" class="form-control" name="email" id="input_email" placeholder="Enter email id" maxlength="64" required>
                                </div>
                                <div class="form-group">
                                    <label for="input_password_1">Enter Password: </label>
                                    <input type="password" name="password_1" id="input_password_1" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="input_password_2">Reenter Password: </label>
                                    <input type="password" name="password_2" id="input_password_2" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="input_phone">Enter Phone Number:</label>
                                    <input type="tel" name="phone" id="input_phone" pattern="\d{10}" title="Enter 10 digits of phone number" placeholder="Enter phone number" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="input_address">Enter Address:</label>
                                    <textarea name="address" id="input_address" cols="30" rows="5" maxlength="195" title="Address Required" placeholder="Enter your address" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="input_city">Your City: </label>
                                    <select name="city" id="input_city" class="form-control">

                                        <?php
                                        $city = new CityModel($pdo);
                                        $result = $city->read();

                                        foreach ($result as $row) {
                                            
                                            echo "<option value='" . $row['id'] . "' >" . $row['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="input_gender">Select Gender: </label>
                                    <select name="gender" id="input_gender" class="form-control">
                                        <option value="0">Female</option>
                                        <option value="1">Male</option>
                                        <option value="2" selected>Prefer Not to Tell</option>
                                    </select>
                                </div>
                            </table>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="hidden" name="access_level" value="4">
                            <input type="submit" value="Save Changes" name="submit" class="btn btn-primary">
                        </div>

                    </form>


                </div>
            </div>
        </div>
    
</div>