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

class ShBox4 {
    var $version = 'ShBox 4.1Q';
    var $text;
    var $name;
    function shconfig($var) {
        $row = db_fetch_assoc(db_query('SELECT * FROM `prefix_shbox4config` WHERE id = "1"'));
        return $row[$var];
    }

    function shgo(){
        $tpl = new tpl ('shbox4', 0);
        $erg = db_query('SELECT * FROM `prefix_shbox4` ORDER BY `id` DESC LIMIT '. $this->shconfig('ausgabe'));
        while ($row = db_fetch_assoc($erg)) {
            $text = $row['txt'];
            $text = $this->shtext($text);
            if ($this->shconfig('ausr') == '1'){
                $breite = $this->shconfig('bbreite');
                $baus   = $this->shconfig('baus');
            } else {
                $breite = '100';
                $baus   = 'center';
            }
            if ($this->shconfig('hgrund') == '1'){
                $hf1   = 'style="background-color:#'.$this->shconfig('hfname').'"';
                $hf2   = 'style="background-color:#'.$this->shconfig('hftext').'"';
            } else {
                $hf1   = 'class="Cdark"';
                $hf2   = 'class="Cnorm"';
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
        echo '<div>
                 <h4 align="center" class="Chead">'.$this->version.' Archiv</h4>
              </div>';
        $erg = db_query('SELECT * FROM `prefix_shbox4` ORDER BY `id` DESC');
        while ($row = db_fetch_assoc($erg)) {
            $text = $row['txt'];
            $text = $this->shtext($text);
                $ar = array ( 'AUSGABE'   => '<p class="Cdark" style="margin:0;">'.$this->shdate($row['time'],$row['uid']).'</p>
                                              <p class="Cnorm" style="margin:0;">'.$this->colortext($this->sh_usercheck($row['uid']), $text).'</p>
                                              <br />'
                );
                $tpl->set_ar_out($ar,2);
        }
            $tpl->set_ar(array('VERS' => $this->version()));
            $tpl->out(3);
    }

/*
##
## TO-TO in bearbeitung
##
Adminberreich noch der Akzuellen Ilch 1.1Q Adminlayout Anpassen & Fixen
*/
    function showadmin() {
        $erg = db_query('SELECT * FROM `prefix_shbox4` ORDER BY `id` DESC');
        $class = '';
        while ($row = db_fetch_assoc($erg)) {
            $class = ($class == 'Cmite' ? 'Cnorm' : 'Cmite' );
                $var .= '<tr>
                         <td align="center" class="' . $class . '">' . $row['id'] . '.</td>
                         <td align="center" class="' . $class . '">' . $this->colorname($this->sh_usercheck($row['uid']), get_n($row['uid'])) . '</td>
                         <td class="' . $class . '">' . date ($this->shconfig('format'), $row['time'] ) . '</td>
                         <td class="' . $class . '">' . BBcode(substr($row['txt'], 0, 70)) . '&nbsp;&nbsp;...</td>
                         <td class="' . $class . '" align="center"><a href="?shbox4admin-show-edit-' . $row['id'] . '" rel="tooltip" title="Eintrag Ändern"><span style="color:#2D9600;" class="glyphicon glyphicon-edit" aria-hidden="true"></a></td>
                         <td class="' . $class . '" align="center"><a href="admin.php?shbox4admin-show-del-' . $row['id'] . '" rel="tooltip" title="Löschen"><span style="color:#AD0000;" class="glyphicon glyphicon-trash" aria-hidden="true"></a></td>
                        </tr>';
        }
        return $var;
    }

/*
#
#Siehe TO-DO
#
*/
    function showedit($gid) {
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
        if ($this->shconfig('hgrund') == '1'){
            $ein   = 'style="background-color:#'.$this->shconfig('hfinput').'"';
        } else {
            $ein   = '';
        }
        if (loggedin()) {
            if ($this->shconfig('smilies') == '1') {
                echo '<center>'.getsmilies().'<br />';
                if ($this->shconfig('bbfett') == '1') {
                    echo '<a href="javascript:simple(\'b\')"><img src="include/images/icons/button.bold.gif" alt="Fett" border="0" /></a>';
                }
                if ($this->shconfig('bbkursiv') == '1') {
                    echo '<a href="javascript:simple(\'i\')"><img src="include/images/icons/button.italic.gif" alt="Kursiv" border="0" /></a>';
                }
                if ($this->shconfig('bbunter') == '1') {
                    echo '<a href="javascript:simple(\'u\')"><img src="include/images/icons/button.underline.gif" alt="Unterstrich" border="0" /></a>';
                }
                if ($this->shconfig('bblink') == '1') {
                    echo '<a href="javascript:simple(\'url\')"><img src="include/images/icons/button.link.gif" alt="Link" border="0" /></a>';
                }
                echo '</center>';
            }
            echo '<form autocomplete="off" style="display:inline" method="post" action="javascript: send();" id="form">
                  <input type="text" name="txt" '.$ein.' id="txt" autocomplete="off" size="'.$this->shconfig('size').'" maxlength="'.$this->shconfig('mtext').'" onselect="" onclick="" onkeyup="">
                  </form>';
        } elseif ($this->shconfig('gast') == '1') {
            if ($this->shconfig('smilies') == '1') {
                echo getsmilies();
            }

            echo '<form autocomplete="off" style="display:inline" method="post" action="javascript: sendG();" id="form">';
            if ($this->shconfig('spam') == '1') {
                $text = '<p>Bitte Häckchen setzte, ansonsten wird ihr Eintrag nicht abgesendet</p>';
                echo 'SpamSchutz:<br />
                      <a href="" onmouseout="hideTooltip()" onmouseover="showTooltip(event,\''.$text.'\') ;return false"> ? </a>
                      <input type="checkbox" name="checkbox" id="checkbox" value="aktive" />
                      <br />';
            }
            echo '<input type="text" name="txt" '.$ein.' id="txt" autocomplete="off" size="'.$this->shconfig('size').'" maxlength="'.$this->shconfig('mtext').'" onselect="" onclick="" onkeyup="">
                  </form>';
         }
    }

    function shsend($text,$check) {
        if (loggedin()) {
            $uid = escape($_SESSION['authid'], 'string');
        } else {
            $uid = '0';
        }
        $posttxt = (isset($text)) ? escape($text, 'string') : '';
        $posttxt = strip_tags($posttxt);
        $posttxt = utf8_decode ($posttxt);
        if ($this->shconfig('datum') == '1') {
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
        if ($this->shconfig('smilies') == '1') {
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
        if ($this->shconfig('datum') == '1') {
            return '<a href="?user-details-'.$uid.'" style="text-decoration: none;" onmouseout="hideTooltip()" onmouseover="showTooltip(event,\''.date ($this->shconfig(format), $time ).'\') ;return false">'.$this->colorname($this->sh_usercheck($uid), get_n($uid)).'</a>:';
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
        if ($this->shconfig('farbe') == '1') {
            if ($var == '0') {
                $name = 'Gast';
                if ($this->shconfig('ngast') == '1') {
                    return '<span style="color:#'.$this->shconfig('fngast').';">'.$name.'</span>';
                } else {
                    return $name;
                }
            }
            if ($var == '1') {
                if ($this->shconfig('nadmin') == '1') {
                    return '<span style="color:#'.$this->shconfig('fnadmin').';">'.$name.'</span>';
                } else {
                    return $name;
                }
            }
            if ($var == '2') {
                if ($this->shconfig('nuser') == '1') {
                    return '<span style="color:#'.$this->shconfig('fnuser').';">'.$name.'</span>';
                } else {
                    return $name;
                }
            }
        } else {
            return $name;
        }
    }

    function colortext($var,$text) {
        if ($this->shconfig('farbe') == '1') {
            if ($var == '0') {
                if ($this->shconfig('tgast') == '1') {
                    return '<span style="color:#'.$this->shconfig('ftgast').';">'.$text.'</span>';
                } else {
                    return $text;
                }
            }
            if ($var == '1') {
                if ($this->shconfig('tadmin') == '1') {
                    return '<span style="color:#'.$this->shconfig('ftadmin').';">'.$text.'</span>';
                } else {
                    return $text;
                }
            }
            if ($var == '2') {
                if ($this->shconfig('tuser') == '1') {
                    return '<span style="color:#'.$this->shconfig('ftuser').';">'.$text.'</span>';
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

    //Ich Bitte freundlichs darum diese function nicht zu entfernen oder zu verändern
    // Fix Anzeige no Table or return
    function version() {
        //$g_version = '4';   //HauptVersion
        //$u_version = '100'; //Update/Fixes
        //$i_version = 'P';   //Ilch Version 1.1 ...
        //check_version($url, $g_version, $u_version, $i_version);
        $vers= $this->version.' 2009-20015 &copy B.Masmann Support: <a target="_blank" href="http://www.ilch.de">ilch.de</a>';
        return $vers;
    }
}
?>