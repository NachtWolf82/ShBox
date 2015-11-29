<?php
/*
Script     => ShBox 4.0P
Entwickler => WDS NachtWolf / B.Masmann
Seite/Sup. => http://www.ilch.de
Kontakt    => Masmann82@gmx.de
*/

defined ('main') or die ('no direct access');

class ShBox4 {
    var $version = 'ShBox 4.0P';
    var $text;
    var $name;
    // Auslesen der Configuration bitte nicht hier verändern dafür ist der Adminbereich gedacht ;)
    function shconfig($var) {
        $erg = db_query('SELECT * FROM `prefix_shbox4config` WHERE id = "1"');
        $row = db_fetch_assoc($erg);
        switch ($var) {
        case 0:
            return $row['ausgabe'];       //Anzahl wie viele Einträge in der ShBox ausgegeben werden sollen
            break;
        case 1:
            return $row['time'];;         //Die Reloadzeit
            break;
        case 2:
            return $row['datum'];         //Fragt ab ob Datum Aktiv oder Inaktiv ist
            break;
        case 3:
            return $row['aktiv'];         //Fragt ab ob die Box aktiv oder inaktiv ist
            break;
        case 4:
            return $row['farbe'];         //Fragt ab ob die Farben aktiv sind
            break;
        case 5:
            return $row['ngast'];         // Aktiv/Inakriv Farben für Name Gäste
            break;
        case 6:
            return $row['tgast'];         // Aktiv/Inakriv Farben für Text Gäste
            break;
        case 7:
            return $row['nuser'];         // Aktiv/Inakriv Farben für Name User
            break;
        case 8:
            return $row['tuser'];         // Aktiv/Inakriv Farben für Text User
            break;
        case 9:
            return $row['nadmin'];         // Aktiv/Inakriv Farben für Name Admin
            break;
        case 10:
            return $row['tadmin'];         // Aktiv/Inakriv Farben für Text Admin
            break;
        case 11:
            return $row['fngast'];         // Farben für Name Gäste
            break;
        case 12:
            return $row['ftgast'];         // Farben für Text Gäste
            break;
        case 13:
            return $row['fnuser'];         // Farben für Name User
            break;
        case 14:
            return $row['ftuser'];         // Farben für Text User
            break;
        case 15:
            return $row['fnadmin'];         // Farben für Name Admin
            break;
        case 16:
            return $row['ftadmin'];         // Farben für Text Admin
            break;
        case 17:
            return $row['smilies'];         // Prüft ob Smilies aktiv/Inaktiv
            break;
        case 18:
            return $row['size'];            // Eingabefeldgröße
            break;
        case 19:
            return $row['mtext'];           // Maximale Textlänge
            break;
        case 20:
            return $row['gast'];           // Gäste aktiv/Inaktiv
            break;
        case 21:
            return $row['format'];          // DatumFormat
            break;
        case 22:
            return $row['spam'];           // SPAM
            break;
        case 23:
            return $row['bbreite'];         // Breite der Box
            break;
        case 24:
            return $row['baus'];           // Ausrichtung der Box
            break;
        case 25:
            return $row['hfname'];          // Hintergrundfarbe vom namen
            break;
        case 26:
            return $row['hftext'];           // Hintergrundfarbe vom text
            break;
        case 27:
            return $row['hfinput'];          // Hintergrundfarbe vom inputfeld
            break;
        case 28:
            return $row['ausr'];             // Aktiv/Inaktiv Eigene Ausrichtung
            break;
        case 29:
            return $row['hgrund'];           // Aktiv/Inaktiv Eigene Hintergrundfarbe
            break;
        case 30:
            return $row['aktivtext'];        // Text wenn Box inaktiv ist
            break;
        case 31:
            return $row['bbfett'];        // BBcode Fett
            break;
        case 32:
            return $row['bbkursiv'];        // BBcode Kursiv
            break;
        case 33:
            return $row['bbunter'];        // BBcode Unterstrich
            break;
        case 34:
            return $row['bblink'];        // BBcode Link
            break;
        }
    }

    function shgo(){
        $tpl = new tpl ('shbox4', 0);
        $erg = db_query('SELECT * FROM `prefix_shbox4` ORDER BY `id` DESC LIMIT ' . $this->shconfig(0));
        while ($row = db_fetch_assoc($erg)) {
            $text = $row['txt'];
            $text = $this->shtext($text);
            if ($this->shconfig(28) == '1'){
                $breite = $this->shconfig(23);
                $baus   = $this->shconfig(24);
            } else {
                $breite = '100';
                $baus   = 'center';
            }
            if ($this->shconfig(29) == '1'){
                $hf1   = 'bgcolor="#'.$this->shconfig(25).'"';
                $hf2   = 'bgcolor="#'.$this->shconfig(26).'"';
            } else {
                $hf1   = '';
                $hf2   = '';
            }
                $ar = array ( 'NAME'       => $this->shdate($row['time'],$row['uid']),
                              'TEXT'       => $this->colortext($this->sh_usercheck($row['uid']), $text),
                              'BREITE'     => $breite,
                              'BAUS'       => $baus,
                              'HF1'        => $hf1,
                              'HF2'        => $hf2,
                );
                $tpl->set_ar_out($ar,1);
        }
    }

