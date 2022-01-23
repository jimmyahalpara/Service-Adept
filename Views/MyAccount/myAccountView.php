<style>
    <?php
    require_once __DIR__ . '/myAccountView.css';
    ?>
</style>
<div class="myAccountMainContainer">
    <h1>
        My Account
    </h1>
    <p style="color:red">
        <?php
        if (isset($_SESSION['userUpdateError'])) {
            echo $_SESSION['userUpdateError'];
            unset($_SESSION['userUpdateError']);
        }
        ?>
    </p>
    <div class="myAccountUserDetails">
        <table class="prettyTable">
            <tr>
                <td>Name: </td>
                <td><?php echo $user->name ?></td>
            </tr>
            <tr>
                <td>Username: </td>
                <td><?php echo $user->username ?></td>
            </tr>
            <tr>
                <td>ID: </td>
                <td><?php echo $user->id ?></td>
            </tr>
            <tr>
                <td>Email: </td>
                <td><?php echo $user->email ?></td>
            </tr>
            <tr>
                <td>Phone: </td>
                <td><?php echo $user->phone ?></td>
            </tr>
            <tr>
                <td>Address: </td>
                <td><?php echo $user->address ?></td>
            </tr>
            <tr>
                <td>City: </td>
                <td><?php echo $user->getCity(); ?></td>
            </tr>
            <tr>
                <td>
                    Gender:
                </td>
                <td>
                    <?php
                    switch ($user->gender) {
                        case 0:
                            echo "Female";
                            break;

                        case 1:
                            echo "Male";
                            break;

                        case 2:
                            echo "Prefer Not to Tell";
                            break;
                    }
                    ?>
                </td>
            </tr>
        </table>
        <div class="buttonContainer d-flex mt-3">
            <button class="btn btn-primary mx-1" data-toggle="modal" data-target="#editUserModal">Edit Details</button>
            <button class="btn btn-warning mx-1" data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
            <button class="btn btn-danger mx-1" data-toggle="modal" data-target="#deleteModal">Delete Account</button>
        </div>

        <!-- model for editing user -->
        <div class="modal fade" id="editUserModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="Controllers/editUser.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit User</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table>
                                <div class="form-group">
                                    <label for="input_name">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $user->name ?>" maxlength="64" required>
                                </div>
                                <div class="form-group">
                                    <label for="input_username">Username:</label>
                                    <input type="text" class="form-control" name="username" id="input_username" placeholder="Enter Username" title="Should not have any space or special characters" pattern="\w*" maxlength="64" value="<?php echo $user->username ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="input_email">Email:</label>
                                    <input type="email" class="form-control" name="email" id="input_email" placeholder="Enter email id" maxlength="64" value="<?php echo $user->email ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="input_phone">Enter Phone Number:</label>
                                    <input type="tel" name="phone" id="input_phone" pattern="\d{10}" title="Enter 10 digits of phone number" placeholder="Enter phone number" class="form-control" value="<?php echo $user->phone ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="input_address">Enter Address:</label>
                                    <textarea name="address" id="input_address" cols="30" rows="5" maxlength="195" title="Address Required" placeholder="Enter your address" class="form-control" required><?php echo $user->address ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="input_city">Your City: </label>
                                    <select name="city" id="input_city" class="form-control">

                                        <?php
                                        $city = new CityModel($pdo);
                                        $result = $city->read();

                                        foreach ($result as $row) {
                                            $selected = "";
                                            if ($row['id'] == ($user->city_id)) {
                                                $selected = "selected";
                                            }
                                            echo "<option value='" . $row['id'] . "' " . $selected . " >" . $row['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="input_gender">Select Gender: </label>
                                    <select name="gender" id="input_gender" class="form-control">
                                        <option value="0" <?php if ($user->gender == 0) {
                                                                echo "selected";
                                                            } ?>>Female</option>
                                        <option value="1" <?php if ($user->gender == 1) {
                                                                echo "selected";
                                                            } ?>>Male</option>
                                        <option value="2" <?php if ($user->gender == 2) {
                                                                echo "selected";
                                                            } ?>>Prefer Not to Tell</option>
                                    </select>
                                </div>
                            </table>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" value="Save Changes" name="submit" class="btn btn-primary">
                        </div>

                    </form>


                </div>
            </div>
        </div>


        <!-- model for changing password -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="Controllers/changePassword.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Change Password</h5>
                            <button type="button" class="close" data-dismiss="modal" >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="input_password">Enter Old Password: </label>
                                <input type="password" name="password_old" id="input_password_old" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="input_password1">Enter New Password: </label>
                                <input type="password" name="password1" id="input_password1" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="input_passwor2">Renter New Password: </label>
                                <input type="password" name="password2" id="input_password2" class="form-control">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" value="Save Changes" name="submit" class="btn btn-primary">
                        </div>

                    </form>


                </div>
            </div>
        </div>


        <!-- model to delete user -->
        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="Controllers/deleteUser.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">WARNING</h5>
                            <button type="button" class="close" data-dismiss="modal" >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Do you really want delete this user?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" value="Delete" name="submit" class="btn btn-danger">
                        </div>

                    </form>


                </div>
            </div>
        </div>


    </div>
</div>