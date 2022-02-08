<?php
    // prevent direct access
    require_once __DIR__ . "/../../Utilities/preventDirectAccess.php";

    if (isset($_GET['submit'])){

        if (isset($_GET['category_id']) && strlen($_GET['category_id']) > 0 && $_GET['category_id'] != "0"){
            // echo "GOING HERE";
            $category_id = $_GET['category_id'];

            $query = "SELECT * FROM Service WHERE category_id = :category_id";
            $params = [
                ':category_id' => $category_id
            ];

        } 
        if (isset($_GET['price_type']) && strlen($_GET['price_type']) > 0 && $_GET['price_type'] != "0"){
            if (isset($query)){
                $query .= " AND price_type_id = :price_type";
                $params[':price_type'] = $_GET['price_type'];
            } else {
                $query = "SELECT * FROM Service WHERE price_type_id = :price_type";
                $params = [
                    ':price_type' => $_GET['price_type']
                ];
            }
        } 


        if (isset($_GET['price_range_min']) && isset($_GET['price_range_max']) && strlen($_GET['price_range_min']) > 0 && strlen($_GET['price_range_max']) > 0){
            if (isset($query)){
                $query .= " AND price BETWEEN :price_range_min AND :price_range_max";
                $params[':price_range_min'] = $_GET['price_range_min'];
                $params[':price_range_max'] = $_GET['price_range_max'];
            } else {
                $query = "SELECT * FROM Service WHERE price BETWEEN :price_range_min AND :price_range_max";
                $params = [
                    ':price_range_min' => $_GET['price_range_min'],
                    ':price_range_max' => $_GET['price_range_max']
                ];
            }
        }

        // if only price_range_mins is present 
        if (isset($_GET['price_range_min']) && strlen($_GET['price_range_min']) > 0){
            if (isset($query)){
                $query .= " AND price >= :price_range_min";
                $params[':price_range_min'] = $_GET['price_range_min'];
            } else {
                $query = "SELECT * FROM Service WHERE price >= :price_range_min";
                $params = [
                    ':price_range_min' => $_GET['price_range_min']
                ];
            }
        }

        // if only price_range_maxs is present
        if (isset($_GET['price_range_max']) && strlen($_GET['price_range_max']) > 0){
            if (isset($query)){
                $query .= " AND price <= :price_range_max";
                $params[':price_range_max'] = $_GET['price_range_max'];
            } else {
                $query = "SELECT * FROM Service WHERE price <= :price_range_max";
                $params = [
                    ':price_range_max' => $_GET['price_range_max']
                ];
            }
        }

        // if only city_id is present
        if (isset($_GET['city_id']) && strlen($_GET['city_id']) > 0 && $_GET['city_id'] != "0"){
            if (isset($query)){
                $query .= " AND city_id = :city_id";
                $params[':city_id'] = $_GET['city_id'];
            } else {
                $query = "SELECT * FROM Service WHERE city_id = :city_id";
                $params = [
                    ':city_id' => $_GET['city_id']
                ];
            }
        }

        // if query is present in GET request 
        if (isset($_GET['query'])){
            // check if name or description contains query
            if (isset($query)){
                $query .= " AND (service_name LIKE :query OR description LIKE :query)";
                $params[':query'] = "%" . $_GET['query'] . "%";
            } else {
                $query = "SELECT * FROM Service WHERE (service_name LIKE :query OR description LIKE :query)";
                $params = [
                    ':query' => "%" . $_GET['query'] . "%"
                ];
            }
        }


        
        if (!isset($query)) {
            // echo "GOING HERE ###"; 
            
            $query = "SELECT * FROM Service";
            $params = [
                
            ];
        }


        // var_dump($query);
        $services = executeQuery($pdo, $query, $params);
    }

?>
<style>
    <?php
    require_once __DIR__ . "/ServiceView.css";
    ?>
</style>


