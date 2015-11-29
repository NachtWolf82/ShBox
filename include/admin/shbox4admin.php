<?php
/*
Script     => ShBox 4.0P
Entwickler => WDS NachtWolf / B.Masmann
Seite/Sup. => http://www.ilch.de
Kontakt    => Masmann82@gmx.de
*/

defined ('main') or die ('no direct access');
defined ('admin') or die ('only admin access');

$design = new design('Admins Area', 'Admins Area', 2);
$design->addheader('<link rel="stylesheet" type="text/css" href="include/images/shbox4/shbox4.css" />
                    <script type="text/javascript" charset="utf-8" src="include/includes/js/shbox4.js"></script>
                    <script type="text/javascript" src="include/includes/js/jscolor.js"></script>');
$design->header();
include ('include/includes/class/shbox4class.php');
$var = NEW ShBox4();
$tpl = new tpl('shbox4admin',1);

if ($var->shconfig(4) == '1') {
    $ar  = array(
            'FARBE'  => '<th align="center" class="Cmite"><a href="?shbox4admin-farben"> Farben </a></th>'
    );
    $tpl->set_ar_out($ar,0);
}else {
    $ar  = array(
            'FARBE'  => ''
    );
    $tpl->set_ar_out($ar,0);
}

if (escape($menu->get(1), 'string') == 'update'){
$var1 = escape($menu->get(2), 'string');
$var2 = escape($_POST['id'], 'string');
$var3 = escape($_POST['url'], 'string');
    if ($var2 == '0') {
        db_query("UPDATE `prefix_shbox4config`
        SET
                `$var1`   = '1'
        WHERE
                `id` = '1'
        ") OR die('Probleme mit der Datenbank');
        wd('?shbox4admin-'.$var3 , ''  , 0 );
    } elseif ($var2 == '1') {
        db_query("UPDATE `prefix_shbox4config`
        SET
                `$var1`   = '0'
        WHERE
                `id` = '1'
        ") OR die('Probleme mit der Datenbank');
        wd('?shbox4admin-'.$var3 , ''  , 0 );
    }
}

if (escape($menu->get(1), 'string') == 'updates'){
    $var1 = escape($menu->get(2), 'string');
    $var2 = escape($_POST[$var1], 'string');
    $var3 = escape($_POST['url'], 'string');
    db_query("UPDATE `prefix_shbox4config`
              SET
                 `$var1`   = '".$var2."'
              WHERE
                `id` = '1'
             ") OR die('Probleme mit der Datenbank');
    wd('?shbox4admin-'.$var3 , ''  , 0 );
}

if (escape($menu->get(1), 'string') == 'show'){
    if (escape($menu->get(2), 'string') == 'send'){
        db_query("UPDATE `prefix_shbox4`
        SET `txt` = '" . escape($_POST['edittxt'], 'string') . "'
                WHERE `id` = '" . escape($menu->get(3), 'string') . "'
        ")OR die('Probleme mit der Datenbank');
    } elseif (escape($menu->get(2), 'string') == 'del') {
        db_query("DELETE FROM `prefix_shbox4` WHERE `id` = '" . escape($menu->get(3), 'string')."'")OR die('Probleme mit der Datenbank');
    }
}

if (escape($menu->get(1), 'string') == 'allg'){
    $erg = db_query('SELECT * FROM `prefix_shbox4config` WHERE id = "1"');
    $row = db_fetch_assoc($erg);
    $url = 'allg';
    $ar  = array(
        'AKTIV'               => $var->check_var('aktiv', 'Aktiv', $row['aktiv'],$url),
        'GAST'                => $var->check_var('gast', 'Gast', $row['gast'],$url),
        'RELOAD'              => $var->check_var('reload', 'Reload', $row['reload'],$url),
        'DATUM'               => $var->check_var('datum', 'Datum', $row['datum'],$url),
        'FARBEN'              => $var->check_var('farbe', 'Farben', $row['farbe'],$url),
        'SPAM'                => $var->check_var('spam', 'SPAM', $row['spam'],$url),
        'SMILIES'             => $var->check_var('smilies', 'Smilies & BBcode', $row['smilies'],$url),
        'RTIME'               => $row['time'],
        'DBN1'                => 'time',
        'AKTIVTEXT'           => $row['aktivtext'],
        'DBN11'               => 'aktivtext',
        'AUSGABE'             => $row['ausgabe'],
        'DBN2'                => 'ausgabe',
        'DATUMF'              => $row['format'],
        'DBN3'                => 'format',
        'SIZE'                => $row['size'],
        'DBN4'                => 'size',
        'MTEXT'               => $row['mtext'],
        'DBN5'                => 'mtext',
        'BBFETT'              => $var->shcheckbox($var->shconfig(17), $var->shconfig(31), 'bbfett', 'Fett', $row['bbfett'], $url, 'bold'),
        'BBKURSIV'            => $var->shcheckbox($var->shconfig(17), $var->shconfig(32), 'bbkursiv', 'Kursiv', $row['bbkursiv'], $url, 'italic'),
        'BBUNTER'             => $var->shcheckbox($var->shconfig(17), $var->shconfig(33), 'bbunter', 'Unterstrich', $row['bbunter'], $url, 'underline'),
        'BBLINK'              => $var->shcheckbox($var->shconfig(17), $var->shconfig(34), 'bblink', 'Link', $row['bblink'], $url, 'link')
    );
    $tpl->set_ar_out($ar,1);
}

if (escape($menu->get(1), 'string') == 'farben'){
    $erg = db_query('SELECT * FROM `prefix_shbox4config` WHERE id = "1"');
    $row = db_fetch_assoc($erg);
    $url = 'farben';
    $ar  = array(
        'GASTNAME'            => $var->check_var('ngast', 'Name Gäste', $row['ngast'],$url),
        'GASTTEXT'            => $var->check_var('tgast', 'Text Gäste', $row['tgast'],$url),
        'USERNAME'            => $var->check_var('nuser', 'Name User', $row['nuser'],$url),
        'USERTEXT'            => $var->check_var('tuser', 'Text User', $row['tuser'],$url),
        'ADMINNAME'           => $var->check_var('nadmin', 'Name Admin', $row['nadmin'],$url),
        'ADMINTEXT'           => $var->check_var('tadmin', 'Text Admin', $row['tadmin'],$url),
        'NGAST'               => $var->shfarben($var->shconfig(5), 'Farbe: Name der Gäste', 'fngast', $row['fngast'],$url,0),
        'TGAST'               => $var->shfarben($var->shconfig(6), 'Farbe:Text der Gäste', 'ftgast', $row['ftgast'],$url,0),
        'NUSER'               => $var->shfarben($var->shconfig(7), 'Farbe:Name der User', 'fnuser', $row['fnuser'],$url,0),
        'TUSER'               => $var->shfarben($var->shconfig(8), 'Farbe:Text der User', 'ftuser', $row['ftuser'],$url,0),
        'NADMIN'              => $var->shfarben($var->shconfig(9), 'Farbe:Name der Admins', 'fnadmin', $row['fnadmin'],$url,0),
        'TADMIN'              => $var->shfarben($var->shconfig(10), 'Farbe:Text der Admins', 'ftadmin', $row['ftadmin'],$url,0)
    );
    $tpl->set_ar_out($ar,2);
}

if (escape($menu->get(1), 'string') == 'style'){
    $erg = db_query('SELECT * FROM `prefix_shbox4config` WHERE id = "1"');
    $row = db_fetch_assoc($erg);
    $url = 'style';
    $ar  = array(
        'AUSRICHTUNG'         => $var->check_var('ausr', 'Eigene Ausrichtung', $row['ausr'],$url),
        'HINTERGRUND'         => $var->check_var('hgrund', 'Eigener Hintergrund', $row['hgrund'],$url),
        'BBREITE'             => $var->shfarben($var->shconfig(28), 'Breite der Box in %', 'bbreite', $row['bbreite'],$url,1),
        'BAUS'                => $var->shfarben($var->shconfig(28), 'Ausrichtung der Box', 'baus', $row['baus'],$url,2),
        'HFNAME'              => $var->shfarben($var->shconfig(29), 'Hintergrundfarbe vom Namen', 'hfname', $row['hfname'],$url,0),
        'HFTEXT'              => $var->shfarben($var->shconfig(29), 'Hintergrundfarbe vom Text', 'hftext', $row['hftext'],$url,0),
        'HFINPUT'             => $var->shfarben($var->shconfig(29), 'Hintergrundfarbe vom Eingabefeld', 'hfinput', $row['hfinput'],$url,0)
    );
    $tpl->set_ar_out($ar,3);
}

if (escape($menu->get(1), 'string') == 'show'){
    $men = escape($menu->get(2), 'string');
    switch ($men) {
        case 'edit':
        $ar  = array('EDIT'          => $var->schowedit(escape($menu->get(3), 'string')),
                     'LISTE'         => $var->showadmin()
        );
        break;
        default:
        $ar  = array('EDIT'          => '',
                     'LISTE'         => $var->showadmin()
        );
        break;
    }
    $tpl->set_ar_out($ar,4);
}

$var->version();
$design->footer();
?>