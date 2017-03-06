<style>
    .table-fixedheader {
        padding: 10px 15px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-10 pull-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Current Products</h4>
                </div>
                <div class="table-fixedheader">
                    <table id="product-list" class="table table-striped table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Description</th>
                                <th>Handler Dependencies</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $baseUrl = base_url() . $this->config->item('index_page'); ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                  <td><a href="<?php echo $baseUrl; ?>/products/checklist/<?php echo $product->uuid; ?>"><?php echo $product->uuid; ?></a></td>
                                  <td>
                                      <?php echo $product->description; ?>
                                      
                                  </td>
                                  <td>
                                       <?php 
 //                                      print_r($product->href); 
                                       $links = explode(',',$product->href);
                                       $list = count($links);
                                       for($ii=0; $ii < $list; $ii++){
                                           echo "<a href='$baseUrl/handlers/$links[$ii]'> ";
                                           echo  $links[$ii];
                                           echo " </a>";
                                       }
                                       
                                       ?>
                                  </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#product-list').DataTable({
            "order": [[ 1, "asc" ]]
        });
    });
</script>