    function sharchiv () {
        $tpl = new tpl ('shbox4', 0);
        echo '<table width="100%" align="center" border="0" cellpadding="2" cellspacing="1" class="border">
               <tr class="Chead">
                <td align="center">
                 <h4>ShBox 4.0P Archiv</h4>
                </td>
               </tr>
              </table><br />';
        $erg = db_query('SELECT * FROM `prefix_shbox4` ORDER BY `id` DESC');
        while ($row = db_fetch_assoc($erg)) {
            $text = $row['txt'];
            $text = $this->shtext($text);
                $ar = array ( 'AUSGABE'       => '<td width="10%" class="Cdark">'.$this->shdate($row['time'],$row['uid']).'</td>
                                                  <td width="" class="Cnorm">'.$this->colortext($this->sh_usercheck($row['uid']), $text).'</td>'
                );
                $tpl->set_ar_out($ar,2);
        }
    }

    function showadmin() {
        $erg = db_query('SELECT * FROM `prefix_shbox4` ORDER BY `id` DESC');
        $class = '';
        while ($row = db_fetch_assoc($erg)) {
            $class = ($class == 'Cmite' ? 'Cnorm' : 'Cmite' );
                $var .= '<tr>
                         <td align="center" class="' . $class . '">' . $row['id'] . '.</td>
                         <td align="center" class="' . $class . '">' . $this->colorname($this->sh_usercheck($row['uid']), get_n($row['uid'])) . '</td>
                         <td class="' . $class . '">' . date ($this->shconfig(21), $row['time'] ) . '</td>
                         <td class="' . $class . '">' . BBcode(substr($row['txt'], 0, 70)) . '&nbsp;&nbsp;...</td>
                         <td class="' . $class . '" align="center"><a href="?shbox4admin-show-edit-' . $row['id'] . '"><img src="include/images/icons/edit.gif" alt="bearbeiten" title="bearbeiten"></a></td>
                         <td class="' . $class . '" align="center"><a href="admin.php?shbox4admin-show-del-' . $row['id'] . '"><img src="include/images/icons/del.gif" alt="löschen" title="löschen"></a>&nbsp;</td>
                        </tr>';
        }
        return $var;
    }
    
    function schowedit($gid) {
       $ed  = db_query('SELECT * FROM `prefix_shbox4` WHERE `id` = "' . $gid . '"');
       $e   = db_fetch_assoc($ed);
       return '<form action="?shbox4admin-show-send-'.$gid.'" method="POST">
             <tr>
              <td style="background-color:#FF0000">' . $e['id'] . '</td>
              <td style="background-color:#FF0000">' . get_n($e['uid']) . '</td>
              <td style="background-color: #FF0000">' . date ('d.m.Y - H:i:s', $e['time'] ) . '</td>
              <td style="background-color:#FF0000"><textarea name="edittxt" rows="2" cols="50" wrap="virtual">' . $e['txt'] . '</textarea></td>
              <td style="background-color: #FF0000" align="center"><input name="subedit" type="submit" value="ändern" /></td>
              <td style="background-color: #FF0000" align="center">&nbsp;</td>
             </tr>
            </form>';
    }

