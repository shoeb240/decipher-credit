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
                    <h4>Current Usage / Service</h4>
                </div>
                <div class="table-fixedheader">
                    <table id="api-services-usage" class="table table-striped table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ACCESSED ON</th>
                                <th>ACCESSED BY</th>
                                <th>QUERY</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usages as $usage): ?>
                                <?php $accessedby = json_decode($usage->accessedBy); ?>
                                <?php $query = $usage->query ? unserialize($usage->query) : null; ?>
                                <tr>
                                    <td><?php echo $usage->accessedon; ?></td>
                                    <td><?php echo 'User: ' . $accessedby->user . '<br>Company: ' . $accessedby->company; ?></td>
                                    <td><?php echo get_object_value_recursively($query); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <a href="<?php echo base_url() . $this->config->item('index_page'); ?>/apiservices/view/" class="btn btn-primary" role="button">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#api-services-usage').DataTable({
            "order": [[ 0, "desc" ]]
        });
    });
</script>
