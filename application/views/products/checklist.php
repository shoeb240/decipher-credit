<?php
//print_r($productchecklist);

?>
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
                <h4>Current Product Checklist</h4>
            </div>
            <div class="table-fixedheader">
                <table id="checklist" class="table table-striped table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>UUID</th>
                            <th>Product</th>
                            <th>Description</th>
                            <th>Sort</th>
                            <th>Handler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productchecklist as $item): ?>
                            <tr>
                              <td>
                                  <?php echo $item->uuid; ?>
                              </td>

                              <td>
                                  <?php echo $item->description; ?>
                              </td>


                              <td>
                                  <?php echo $item->label; ?>
                              </td>
                              <td>
                                  <?php echo $item->sorder; ?>
                              </td>
                              <td>
                                  <?php echo $item->handler; ?>
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
    $('#checklist').DataTable({
        "order": [[ 1, "asc" ]]
    });
});
</script>
