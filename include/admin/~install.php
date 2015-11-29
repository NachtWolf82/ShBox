<?php
/*
Script     => IU_Modul V1.0
Entwickler => WDS NachtWolf / B.Masmann
Seite/Sup. => http://www.ilch.de
Kontakt    => Masmann82@gmx.de
*/

defined ('main') or die ('no direct access');
defined ('admin') or die ('only admin access');

$design = new design ('Admins Area', 'Admins Area', 2);
$design->header();

// Script Konfiguration
$scripter           = 'B.Masmann / WDS NachtWolf';    // Name des Autors des Moduls
$script_name        = 'ShBox';                        // Name des Moduls
$script_vers        = '4.0P';                         // Version des Moduls
$ilch_vers          = '1.1';                          // Version des ilchClan Scripts
$ilch_update        = 'P';                            // Update des ilchClan Scripts
$variante           = 'Installation / Update';        // Installationsmöglichkeiten
$readme             = 'README.txt';                   // Name der Readme / muss im "include/admin/" liegen.


if (escape($menu->get(0), 'string') == 'install'){
    $tpl = new tpl('install',1);
    switch(escape($menu->get(1), 'string')){
        case ('1'):
        $text = 'Bevor ihr fortfährt arbeitet bitte folgene Liste ab: <br /><br /><b>
                *Ich verwende die Aktuelle Ilch Version 1.1P <br />
                *Ich habe einen aktuellen Backup der Datenbank gemacht <br />
                *Ich habe alle Datein aus den Upload Order hochgeladen <br />
                *Und ich habe die README aufmerksam gelsen und Verstanden <br />
                 <br />
                 WICHTIG:Bei Probleme wende ich mich an ilch.de und benutze dort die SuFu um eventuell eine Lösung zu finden.</b>
                 ';
        $ar  = array('SNAME'           => $script_name,
                     'SVERSION'        => $script_vers,
                     'ENTWICK'         => $scripter,
                     'TEXT'            => $text,
                     'VARIANTE'        => old_ver_check()
               );
        $tpl->set_ar_out($ar,1);
        break;
        case ('2'):
        switch(escape($menu->get(2), 'string')){
            case ('update'):
            $ar  = array('SNAME'           => $script_name,
                         'SVERSION'        => $script_vers,
                         'ENTWICK'         => $scripter,
                         'TEXT'            => update()
               );
            $tpl->set_ar_out($ar,2);
            break;
            case ('installerw'):
            $ar  = array('SNAME'           => $script_name,
                         'SVERSION'        => $script_vers,
                         'ENTWICK'         => $scripter,
                         'TEXT'            => install_erw()
               );
            $tpl->set_ar_out($ar,2);
            break;
            case ('install'):
            $ar  = array('SNAME'           => $script_name,
                         'SVERSION'        => $script_vers,
                         'ENTWICK'         => $scripter,
                         'TEXT'            => install_nor()
               );
            $tpl->set_ar_out($ar,2);
            break;
            default:
                echo 'Fehler';
            break;
        }
        break;
        default:
        $ar  = array('SNAME'         => $script_name,
                     'SVERSION'      => $script_vers,
                     'ENTWICK'       => $scripter,
                     'IVERSION'      => $ilch_vers,
                     'IUPDATE'       => $ilch_update,
                     'VARIANTE'      => $variante,
                     'README'        => $readme
               );
        $tpl->set_ar_out($ar,0);
        break;
    }
}

function old_ver_check() {
    $sql  = db_query("SELECT * FROM `prefix_modules` WHERE url = BINARY 'shboxadmin'");
    $erg  = db_fetch_assoc($sql);
    $sql1 = @db_query('SELECT COUNT(*) AS zahl FROM `prefix_shoutbox`');
    $res1 = @db_fetch_assoc($sql1);
    if (!empty($erg)) {
        return '<span style="color:#FF0000;">Sie besitzen aktuell die ShBox 3.2, wir legen ihnen nahe mit einen Update fortzufahren.<br />
                <b>Vorteile:</b><br />
                <i>* Die Vorhandenen ShBox Einträge werden übernommen<br />
                * Alle nicht benötigen Datein und Datenbankeinträge der ShBox 3.2 werden gelöscht.<br />
                * Eventuelle auftretene Komplikationen mit der neuen Version werden damit umgangen.</i></span><br /><br />
                <form action="admin.php?install-2-update" method="POST">
                 <input type="submit" value="Mit Update Fortfahren >>" />
                </form>';
    } elseif ($res1['zahl'] > 9) {
        return '<span style="color:#FF0000;">Sie benutzen Aktuell die Orginale Shoutbox von Ilch, führen sie die Erweiterte Installation aus.<br />
                    <b>Vorteile:</b><br />
                    <i>* Die Vorhandenen Shoutbox Einträge werden übernommen<br />
                       * Die Einträge und Orginalen Datein der Shoutbox bleiben bestehen</i></span><br /><br />
                    <form action="admin.php?install-2-installerw" method="POST">
                     <input type="submit" value="Mit Erweiterte Installation Fortfahren >>" />
                    </form>';
    } else {
        return 'Es Existiert keine alte Version sowie nutzen Sie aktiv nicht die Orginale Shoutbox, daher können Sie die Normale Installation wählen.<br /><br />
                <form action="admin.php?install-2-install" method="POST">
                 <input type="submit" value="Mit Installation Fortfahren >>" />
                </form>';
    }
}