<div class="row serviceContainer m-2">
    <div class="col-12 col-lg-2 serviceFilterContainer w-100 p-2">
        <button class="btn btn-secondary btn-block my-1" data-toggle="collapse" data-target="#filterCollapseContainer">Filters</button>
        <div class="collapse" id="filterCollapseContainer">
            <form id="filterForm" method="GET">
                <div class="form-group">
                    <label for="input_category_id">Category: </label>
                    <select name="category_id" id="input_category_id" class="form-control">
                        <option value="0">All</option>
                        <?php
                        foreach ($categories as $category) {
                            if (isset($_GET['category_id']) && ($_GET['category_id']== $category['id'])  ){
                                echo "<option value='{$category['id']}' selected>{$category['name']}</option>";
                            } else {
                                echo "<option value='{$category['id']}'>{$category['name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="input_price_type">Price Type: </label>
                    <select name="price_type" id="input_price_type" class="form-control">
                        <option value="0">All</option>
                        <?php
                        foreach ($priceTypes as $type) {
                            if (isset($_GET['price_type']) && ($_GET['price_type']== $type['id'])  ){
                                echo "<option value='{$type['id']}' selected>{$type['type']}</option>";
                            } else {
                                echo "<option value='{$type['id']}'>{$type['type']}</option>";
                            }
                            
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="input_price_range">Inpute Range:</label><br>
                    <div class="row m-0">
                        <input type="number" name="price_range_min" id="input_price_range_min" class="form-control col-6" max="100000" min="0" placeholder="Min" value="<?php if (isset($_GET['price_range_min'])){ echo $_GET['price_range_min']; } ?>">
                        <input type="number" name="price_range_max" id="input_price_range_max" class="form-control col-6" max="100000" min="0" placeholder="Max" value="<?php if (isset($_GET['price_range_max'])){ echo $_GET['price_range_max']; } ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_city_id">City: </label>
                    <select name="city_id" id="input_city_id" class="form-control">
                        <option value="0">All</option>
                        <?php
                        foreach ($cities as $city) {
                            if (isset($_GET['city_id']) && ($_GET['city_id']== $city['id'])  ){
                                echo "<option value='{$city['id']}' selected>{$city['name']}</option>";
                            } else {
                                echo "<option value='{$city['id']}'>{$city['name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input id="reset-button" type="button" value="Reset" class="form-control">
                </div>
                <button type="submit" class="form-control btn btn-info" name="submit" value="filterSubmit">Save</button>
            </form>
        </div>
    </div>
    <div class="col-12 col-lg-10 serviceListContainer w-100">
        <div id="searchBox">
            <div class="input-group mb-3">
                <input type="search" class="form-control" placeholder="Search .." form="filterForm" name="query" value="<?php 
                    if (isset($_GET['query'])) {
                        echo $_GET['query'];
                    }
                ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" id="button-addon2" form="filterForm" name="submit">Search</button>
                </div>
            </div>

        </div>
        <div class="serviceItemContainer row">
            <?php 
            foreach ($services as $serv) {
                
                echo '<div class="serviceItemsContainer col-sm-6 col-md-4 col-lg-3 p-3 d-flex justify-content-center align-items-center" id="serviceItem1">
                    <div class="serviceItem w-100 m-0">
                        <div class="serviceImageContainer h-75 d-flex align-items-center justify-content-center pt-3">
                            <img src="Controllers/getServiceImage.php?id='.$serv['id'].'" alt="" class="h-100 w-75" alt="Service" onerror=\'this.src="Views/images/noService.jpg"\'>
                        </div>
                        <div class="serviceDetails mx-4 mt-2">
                            <span class="mx-1">';
                            echo $serv['service_name'];
                            echo '</span><br>';
                            echo '<span  class="price"> ₹&nbsp;';
                            echo $serv['price'];
                            echo '</span>';

                            echo '<span class="ml-1 badge badge-info smallText">';
                            echo $priceTypes[$serv['price_type_id']-1]['type'];
                            echo '</span>';
                            
                            echo '<br>
                            <span class="mr-1 smallText">';
                                echo $serviceCategories[$serv['category_id']-1]['name'];
                            echo '</span>';
                            
                            
                            if ($serv['city_id'] == $userModel -> city_id){
                                
                                echo '<span class="badge badge-success smallText">';
                            } else {
                                
                                echo '<span class="badge badge-danger smallText">';
                            }
                                echo $cities[$serv['city_id']-1]['name'];
                                echo '<a href="https://google.com" class="stretched-link" target="__blank"></a>
                            </span>';
                            echo '</span><br>
                        </div>
                    </div>
                </div>';
            }

            // check if $services is empty 
            if (empty($services)) {
                echo '<div class="col-12 text-center" style="color:grey">
                    <h3>No Services Found</h3>
                    <div class="sad-image-container w-100 h-100 d-flex justify-content-center align-items-center">
                <img src="Views\images\noresult.jpg" alt="" class="sad-image">
            </div>
                </div>';
            }
            
            ?>
            
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {


        $("#reset-button").click(function() {
            $("#input_category_id").prop('selectedIndex', 0);
            $("#input_price_type").prop('selectedIndex', 0);
            // $("#input_price_type").val(0);
            $("#input_price_range_min").attr("value", "");
            $("#input_price_range_max").attr("value", "");
            // $("#input_price_range_max").val(0);
            // $("#input_city_id").val(0);
            $("#input_city_id").prop('selectedIndex', 0);
            console.log("resetting");
        });


    });
</script>