<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit();

$profile = WPMSGA_Tools::get_selected_profile( $google_alanytics['profile_list'], $google_alanytics['tableid_jail'] );
?>
<script type="text/javascript">
  var _gaq = _gaq || [];
<?php	if ($this->ga_tracking['wpmsga_enhanced_links']) {?>
  var pluginUrl = '//www.google-analytics.com/plugins/ga/inpage_linkid.js';
  _gaq.push(['_require', 'inpage_linkid', pluginUrl]);
<?php }?>
  _gaq.push(['_setAccount', '<?php echo esc_html($profile[2]); ?>']);
  _gaq.push(['_trackPageview']<?php if ($this->ga_tracking['wpmsga_dash_anonim']) {?>, ['_gat._anonymizeIp']<?php }?>);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
<?php if ($this->ga_tracking['wpmsga_dash_remarketing']) { ?>
    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
<?php }else{?>
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
<?php }?>
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>