function update() {
    if (erstelle_config() == true && erstelle_update() == true) {
        if(@unlink('include/admin/install.php') &&
           @unlink('include/admin/templates/install.htm') &&
           @unlink('include/admin/shboxshow.php') &&
           @unlink('include/admin/shboxadmin.php') &&
           @unlink('include/admin/templates/shboxadmin.htm') &&
           @unlink('include/admin/README.txt') &&
           @unlink('include/boxes/shbox.php') &&
           @unlink('include/contents/shbox.php') &&
           @unlink('include/images/load.gif') &&
           @unlink('include/includes/js/shbox/shbox.css') &&
           @unlink('include/includes/js/shbox/shbox.js') &&
           @unlink('include/includes/js/shbox/shboxfunc.php') &&
           @unlink('include/templates/shbox.htm') &&
           @unlink('include/images/icons/admin/shboxadmin.png') &&
           @unlink('include/images/icons/admin/shboxshow.png')) {
            return '<span style="color:#00FF00;">Der Update war Erfolgreich</span><br /><br />
                    <form action="admin.php" method="POST">
                     <input type="submit" value="Installation Abschließen" />
                    </form>';
        } else {
            return 'Die Installationsdateien konnten eventuell nicht automatisch gel&ouml;scht werden.
                    L&ouml;schen Sie folgende Dateien:<br /><br />
                    <i>include/admin/install.php</i><br />
                    <i>include/admin/templates/install.htm</i><br />
                    <i>include/admin/shboxadmin.php</i><br />
                    <i>include/admin/shboxshow.php</i><br />
                    <i>include/admin/templates/shboxadmin.htm</i><br />
                    <i>include/boxes/shbox.php</i><br />
                    <i>include/contents/shbox.php</i><br />
                    <i>include/images/load.gif</i><br />
                    <i>include/images/icons/admin/shboxadmin.png</i><br />
                    <i>include/images/icons/admin/ahboxshow.png</i><br />
                    <i>include/includes/js/shbox/shbox.css</i><br />
                    <i>include/includes/js/shbox/shbox.js</i><br />
                    <i>include/includes/js/shbox/shboxfunc.php</i><br />
                    <i>include/templates/shbox.htm</i><br />
                    <span style="color:#00FF00;">Der Update war Erfolgreich</span><br /><br />
                    <form action="admin.php" method="POST">
                     <input type="submit" value="Installation Abschließen" />
                    </form>';
        }
    } else {
        return 'Es sind fehler Aufgetreten!!';
    }
}

function install_nor() {
    if (erstelle_config() == true && erstelle_show() == true) {
        if(@unlink('include/admin/install.php') && @unlink('include/admin/templates/install.htm')) {
            return '<span style="color:#00FF00;">Die Installation war Erfolgreich</span><br /><br />
                    <form action="admin.php" method="POST">
                     <input type="submit" value="Installation Abschließen" />
                    </form>';
        } else {
            return 'Die Installationsdateien konnten eventuell nicht automatisch gel&ouml;scht werden.
                    L&ouml;schen Sie folgende Dateien:<br /><br />
                    <i>include/admin/install.php</i><br />
                    <i>include/admin/templates/install.htm</i>
                    <span style="color:#00FF00;">Die Installation war Erfolgreich</span><br /><br />
                    <form action="admin.php" method="POST">
                     <input type="submit" value="Installation Abschließen" />
                    </form>';
        }
    } else {
        return 'Es sind fehler Aufgetreten!!';
    }
}

