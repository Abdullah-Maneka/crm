<?php echo form_open(get_uri("estimates/update_estimate_status/$model_info->id/accepted/1"), array("id" => "accept-estimate-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <?php if (get_setting("add_signature_option_on_accepting_estimate")) { ?>
            <div class="form-group">
                <div class="row">
                    <label for="signature" class="col-md-3"><?php echo app_lang('signature'); ?></label>
                    <div class="col-md-9">
                        <div id="signature">
                            <canvas class="b-a" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('accept'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#accept-estimate-form").appForm({
            onSuccess: function (result) {
                if (result.success) {
                    appAlert.success(result.message, {duration: 10000});
                    location.reload();
                } else {
                    appAlert.error(result.message);
                }
            }
        });

        $("#name").focus();

        initSignature("signature", {
            required: true,
            requiredMessage: "<?php echo app_lang("field_required"); ?>"
        });
    });
</script>