----------------------------------------------------------------
Script     => ShBox V4.0P (c)2006-2015 by B.Masmann
Entwickler => WDS NachtWolf / B.Masmann
Seite/Sup. => http://www.ilch.de
Kontakt    => Masmann@gmx.de
----------------------------------------------------------------

Getestet und Entwickelt unter:
MySQL-Version : 5.6.25
phpMyAdmin    : 4.4.14.12
PHP-Version   : 5.6.12

INFO:
------
 * Die ShBox V4.0P ist eine eigenst�ndige Version und ist nicht mit der ShBox V3.2.2 lauff�hig!!
 * Die Einstellungen sind zwar gegen�ber der 3.2.2 �bersichtlicher aber Trotzdem sollte man sich zeit lassen und
   sich einen Grundliegenden �bersicht der Funktionen verschaffen, da es sonst schnell zu Problemen kommen k�nnte.
 * Weitere Ideen zur Erweiterung/Verbesserung der ShBox d�rfen gerne bei ilch.de ge�u�ert werden. 
 * Entwickelt und getestet �berwiegend mit der aktuellen Version von Firefox.
 

INSTALLATION:
----------------
 * Alle Daten aus dem Upload-Order hochladen (FTP);
 * BACKUP der Datenbank & Files machen.
 * Als Admin auf deiner Seite einloggen;
 * {DEINEDOMAIN.de/} admin.php?install ausf�hren und die Anweisungen befolgen.
   => Die Installation Entscheidet welche Option f�r dich Optimal w�hre. 
      * Exestiert die ShBox3, geht es mit einen Update weiter (Hier werden alle n�tigen Datein der ShBox3 ersetzt, �bernommen und gel�scht);
      * Benutzt du aktiv die Orginale Shoutbox von ilch wird die Installation mit �bernahme der DB gemacht. (Daten&Datein bleiben vorhanden)
      * Ist beides nicht der Fall wird eine normale installation durchgef�hrt.
 * WICHTIG => Nach erfolgreicher Installation/Update nochmals �berpr�fen ob alle unn�tigen Datein gel�scht wurden. Die Installation/Update f�hrt die L�schung alleine durch
              Aber bitte immer auf einer nummer sicher gehen.

* Die Box muss nur noch im Men� eingebunden werden (shbox4).
* Fals wenn ihr das Archiv im eingenden men� anzeigen wollt +
  Sollten unterseiten nicht sichbar sein f�r User
  M�sst ihr noch ein Men�punk erstellen mit internenlink auf ?shbox4-archiv; 

Viel Spa� mit der ShBox4 :)


LOG V4.000P:
-------------
Info:
Die neue Version wurde der alten gegen�ber ein wenig abgespeckt und erweitert. 
Gegen�ber der alten Version, ist diese Stabiler und bietet in der Handhabung eine viel bessere �bersicht.

Anregungen/Fehler und auch W�nsche k�nnen gerne auf ilch.de im entsprechenden Forum ge�u�ert werden.
 
NEU/FIX:
* Angepasste Installation;
* Unn�tige funktionen entfernt;
* Script �bersichtlicher gestaltet;
* Java&Ajaxscript l�uft Fehlerfrei; 
* IP wird nicht mehr gespeichert;
* Schlichter SPAM-Schutz f�r G�ste;
* L�sst sich im Adminberreich leichter ans Design anpassen;
* Die Eingabe, wenn man auf gewisse unterseiten ist (z.b Forum) ist gesperrt um Komplikationen
  bei eingabe von Smilies und BBcode zu vermeiden. (Wird in sp�tere Version noch erweitert);

Die Box:
* Unn�tige Grafische darstellunegn wurden entfernt (unter anderen die Linien);
* Textarea Feld wurde durch ein input Feld ersetzt und das Absenden erfolg durch dr�cken der Enter-Taste;
* Abgesendete Daten werden im Hintergrund verabeitet, ein Reload der Seite findet nicht mehr statt;
* Smilies diekt von ilch verwendbar;
* Eingeschr�nkte BBcode Auswahl �ber Button w�hlbar (Wird in sp�tere Version noch erweitert);

Die Administration:
* �bersichtlicher gestaltet;
* Eintr�ge verden Jeweils mit ENTER und Mausklick get�tigt.


LOG V3.2.2 & V3.2.2 FIX V1&2:
-----------------------------
 * angepasst an Ilch 1.1P by Lord|Schirmer
 * Installation & Struktur ge�ndert
 * Notices und Deprecated Fehler entfernt
 * Eintr�ge ohne Texteintr�ge nicht mehr m�glich
 * Fehler im Smilies (mehr... Fenster) behoben
 * Der Fehler, das Eintr�ge in der ShBox gemacht wurden, obwohl man ein gaz anderes Formular abgesendet hat (z.b Profil), wurde behoben
 * Sicherheitsl�cken geschlossen:
 * Adminberreich Benutzerfreundlicher angepasst
 * Direktzugriffe unterbunden
 * header() angepasst

 
ALLGEMEIN:
-------------
 * Der Entwickler �bernimmt keine Haftung f�r Sch�den, die durch dieses Skript entstehen.
 * Benutzung auf eignender Gefahr.
 * Das Copyright im Quelltext darf ohne Zustimmung des Entwicklers nicht entfernt werden.
 * Das Script darf beliebig ver�ndert werden, das Copyright bleibt aber auch in diesen Falle unber�hrt.
 * Das Script, auch abge�nderte Versionen d�rfen ausschlie�lich nur auf http://www.ilch.de und beim Entwickler zum Download angeboten werden.
   ** Ange�nderte Versionen d�rfen gerne den Entwickler Vorgeschlagen werden und werden nach entsprechender Pr�fung im Update mit eingef�gt oder als Extra angeboten.
 * Das Script darf nicht kostenpflichtig verbreitet werden.
 * Die Grundlagen und Copyright von ilch.de bleiben unber�hrt.
 * Verst��e werden strafrechtlich verfolgt.