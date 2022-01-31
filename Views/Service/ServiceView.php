<?php
// prevent direct access
require_once __DIR__ . "/../../Utilities/preventDirectAccess.php";
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
                    <label for="input_service_type">Category: </label>
                    <select name="service_type" id="input_service_type" class="form-control">
                        <option value="0">All</option>
                        <?php
                        foreach ($categories as $category) {
                            if (isset($_GET['service_type']) && ($_GET['service_type']== $category['id'])  ){
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
                        <input type="number" name="price_range_min" id="input_price_range_min" class="form-control col-6" max="2000" min="0" placeholder="Min" value="<?php if (isset($_GET['price_range_min'])){ echo $_GET['price_range_min']; } ?>">
                        <input type="number" name="price_range_max" id="input_price_range_max" class="form-control col-6" max="2000" min="0" placeholder="Max" value="<?php if (isset($_GET['price_range_max'])){ echo $_GET['price_range_max']; } ?>">
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
                    <input type="reset" value="Reset" class="form-control">
                </div>
                <button type="submit" class="form-control btn btn-info" name="submit">Save</button>
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
                    <button class="btn btn-primary" type="submit" id="button-addon2" form="filterForm">Search</button>
                </div>
            </div>

        </div>
        <div class="serviceItemContainer row">
            <?php 
            foreach ($services as $serv) {
                
                echo '<div class="serviceItemsContainer col-sm-6 col-md-4 col-lg-3 p-3 d-flex justify-content-center align-items-center" id="serviceItem1">
                    <div class="serviceItem w-100 m-0">
                        <div class="serviceImageContainer h-75 d-flex align-items-center justify-content-center pt-3">
                            <img src="https://i.pinimg.com/originals/8e/fb/11/8efb11a0432a2416fbc57c90c320151c.png" alt="" class="h-100 w-75">
                        </div>
                        <div class="serviceDetails mx-4 mt-2">
                            <span class="mx-1">';
                            echo $serv['service_name'];
                            echo '</span><br>
                            <span class="mx-1 smallText">';
                                echo $serviceCategories[$serv['category_id']-1]['name'];
                            echo '</span>';
                            if ($serv['city_id'] == $userModel -> city_id){
                                
                                echo '<span class="badge badge-success mx-1 smallText">';
                            } else {
                                
                                echo '<span class="badge badge-danger mx-1 smallText">';
                            }
                                echo $cities[$serv['city_id']-1]['name'];
                                echo '<a href="https://google.com" class="stretched-link" target="__blank"></a>
                            </span>
                        </div>
                    </div>
                </div>';
            }
            
            ?>
        </div>
    </div>
</div>