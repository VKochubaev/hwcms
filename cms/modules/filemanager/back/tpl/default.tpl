<script type="text/javascript" charset="utf-8">
    // Documentation for client options:
    // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
    $(document).ready(function() {
        $('#elfinder').elfinder({
            url : '{$mod_back_base}/elFinder/php/connector.php', lang: 'ru'
        });
    });
</script>

<div id="elfinder" style="height:100% !important;"></div>