    function eingabe() {
        if ($this->shconfig(29) == '1'){
            $ein   = 'style="background-color:#'.$this->shconfig(27).'"';
        } else {
            $ein   = '';
        }
        if (loggedin()) {
            if ($this->shconfig(17) == '1') {
                echo '<center>'.getsmilies().'<br />';
                if ($this->shconfig(31) == '1') {
                    echo '<a href="javascript:simple(\'b\')"><img src="include/images/icons/button.bold.gif" alt="Fett" border="0" /></a>';
                }
                if ($this->shconfig(32) == '1') {
                    echo '<a href="javascript:simple(\'i\')"><img src="include/images/icons/button.italic.gif" alt="Kursiv" border="0" /></a>';
                }
                if ($this->shconfig(33) == '1') {
                    echo '<a href="javascript:simple(\'u\')"><img src="include/images/icons/button.underline.gif" alt="Unterstrich" border="0" /></a>';
                }
                if ($this->shconfig(34) == '1') {
                    echo '<a href="javascript:simple(\'url\')"><img src="include/images/icons/button.link.gif" alt="Link" border="0" /></a>';
                }
                echo '</center>';
            }
            echo '<form autocomplete="off" style="display:inline" method="post" action="javascript: send();" id="form">
                  <center>
                  <input type="text" name="txt" '.$ein.' id="txt" autocomplete="off" size="'.$this->shconfig(18).'" maxlength="'.$this->shconfig(19).'" onselect="" onclick="" onkeyup="">
                  </center>
                  </form>';
        } elseif ($this->shconfig(20) == '1') {
            if ($this->shconfig(17) == '1') {
                echo '<center>'.getsmilies().'</center>';
            }
            echo '<form autocomplete="off" style="display:inline" method="post" action="javascript: sendG();" id="form">
                  <center>';
            if ($this->shconfig(22) == '1') {
                $text = 'Bitte Häckchen setzte, ansonsten wird ihr Eintrag nicht abgesendet';
                echo 'SpamSchutz:<br />
                      <a href="" onmouseout="hideTooltip()" onmouseover="showTooltip(event,\''.$text.'\') ;return false"> ? </a>
                      <input type="checkbox" name="checkbox" id="checkbox" value="aktive" />
                      <br />';
            }
            echo '<input type="text" name="txt" style="background-color:#'.$ein.'" id="txt" autocomplete="off" size="'.$this->shconfig(18).'" maxlength="'.$this->shconfig(19).'" onselect="" onclick="" onkeyup="">
                  </center>
                  </form>';
         }
    }

