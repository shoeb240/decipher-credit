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
                            </tr>
                        </thead>
                        <tbody>
                            <?php $baseUrl = base_url() . $this->config->item('index_page'); ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                  <td><a href="<?php echo $baseUrl; ?>/customerproducts/checklist/<?php echo $product->productID; ?>"><?php echo $product->productID; ?></a></td>
                                  <td>
                                      <?php echo $product->labelOverride; ?>
                                      
                                  </td>
                                  <td>
                                       <?php 
                                      
                                       
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
