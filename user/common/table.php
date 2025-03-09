<?php
// bind a function to check if this value exist
    function exist($str){
        if(isset($str)){
            echo $str;
        }
    }


?>


<div class="container1 container">
            <div class="titles">
                <a href="index.php">Home</a> /
                <a href="#">Systmes</a> /
                <span> <?php echo $title; ?></span>
            </div>


            <!-- Table section -->
             <div class="table">
                <div class="table-title">
                    <?php echo $title; ?>
                </div>
                <table>
                    <!-- table head start -->
                    <thead>
                        <tr>
                        <?php 
                            foreach($table as $k=>$v){
                        ?>
                            <th>
                                <?php echo exist($v);  ?>
                            </th>
                        <?php 
                        }
                        ?>
                        </tr>
                    </thead>
                </table>
             </div>
        </div>