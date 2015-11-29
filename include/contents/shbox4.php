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

defined ('main') or die ( 'no direct access' );

include_once 'include/includes/class/shbox4class.php';

$var = NEW ShBox4();
if ($menu->get(0) == 'shbox4') {
    if(escape($_GET['shbox4'], 'string') == "go") {
        $var->shgo();
    } elseif (escape($_GET['shbox4'], 'string') == "send") {
        if (escape($_POST['txt'], 'string') == '') {
            return false;
        } else {
            if (loggedin()) {
                $var->shsend(escape($_POST['txt'], 'string'));
            } else {
                if ($var->shconfig('spam') == '1') {
                    if (isset($_POST['checkbox'])) {
                        $var->shsend(escape($_POST['txt'], 'string'));
                    } else {
                        return false;
                    }
                } else {
                    $var->shsend(escape($_POST['txt'], 'string'));
                }
            }
        }
    }
}

if (escape($menu->get(1), 'string') == 'archiv') {
    $title = $allgAr['title'] . ' :: ShBox4 Archiv ';
    $hmenu = 'ShBox4 Archiv';
    $design = new design ($title , $hmenu);
    $design->header();
    $var->sharchiv();
    $design->footer();
}
?>