<?php
// prevent direct access
require_once __DIR__ . "/../../Utilities/preventDirectAccess.php";
?>
<style>
    <?php
    require_once __DIR__ . "/manageServiceView.css";
    ?>
</style>
<div id="providerContainer">
    <h1>Services</h1>
    <p style="color:red">
        <?php
        if (isset($_SESSION['Error'])) {
            echo $_SESSION['Error'];
            unset($_SESSION['Error']);
        }
        ?>
    </p>
    <div id="serviceContainer">


        <?php
        foreach ($services as $value) {
            if ($value['visibility'] == 1) {
                echo '<div class="card m-2 border-dark">';
            } else {
                echo '<div class="card m-2 bg-danger text-white">';
            }
            echo '<div class="card-header">
                ' . $categories[$value['category_id'] - 1]['name'] . '
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-left align-items-center">
                    <div class="serviceImageContainer p-3">
                        <img src="Controllers/getServiceImage.php?id='.$value['id'].'" alt="" class="serviceImage" onerror="this.src=\'Views/images/noService.jpg\'">
                    </div>
                    <div>
                        <h5 class="card-title">' . $value['service_name'] . '</h5>
                        <p class="card-text">' . $value['description'] . '</p>
                        <a href="#" class="btn btn-info" data-toggle="collapse" data-target="#detailCollapse' . $value['id'] . '">More</a>
                    </div>
                </div>
                


                <div class="my-2 pt-1 collapse" id="detailCollapse' . $value['id'] . '" data-parent="#serviceContainer">
                    <hr>
                    <p>
                        <b>Price Type:</b> ' . $priceTypes[$value['price_type_id'] - 1]['type'] . '
                    </p>
                    <p>
                        <b>Price(Rs): </b> ' . $value['price'] . '
                    </p>
                    <p>
                        <b>City: </b>. ' . $cities[$value['city_id'] - 1]['name'] . '
                    </p>
                    <table class="p-1 my-1 mt-3">
                        <tr class="m-2">
                            <th>Provider Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>';

                    // query to join ServiceProvider, Provider, and User table to get all providers for service
                    $query = "SELECT user.name as name, user.email as email, user.phone as phone, user.id as user_id, serviceprovider.id as service_provider_id FROM serviceprovider INNER JOIN provider ON serviceprovider.provider_id = provider.id INNER JOIN user ON provider.user_id = user.id WHERE serviceprovider.service_id = :service_id";

                    $params = [
                        ':service_id' => $value['id']
                    ];

                    $serviceProviders = executeQuery($pdo, $query, $params);
                    // var_dump($providers);
                    foreach ($serviceProviders as $provider) {
                        echo '<tr class=" m-2">
                            <td>'.$provider['name'].'</td>
                            <td>'.$provider['email'].'</td>
                            <td>'.$provider['phone'].'</td>
                            <td>
                                <form onsubmit="return confirm(\'Do you really want to remove this provider from this service?\')" action="Controllers/deleteServiceProvider.php" method="POST">
                                    <input type="hidden" name="service_provider_id" value="'.$provider['service_provider_id'].'">
                                    <button type="submit" name="submit" value="submit" class="btn btn-warning">Remove</button>
                                </form>
                            </td>
                        </tr>';

                    }
                    echo '</table>
                    <hr>';
                    echo '<form class="form-group my-2" action="Controllers/createServiceProvider.php" method="POST">
                        <input type="hidden" name="service_id" value="' . $value['id'] . '">
                        <select name="provider_id" id="input_provider'.$value['id'].'" class="form-control w-50 d-inline-block">';
                        foreach ($providers as $provider) {
                            echo '<option value="' . $provider['provider_id'] . '">' . $provider['username'] . '</option>';
                        }
                        echo '</select>
                        <button class="btn btn-primary mt-n1" name="submit" value="add provider">Add Provider</button>
                    </form>
                    <hr>
                    <form id="imageUploadForm'.$value['id'].'" class="d-inline-block" method="post" enctype="multipart/form-data">
                        <input type="hidden" value="'.$value['id'].'" name="id">
                        <label for="input_file_upload_'.$value['id'].'">Upload Profile Image</label>
                        <input type="file" class="form-control-file" id="input_file_upload_'.$value['id'].'" name="imageFile">
                    </form>
                    <button class="btn btn-secondary m-1" data-toggle="modal" data-target="#editModal' . $value['id'] . '">Edit</button>
                    <form action="Controllers/deleteService.php" method="POST" onsubmit="return confirm(\'Do you really want to remove this service?\');" class="d-inline-block">
                        <input type="hidden" name="service_id" value="' . $value['id'] . '">
                        <button class="btn btn-danger my-1" name="submit" value="submit">Delete Service</button>
                    </form>
                    <form action="Controllers/changeVisiblity.php" method="POST" class="d-inline-block">';
                        if ($value['visibility'] == 1) {
                            echo '<input type="hidden" name="visibility" value="0">
                            <button class="btn btn-outline-danger my-1" name="submit" value="'.$value['id'].'">Make Invisible</button>';
                        } else {
                            echo '<input type="hidden" name="visibility" value="1">
                            <button class="btn btn-success my-1" name="submit" value="'.$value['id'].'">Make Visible</button>';
                        }
                    echo '</form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editModal' . $value['id'] . '" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" action="Controllers/editService.php">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Service</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                            <div class="form-group">
                                <label for="input_service_name' . $value['id'] . '">Service Name: </label>
                                <input type="text" name="service_name" id="input_service_name' . $value['id'] . '" class="form-control" value="' . $value['service_name'] . '" required>
                            </div>
                            <div class="form-group">
                                <label for="input_description' . $value['id'] . '">Description: </label>
                                <textarea name="description" id="input_description' . $value['id'] . '" cols="30" rows="10" class="form-control">' . $value['description'] . '</textarea>
                            </div>
                            <div class="form-group">
                                <label for="input_pricetype' . $value['id'] . '">Price Type</label>
                                <select name="pricetype" id="input_pricetype' . $value['id'] . '" class="form-control">';

            foreach ($priceTypes as $priceType) {
                echo '<option value="' . $priceType['id'] . '"';
                if ($priceType['id'] == $value['price_type_id']) {
                    echo 'selected';
                }
                echo '>' . $priceType['type'] . '</option>';
            }
            echo '</select>
                            </div>
                            <div class="form-group">
                                <label for="input_price' . $value['id'] . '">Price: </label>
                                <input type="text" name="price" id="input_price' . $value['id'] . '" class="form-control" value="' . $value['price'] . '" required>
                            </div>
                            <div class="form-group">
                                <label for="input_city' . $value['id'] . '">City: </label>
                                <select name="city" id="input_city' . $value['id'] . '" class="form-control">';
            foreach ($cities as $city) {
                if ($value['city_id'] == $city['id']) {
                    echo '<option value="' . $city['id'] . '" selected>' . $city['name'] . '</option>';
                } else {
                    echo '<option value="' . $city['id'] . '" >' . $city['name'] . '</option>';
                }
            }
            echo '</select>
                            </div>
                            <div class="form-group">
                                <label for="input_category' . $value['id'] . '">Category: </label>
                                <select name="category_id" id="input_category' . $value['id'] . '" class="form-control">';
            foreach ($categories as $category) {
                if ($value['category_id'] == $category['id']) {
                    echo '<option value="' . $category['id'] . '" selected>' . $category['name'] . '</option>';
                } else {
                    echo '<option value="' . $category['id'] . '" >' . $category['name'] . '</option>';
                }
            }
            echo '</select>
                            </div>
                        

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="hidden" name="service_id" value="' . $value['id'] . '">
                        <input type="submit" value="Save Changes" name="submit" class="btn btn-primary">
                    </div>

                </form>


            </div>
        </div>
    </div>
        ';
        }

        ?>
    </div>









    <button class="btn btn-primary m-1" data-toggle="modal" data-target="#createServiceModal">Add Service</button>
    <div class="modal fade" id="createServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="Controllers/createService.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Service</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="input_service_name">Service Name: </label>
                            <input type="text" name="service_name" id="input_service_name" class="form-control" placeholder="Enter Service Name" required>
                        </div>
                        <div class="form-group">
                            <label for="input_description">Description: </label>
                            <textarea name="description" id="input_description" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="input_pricetype">Price Type</label>
                            <select name="pricetype" id="input_pricetype" class="form-control">
                                <?php

                                foreach ($priceTypes as $priceType) {
                                    echo '<option value="' . $priceType['id'] . '"';
                                    echo '>' . $priceType['type'] . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="input_price">Price: </label>
                            <input type="text" name="price" id="input_price" class="form-control" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="input_city">City: </label>
                            <select name="city" id="input_city" class="form-control">
                                <?php
                                foreach ($cities as $city) {
                                    echo '<option value="' . $city['id'] . '" >' . $city['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="input_category">Category: </label>
                            <select name="category_id" id="input_category" class="form-control">
                                <?php
                                foreach ($categories as $category) {

                                    echo '<option value="' . $category['id'] . '" >' . $category['name'] . '</option>';
                                }
                                ?>
                            </select>
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





</div>

<script>
    $(document).ready(function(){
        $("input:file").change(function(){
            formData = new FormData(this.form);
            for (var [key, value] of formData.entries()) { 
                console.log(key, value);
            }
            $.ajax({
                url: "Controllers/uploadServiceImage.php",
                type: "POST",
                data: new FormData(this.form),
                processData: false,
                contentType: false,
                cache: false,
                success: function(data){
                    location.reload();
                }
            });

        });
    });
</script>