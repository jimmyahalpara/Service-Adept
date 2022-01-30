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
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore, harum maxime, nisi placeat rem molestiae esse sequi alias tempora accusantium laborum corporis praesentium eum iste! Et, eligendi veniam dolores error quis, quo nisi obcaecati, tempora porro veritatis dignissimos similique autem consequuntur assumenda ut officia perferendis sunt nam minima deserunt! Repudiandae sapiente libero repellat suscipit laudantium sint odit, quam eligendi asperiores accusantium non aliquid praesentium minus iste aut saepe esse debitis impedit consequatur maxime corporis. Mollitia quisquam dolorum deleniti perferendis consequatur ipsum dolorem aliquid magni vel harum, voluptatibus, culpa molestiae aspernatur veritatis reprehenderit nisi? Soluta eligendi repellendus doloremque doloribus rerum illo. Eos sunt nisi expedita placeat hic inventore odio. Repudiandae, harum inventore sapiente vero modi doloribus optio quibusdam beatae nulla adipisci ipsam aliquid voluptas eos nobis illum voluptatibus sed, explicabo quisquam vel assumenda. Voluptatum ut facere error dicta quia voluptas, aliquam a at repudiandae unde, vero earum ipsa officia soluta, quaerat ab reprehenderit molestias culpa impedit cum eveniet. Voluptates nulla cupiditate laudantium totam nihil ducimus soluta autem accusamus quis culpa nostrum dolore ratione cumque suscipit saepe mollitia laborum quaerat error atque deserunt eos, illo accusantium! Facilis amet facere quia, ducimus eum vitae, mollitia ratione eos dicta quaerat rerum atque officia commodi.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quod totam beatae explicabo fugit reprehenderit voluptatibus eaque soluta, libero numquam. Cum officia atque placeat non expedita qui quisquam, porro facere! Culpa similique vel, voluptatibus quas minus quaerat, optio maxime adipisci beatae animi illum odit nesciunt rerum possimus consequatur enim accusantium quidem, soluta amet provident obcaecati itaque? Perferendis iste expedita quos praesentium cupiditate ut facilis minima similique sapiente asperiores. Obcaecati harum atque mollitia necessitatibus, aspernatur odio dolores et nulla pariatur magnam totam molestiae fuga eligendi maiores distinctio sunt ad laudantium aliquid numquam eius maxime. Dicta, labore asperiores temporibus magnam esse quos blanditiis, fugiat impedit porro, modi doloribus accusamus inventore nulla facilis illo necessitatibus odio consectetur possimus quibusdam corrupti. Quibusdam, voluptatem reprehenderit? Officia ut delectus, dolor atque dolorem doloremque accusamus earum! Unde obcaecati minus libero alias nostrum distinctio tempora facilis suscipit fugit autem! Sit provident ipsum facere ab voluptatem. Recusandae aperiam praesentium commodi ea voluptates. Doloremque nam officia laborum modi nobis qui, eum adipisci vero aspernatur repudiandae natus quibusdam eaque in mollitia ipsa soluta esse illo eos blanditiis ipsum distinctio sed dignissimos. Voluptate libero molestiae, nihil, natus minima totam impedit optio recusandae debitis sit odit mollitia quod? Quos id repellendus fugit facere!
    </div>
</div>