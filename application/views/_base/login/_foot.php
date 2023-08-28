<div id="kt_app_footer" class="app-footer">
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2023&copy;</span>
            <a href="javascript:void(0)" class="text-gray-800 text-hover-primary">SIPARELNEW</a>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
<script src="<?= base_url('assets/js/scripts.bundle.js') ?>"></script>
<script src="<?= base_url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') ?>"></script>
<script src="<?= base_url('assets/js/anime.min.js') ?>"></script>
<script src="<?= base_url('assets/js/widgets.bundle.js') ?>"></script>
<script src="<?= base_url('assets/js/custom/widgets.js') ?>"></script>
<script src="<?= base_url('assets/js/custom/apps/chat/chat.js') ?>"></script>
<script src="<?= base_url('assets/js/custom/utilities/modals/upgrade-plan.js') ?>"></script>
<script src="<?= base_url('assets/js/custom/utilities/modals/users-search.js') ?>"></script>


<script>
    let base_url = "<?= base_url() ?>";
    var target = document.querySelector("#kt_body");
    var blockUI = new KTBlockUI(target);
</script>

<?php if (isset($customJs)) {
    if (is_array($customJs) && count($customJs) > 0) {
        foreach ($customJs as $key => $value) {
            echo "<script type=\"text/javascript\" src='" . base_url($value) . "'></script>";
        }
    }
}
?>
</body>

</html>