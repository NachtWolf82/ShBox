<?php
/*
Script     => ShBox 4.0P
Entwickler => WDS NachtWolf / B.Masmann
Seite/Sup. => http://www.ilch.de
Kontakt    => Masmann82@gmx.de
*/
defined ('main') or die ( 'no direct access' );
include_once 'include/includes/class/shbox4class.php';

$var = NEW ShBox4();

if ($menu->get(0) == 'shbox4') {
    if(escape($_GET['shbox4'], 'string') == "go") {
        $var->shgo();
    } elseif (escape($_GET['shbox4'], 'string') == "send") {
        if (escape ($_POST['txt'], 'string') == '') {
            return false;
        } else {
            if (loggedin()) {
                $var->shsend(escape ($_POST['txt'], 'textarea'));
            } else {
                if ($var->shconfig(22) == '1') {
                    if (isset($_POST['checkbox'])) {
                        $var->shsend(escape ($_POST['txt'], 'textarea'));
                    } else {
                        return false;
                    }
                } else {
                    $var->shsend(escape ($_POST['txt'], 'textarea'));
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