    function shsend($text,$check) {
        if (loggedin()) {
            $uid = escape($_SESSION['authid'], 'string');
        } else {
            $uid = '0';
        }
        $posttxt = (isset($text)) ? escape($text, 'textarea') : '';
        $posttxt = strip_tags($posttxt);
        $posttxt = utf8_decode ($posttxt);
        if ($this->shconfig(2) == '1') {
            $time = time();
        } else {
            $time = '0';
        }
        if (isset($posttxt)) {
            db_query("INSERT INTO `prefix_shbox4` (`uid`,`txt`,`time`)
                     VALUES
                     ('" . $uid . "', '" . $posttxt . "', '" . $time . "')");
        }
    }

    function shtext($text) {
        if ($this->shconfig(17) == '1') {
            $tags = array('[img]', '[IMG]', '[/img]', '[/IMG]', '[url]', '[URL]', '[/URL]', '[URL]', '[color]', '[/color]');
            $tagsE = array ('/\[URL=http:\/\/(www\.)?(.*?)\](.*?)\[\/URL\]/si');
            $text = str_replace($tags, '', $text);
            $text = BBcode($text);
            $endtext = preg_replace('/([^\s]{18})(?=[^\s])/',"$1\n", $text);
            return $endtext;
        } else {
        $tags = array('[i]','[I]','[/i]','[/I]','[u]','[U]','[/u]','[/U]','[/B]','[/b]','[B]','[b]','[img]', '[IMG]', '[/img]', '[url]', '[/url]', '[color]', '[/color]', '[/IMG]' );
        $tagsE = array ('/\[url=http:\/\/(www\.)?(.*?)\](.*?)\[\/url\]/si', '/\[URL=http:\/\/(www\.)?(.*?)\](.*?)\[\/URL\]/si');
        $text = preg_replace('/([^\s]{18})(?=[^\s])/',"$1\n", $text);
        $text = preg_replace($tagsE, '', $text);
        $text = str_replace($tags, '', $text);
        return $text;
        }
    }

    function check_var($dbn, $name, $row, $url) {
        if($row == '0') {
            $var = '
              <form method="post" action="admin.php?shbox4admin-update-'.$dbn.'" id="form">
              <input type="hidden" name="id" id="id" value="0" />
              <input type="hidden" name="url" id="url" value="'.$url.'" />
               <button><span style="color:#808080;">'.$name.'</span></button>
              </form>';
        } elseif($row == '1') {
            $var = '
              <form method="post" action="admin.php?shbox4admin-update-'.$dbn.'" id="form">
              <input type="hidden" name="id" id="id" value="1" />
              <input type="hidden" name="url" id="url" value="'.$url.'" />
               <button><span style="color:#00FF00;">'.$name.'</span></button>
              </form>';
        } else {
            $var = 'error(#)';
        }
        return $var;
    }
    
    function shdate($time, $uid) {
        if ($this->shconfig(2) == '1') {
            return '<a href="?user-details-'.$uid.'" style="text-decoration: none;" onmouseout="hideTooltip()" onmouseover="showTooltip(event,\''.date ($this->shconfig(21), $time ).'\') ;return false">'.$this->colorname($this->sh_usercheck($uid), get_n($uid)).'</a>:';
        } else {
            return '<a href="?user-details-'.$uid.'" style="text-decoration: none;" onmouseout="hideTooltip()">'.$this->colorname($this->sh_usercheck($uid), get_n($uid)).'</a>:';
        }
    }

    function sh_usercheck($uid) {
        $erg = db_query('SELECT * FROM `prefix_user` WHERE id = '.$uid);
        $row = db_fetch_assoc($erg);
        $pr = db_num_rows($erg);
        if ($pr){
            if ($row['recht'] == '-9') {
                return '1';    //Admin
            } else {
                return '2';    //User
            }
        } else {
            return '0';    //GAST
        }
    }

    function colorname($var,$name) {
        if ($name == ''){
            $name = 'Gast';
        }
        if ($this->shconfig(4) == '1') {
            if ($var == '0') {
                $name = 'Gast';
                if ($this->shconfig(5) == '1') {
                    return '<span style="color:#'.$this->shconfig(11).';">'.$name.'</span>';
                } else {
                    return $name;
                }
            }
            if ($var == '1') {
                if ($this->shconfig(9) == '1') {
                    return '<span style="color:#'.$this->shconfig(15).';">'.$name.'</span>';
                } else {
                    return $name;
                }
            }
            if ($var == '2') {
                if ($this->shconfig(7) == '1') {
                    return '<span style="color:#'.$this->shconfig(13).';">'.$name.'</span>';
                } else {
                    return $name;
                }
            }
        } else {
            return $name;
        }
    }
    
    function colortext($var,$text) {
        if ($this->shconfig(4) == '1') {
            if ($var == '0') {
                if ($this->shconfig(6) == '1') {
                    return '<span style="color:#'.$this->shconfig(12).';">'.$text.'</span>';
                } else {
                    return $text;
                }
            }
            if ($var == '1') {
                if ($this->shconfig(10) == '1') {
                    return '<span style="color:#'.$this->shconfig(16).';">'.$text.'</span>';
                } else {
                    return $text;
                }
            }
            if ($var == '2') {
                if ($this->shconfig(8) == '1') {
                    return '<span style="color:#'.$this->shconfig(14).';">'.$text.'</span>';
                } else {
                    return $text;
                }
            }
        } else {
            return $text;
        }
    }

    function shfarben($var,$name,$var1,$var2,$url,$var3) {
         if ($var == '1'){
             return '<tr align="center" class="Chead">
                      <td align="center" class="Chead">'.$name.'</td>
                      <td align="center" class="Cmite">
                      <form method="post" action="admin.php?shbox4admin-updates-'.$var1.'" id="form">
                      <input type="hidden" name="url" id="url" value="'.$url.'" />
                      '.$this->shfeld($var1,$var2,$var3).'
                      </td>
                      </form>
                     </tr>';
         } else {
             return false ;
         }
    }
    
    function shfeld($var1,$var2,$var3){
        switch ($var3) {
            case 0:
            return '<input class="color" name="'.$var1.'" size="10" maxlength="10" value="'.$var2.'" />';
            break;
        case 1:
            return '<input name="'.$var1.'" size="10" maxlength="10" value="'.$var2.'" />';
            break;
        case 2:
            return '<select name="'.$var1.'" size="1" onChange="this.form.submit();"><option>'.$var2.'</option><option>left</option><option>center</option><option>right</option></select>';
            break;
        }
    }
    
    function shcheckbox($var,$aktiv,$var1,$name,$var2,$url,$var3) {
         if ($var == '1'){
             if ($aktiv == '1') {
                 $check = 'checked';
             return '<form method="post" action="admin.php?shbox4admin-updates-'.$var1.'" id="form">
                     <input type="hidden" name="url" id="url" value="'.$url.'" />
                     <img src="include/images/icons/button.'.$var3.'.gif" alt="'.$name.'" border="0" />
                     <input type="checkbox" onChange="this.form.submit();" name="'.$var1.'" value="0" '.$check.'>
                     </form>';
             } else {
                 $check = '/';
             return '<form method="post" action="admin.php?shbox4admin-updates-'.$var1.'" id="form">
                     <input type="hidden" name="url" id="url" value="'.$url.'" />
                     <img src="include/images/icons/button.'.$var3.'.gif" alt="'.$name.'" border="0" />
                     <input type="checkbox" onChange="this.form.submit();" name="'.$var1.'" value="1" '.$check.'>
                     </form>';
             }
         } else {
             return false ;
         }
    }
    
    //Ich Bitte freundlichs darum diese funktion nicht zu entfernen oder zu verändern
    function version() {
        //$g_version = '4';   //HauptVersion
        //$u_version = '000'; //Update/Fixes
        //$i_version = 'P';   //Ilch Version 1.1 ...
        //check_version($url, $g_version, $u_version, $i_version);
        echo '<table width="85%" align="center" border="0" cellpadding="5" cellspacing="1" class="border"><tr class="Chead"><td align="center">'.$this->version.' 2009-20015 &copy B.Masmann Support: <a target="_blank" href="http://www.ilch.de">ilch.de</a></td></tr></table>';
    }
}
?>