function install_erw() {
    if (erstelle_config() == true && erstelle_update_shoutbox() == true) {
        if(@unlink('include/admin/install.php') && @unlink('include/admin/templates/install.htm')) {
            return '<span style="color:#00FF00;">Die Installation & Übernahme der alten Shoutbox war Erfolgreich</span><br /><br />
                    <form action="admin.php" method="POST">
                     <input type="submit" value="Installation Abschließen" />
                    </form>';
        } else {
            return 'Die Installationsdateien konnten eventuell nicht automatisch gel&ouml;scht werden.
                    L&ouml;schen Sie folgende Dateien:<br /><br />
                    <i>include/admin/install.php</i><br />
                    <i>include/admin/templates/install.htm</i>
                    <span style="color:#00FF00;">Die Installation & Übernahme der alten Shoutbox war Erfolgreich</span><br /><br />
                    <form action="admin.php" method="POST">
                     <input type="submit" value="Installation Abschließen" />
                    </form>';
        }
    } else {
        return 'Es sind fehler Aufgetreten!!';
    }
}

function erstelle_config() {
    $sql_befehl3 = db_query("CREATE TABLE IF NOT EXISTS `prefix_shbox4config` (
                    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
                    `aktiv` varchar(2) DEFAULT '0' NOT NULL,
                    `aktivtext` text NOT NULL,
                    `gast` varchar(2) NOT NULL,
                    `reload` varchar(2) DEFAULT '0' NOT NULL,
                    `datum` int(2) DEFAULT '0' NOT NULL,
                    `spam` varchar(2) DEFAULT '0' NOT NULL,
                    `smilies` varchar(2) NOT NULL,
                    `time` text NOT NULL,
                    `ausgabe` text NOT NULL,
                    `format` text NOT NULL,
                    `size` varchar(5) NOT NULL,
                    `mtext` varchar(50) NOT NULL,
                    `farbe` varchar(2) DEFAULT '0' NOT NULL,
                    `ngast` varchar(2) DEFAULT '0' NOT NULL,
                    `tgast` varchar(2) DEFAULT '0' NOT NULL,
                    `nuser` varchar(2) DEFAULT '0' NOT NULL,
                    `tuser` varchar(2) DEFAULT '0' NOT NULL,
                    `nadmin` varchar(2) DEFAULT '0' NOT NULL,
                    `tadmin` varchar(2) DEFAULT '0' NOT NULL,
                    `fngast` text NOT NULL,
                    `ftgast` text NOT NULL,
                    `fnuser` text NOT NULL,
                    `ftuser` text NOT NULL,
                    `fnadmin` text NOT NULL,
                    `ftadmin` text NOT NULL,
                    `bbreite` varchar(20) NOT NULL,
                    `baus` varchar(20) NOT NULL,
                    `hfname` varchar(20) NOT NULL,
                    `hftext` varchar(20) NOT NULL,
                    `hfinput` varchar(20) NOT NULL,
                    `ausr` varchar(2) NOT NULL,
                    `hgrund` varchar(2) NOT NULL,
                    `bbfett` varchar(2) NOT NULL,
                    `bbkursiv` varchar(2) NOT NULL,
                    `bbunter` varchar(2) NOT NULL,
                    `bblink` varchar(2) NOT NULL,
                    PRIMARY KEY (`id`)
                  )");
    $sql_befehl4 = db_query("INSERT INTO `prefix_shbox4config` (`id`,`aktiv`,`aktivtext`,`gast`,`reload`,`datum`,`spam`,`smilies`,`time`,`ausgabe`,`format`,`size`,`mtext`,`farbe`,`ngast`,`tgast`,`nuser`,`tuser`,`nadmin`,`tadmin`,`fngast`,`ftgast`,`fnuser`,`ftuser`,`fnadmin`,`ftadmin`,`bbreite`,`baus`,`hfname`,`hftext`,`hfinput`,`ausr`,`hgrund`,`bbfett`,`bbkursiv`,`bbunter`,`bblink`) VALUES
    ('1','1','Die ShBox wurde derzeit Deaktiviert!!','1','1','1','1','1','2000','6','d.m.Y - H:i:s','15','100','1','0','0','0','0','0','0','FFFFFF','FFFFFF','FFFFFF','FFFFFF','FFFFFF','FFFFFF','95','center','FFFFFF','FFFFFF','FFFFFF','0','0','1','1','1','1')");
    if (mysql_error()) {
        return false;
    } else {
        return true;
    }
}

function erstelle_show() {
    db_query("CREATE TABLE IF NOT EXISTS `prefix_shbox4` (
                          `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
                          `uid` mediumint(8),
                          `txt` text,
                          `time` bigint(20),
                          PRIMARY KEY (id)
                          )");
    db_query("INSERT INTO `prefix_shbox4` (`id`, `uid`, `txt`, `time`) VALUES
                          ('1','1','Willkommen bei der [b]ShBox4.0P[/b] 2009-2015 © B.Masmann Support findet ihr bei [url=http://www.ilch.de]ilch.de[/url]','1441970111')");
    db_query("INSERT INTO `prefix_modules` ( `id` , `url` , `name` , `gshow` , `ashow` , `fright` ) VALUES (NULL , 'shbox4admin', 'ShBox4 Einstellungen', '0', '1', '1');");
    if (mysql_error()) {
        return false;
    } else {
        return true;
    }
}

function erstelle_update() {
    db_query("CREATE TABLE IF NOT EXISTS `prefix_shbox4` (
             `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
             `uid` mediumint(8),
             `txt` text,
             `time` bigint(20),
             PRIMARY KEY (id)
             )");
    $erg1 = db_fetch_assoc(db_query("SELECT * FROM `prefix_modules` WHERE name= BINARY 'ShBox Einträge'"));
    $erg2 = db_fetch_assoc(db_query("SELECT * FROM `prefix_modules` WHERE name= BINARY 'ShBox Einstellungen'"));
    db_query("DELETE FROM `prefix_modules` WHERE `id` = '".$erg1['id']."'");
    db_query("UPDATE `prefix_modules` SET
             `url`  = 'shbox4admin',
             `name` = 'ShBox4 Einstellungen'
             WHERE `id` = ".$erg2['id']);
    $sql = db_query('SELECT * FROM `prefix_shbox`') or die(mysql_error());
    $sql_backup .= "INSERT INTO `prefix_shbox4` (`uid`, `txt`) VALUES ";
    while($ds = mysql_fetch_object($sql)){
        $erg = mysql_fetch_object(db_query("SELECT * FROM `prefix_user` WHERE name= BINARY '".$ds->name."'"));
        $sql_backup .= "(";
        $sql_backup .= $erg->id.", ";
        $sql_backup .= "'".$ds->txt."'";
        $sql_backup .= "),\n";
    }
    $sql_backup .= "(1,'Willkommen bei der [b]ShBox4.0P[/b] 2009-2015 © B.Masmann Support findet ihr bei [url=http://www.ilch.de]ilch.de[/url]');";
    db_query($sql_backup);
    if (mysql_error()) {
        return false;
    } else {
        db_query('DELETE FROM `prefix_shbox`');
        db_query('DELETE FROM `prefix_shbox_config`');
        db_query('DROP TABLE `prefix_shbox`');
        db_query('DROP TABLE `prefix_shbox_config`');
        return true;
    }
}

function erstelle_update_shoutbox() {
    db_query("CREATE TABLE IF NOT EXISTS `prefix_shbox4` (
             `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
             `uid` mediumint(8),
             `txt` text,
             `time` bigint(20),
             PRIMARY KEY (id)
             )");
    db_query("INSERT INTO `prefix_modules` ( `id` , `url` , `name` , `gshow` , `ashow` , `fright` ) VALUES (NULL , 'shbox4admin', 'ShBox4 Einstellungen', '0', '1', '1');");
    $sql = db_query('SELECT * FROM `prefix_shoutbox`') or die(mysql_error());
    $sql_backup .= "INSERT INTO `prefix_shbox4` (`uid`, `txt`) VALUES ";
    while($ds = mysql_fetch_object($sql)){
        $erg = mysql_fetch_object(db_query("SELECT * FROM `prefix_user` WHERE name= BINARY '".$ds->nickname."'"));
        $sql_backup .= "(";
        $sql_backup .= $erg->id.", ";
        $sql_backup .= "'".$ds->textarea."'";
        $sql_backup .= "),\n";
    }
    $sql_backup .= "(1,'Willkommen bei der [b]ShBox4.0P[/b] 2009-2015 © B.Masmann Support findet ihr bei [url=http://www.ilch.de]ilch.de[/url]');";
    db_query($sql_backup);
    
    if (mysql_error()) {
        return false;
    } else {
        return true;
    }
}

$design->footer();
?>