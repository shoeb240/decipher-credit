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
                    <h4>Current Available API Services</h4>
                </div>
                <div class="table-fixedheader">
                    <table id="api-services-list" class="table table-striped table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>PROVIDER</th>
                                <th>SERVICE</th>
                                <th>7 DAYS USAGE</th>
                                <th>30 DAYS USAGE</th>
                                <th>DECIPHER COST</th>
                                <th>CUSTOMER BASE COST</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $baseUrl = base_url() . $this->config->item('index_page'); ?>
                            <?php foreach ($services as $service): ?>
                                <tr>
                                    <td><a href="<?php echo $baseUrl; ?>/apiservices/usage/<?php echo $service->id; ?>"><?php echo $service->id; ?></a></td>
                                    <td><a href="<?php echo $baseUrl; ?>/<?php echo $service->testform; ?>"><?php echo $service->provider; ?></a></td>
                                    <td><?php echo $service->service; ?></td>
                                    <td><?php echo (array_key_exists($service->id, $usage['weak']) ? $usage['weak'][$service->id] : 0); ?></td>
                                    <td><?php echo (array_key_exists($service->id, $usage['month']) ? $usage['month'][$service->id] : 0); ?></td>
                                    <td><?php echo (array_key_exists($service->id, $rates) ? $rates[$service->id]['decipher'] : '-'); ?></td>
                                    <td><?php echo (array_key_exists($service->id, $rates) ? $rates[$service->id]['customer'] : '-'); ?></td>
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
        $('#api-services-list').DataTable({
            "order": [[ 4, "desc" ]]
        });
    });
</script>
