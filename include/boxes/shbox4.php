<?php
/*
Script       => ShBox 4.1
Ilch Version => 1.1Q
Entwickler   => NachtWolf / B.Masmann
Date         => 27.11.15
Seite/Sup.   => http://www.ilch.de
                http://www.nf-projekt.de
Kontakt      => Masmann82@gmx.de
*/

defined ('main') or die ('no direct access');

include_once 'include/includes/class/shbox4class.php';

$tpl = new tpl ('shbox4.htm');
$var = NEW ShBox4();

if ($var->shconfig('aktiv') == '1') {
    $ILCH_HEADER_ADDITIONS .= '
    <link rel="stylesheet" type="text/css" href="include/images/shbox4/shbox4.css" />
    <script type="text/javascript" charset="utf-8" src="include/includes/js/shbox4.js" /></script>
    <script type="text/javascript" src="include/includes/js/bbcode.js" /></script>
    <script language="JavaScript" type="text/javascript" />
        window.onload = "fetch()";
        interval = window.setInterval("fetch();", '. $var->shconfig('time').');
    </script>';

    if ($menu->get(0) == 'forum' || $menu->get(0) == 'gbook') {
        $box = '<div id="shbox"></div>';
        $ar = array ( 'BOX' => $box,
                      'EIN' => '<p>!! Sperre !!</p>'
        );
        $tpl->set_ar_out($ar,0);
    } else {
        $box = '<div id="shbox"></div>';
        $ar = array ('BOX' => $box,
                     'EIN' => $var->eingabe()
        );
        $tpl->set_ar_out($ar,0);
    }
} else {
    echo '<center>'.BBcode($var->shconfig('aktivtext')).'</center>';
}
echo '<p><a href="?shbox4-archiv">Archiv</a></p>';
?>