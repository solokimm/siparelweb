</div>
<!--end::Content wrapper-->
<!--begin::Footer-->
<div id="kt_app_footer" class="app-footer">
    <!--begin::Footer container-->
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">2023&copy;</span>
            <a href="javascript:void(0)" class="text-gray-800 text-hover-primary">SIPARELNEW</a>
        </div>
        <!--end::Copyright-->
    </div>
    <!--end::Footer container-->
</div>
<!--end::Footer-->
</div>
<!--end:::Main-->
</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>
<!--end::App-->


<!--begin::Javascript-->
<script>
    var hostUrl = "assets/";
</script>

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
<script src="<?= base_url('assets/js/scripts.bundle.js') ?>"></script>
<!--end::Global Javascript Bundle-->

<script src="<?= base_url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') ?>"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.js') ?>"></script>
<script src="<?= base_url('assets/js/anime.min.js') ?>"></script>

<!--begin::Custom Javascript(used for this page only)-->
<script src="<?= base_url('assets/js/widgets.bundle.js') ?>"></script>
<script src="<?= base_url('assets/js/global/global_mask.js') ?>"></script>
<script>
    let base_url = "<?= base_url() ?>";
    var target = document.querySelector("#kt_app_body");
    var blockUI = new KTBlockUI(target);
</script>
<!--end::Custom Javascript-->

<?php
if (isset($customJs)) {
    if (is_array($customJs) && count($customJs) > 0) {
        foreach ($customJs as $key => $value) {
            echo "<script type=\"text/javascript\" src='" . base_url($value) . "'></script>";
        }
    }
}
?>

<!--end::Javascript-->
</body>
<!--end::Body-->

</html>