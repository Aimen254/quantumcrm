<script src="{{ asset('vendor/global/global.min.js') }}"></script>
<script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
<script src="{{ asset('vendor/fullcalendar/js/main.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins-init/fullcalendar-init.js') }}"></script>
<script src="{{ asset('vendor/chart-js/chart.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('vendor/apexchart/apexchart.js') }}"></script>

<!-- Dashboard 1 -->
<script src="{{ asset('assets/js/dashboard/dashboard-1.js') }}"></script>
<script src="{{ asset('vendor/draggable/draggable.js') }}"></script>
<script src="{{ asset('vendor/swiper/js/swiper-bundle.min.js') }}"></script>

<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins-init/datatables.init.js') }}"></script>

<!-- Apex Chart -->
<script src="{{ asset('vendor/bootstrap-datetimepicker/js/moment.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

<!-- Vectormap -->
<script src="{{ asset('vendor/jqvmap/js/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('vendor/jqvmap/js/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('vendor/jqvmap/js/jquery.vmap.usa.js') }}"></script>
<script>
      var styleCssPath = "{{ asset('css/style.css') }}";  // Correct URL for style.css
      var styleRtlCssPath = "{{ asset('css/style-rtl.css') }}";  // Correct URL for style-rtl.css
</script>

<script src="{{ asset('assets/js/custom.min.js') }}"></script>
<script src="{{ asset('assets/js/deznav-init.js') }}"></script>
<script src="{{ asset('assets/js/demo.js') }}"></script>
<script src="{{ asset('assets/js/styleSwitcher.js') }}"></script>

<script>
    jQuery(document).ready(function () {
        setTimeout(function () {
            dzSettingsOptions.version = 'light';
            new dzSettings(dzSettingsOptions);

            setCookie('version', 'light');
        }, 1500)
    });
</script>


