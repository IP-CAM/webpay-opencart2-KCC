<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-webpay" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a onclick="location = '<?php echo $cancel; ?>';" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-webpay" class="form-horizontal">

            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-khipu_receiverid"><?php echo $entry_kcc_url; ?></label>
                <div class="col-sm-10">
                    <input type="text" name="webpay_occl_kcc_url" value="<?php echo $webpay_occl_kcc_url; ?>" id="khipu_receiverid" class="form-control" />
                    <?php if ($error_kcc_url) { ?>
              <span class="error"><?php echo $error_kcc_url; ?></span>
              <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-khipu_secret"><?php echo $entry_kcc_path; ?></span></label>
                <div class="col-sm-10">
                    <input type="text" name="webpay_occl_kcc_path" value="<?php echo $webpay_occl_kcc_path; ?>" id="webpay_occl_kcc_path" class="form-control" />
                    <?php if ($error_kcc_path) { ?>
              <span class="error"><?php echo $error_kcc_path; ?></span>
              <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-webpay_occl_return_policy"><?php echo $entry_return_policy; ?></label>
                <div class="col-sm-10">
                    <select name="webpay_occl_return_policy" id="input-webpay_occl_return_policy" class="form-control">
                        <option value="0"><?php echo $text_none; ?></option>
                        <?php foreach ($informations as $information) { ?>
		                  <?php if ($information['information_id'] == $webpay_occl_return_policy) { ?>
		                  <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
		                  <?php } else { ?>
		                  <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
		                  <?php } ?>
		                  <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-webpay"><?php echo $entry_callback; ?></span></label>
                <div class="col-sm-10">
                    <textarea rows="5" class="form-control"><?php echo $callback; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-khipu_secret"><?php echo $entry_total; ?></span></label>
                <div class="col-sm-10">
                    <input type="text" name="webpay_occl_total" value="<?php echo $webpay_occl_total; ?>" id="webpay_occl_total" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="webpay_occl_return_policy"><?php echo $entry_order_status; ?></label>
                <div class="col-sm-10">
                    <select name="webpay_occl_order_status_id" id="webpay_occl_order_status_id" class="form-control">
                        <?php foreach ($order_statuses as $order_status) { ?>
		                <?php if ($order_status['order_status_id'] == $webpay_occl_order_status_id) { ?>
		                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
		                <?php } else { ?>
		                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
		                <?php } ?>
		                <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="webpay_occl_geo_zone_id"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                    <select name="webpay_occl_geo_zone_id" id="webpay_occl_geo_zone_id" class="form-control">
                        <option value="0"><?php echo $text_all_zones; ?></option>
                        <?php foreach ($geo_zones as $geo_zone) { ?>
                        <?php if ($geo_zone['geo_zone_id'] == $webpay_occl_geo_zone_id) { ?>
                        <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-khipu_status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                    <select name="webpay_occl_status" id="input-webpay_occl_status" class="form-control">
                        <?php if ($webpay_occl_status) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-webpay_occl_sort_order"><?php echo $entry_sort_order ?></label>
                <div class="col-sm-10">
                    <input type="text" name="webpay_occl_sort_order" value="<?php echo $webpay_occl_sort_order; ?>" id="input-webpay_occl_sort_order" class="form-control" />
                </div>
            </div>

      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 
  