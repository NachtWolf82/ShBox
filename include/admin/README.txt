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
 * Die ShBox V4.0P ist eine eigenständige Version und ist nicht mit der ShBox V3.2.2 lauffähig!!
 * Die Einstellungen sind zwar gegenüber der 3.2.2 übersichtlicher aber Trotzdem sollte man sich zeit lassen und
   sich einen Grundliegenden übersicht der Funktionen verschaffen, da es sonst schnell zu Problemen kommen könnte.
 * Weitere Ideen zur Erweiterung/Verbesserung der ShBox dürfen gerne bei ilch.de geäußert werden. 
 * Entwickelt und getestet überwiegend mit der aktuellen Version von Firefox.
 

INSTALLATION:
----------------
 * Alle Daten aus dem Upload-Order hochladen (FTP);
 * BACKUP der Datenbank & Files machen.
 * Als Admin auf deiner Seite einloggen;
 * {DEINEDOMAIN.de/} admin.php?install ausführen und die Anweisungen befolgen.
   => Die Installation Entscheidet welche Option für dich Optimal währe. 
      * Exestiert die ShBox3, geht es mit einen Update weiter (Hier werden alle nötigen Datein der ShBox3 ersetzt, übernommen und gelöscht);
      * Benutzt du aktiv die Orginale Shoutbox von ilch wird die Installation mit übernahme der DB gemacht. (Daten&Datein bleiben vorhanden)
      * Ist beides nicht der Fall wird eine normale installation durchgeführt.
 * WICHTIG => Nach erfolgreicher Installation/Update nochmals überprüfen ob alle unnötigen Datein gelöscht wurden. Die Installation/Update führt die Löschung alleine durch
              Aber bitte immer auf einer nummer sicher gehen.

* Die Box muss nur noch im Menü eingebunden werden (shbox4).
* Fals wenn ihr das Archiv im eingenden menü anzeigen wollt +
  Sollten unterseiten nicht sichbar sein für User
  Müsst ihr noch ein Menüpunk erstellen mit internenlink auf ?shbox4-archiv; 

Viel Spaß mit der ShBox4 :)


LOG V4.000P:
-------------
Info:
Die neue Version wurde der alten gegenüber ein wenig abgespeckt und erweitert. 
Gegenüber der alten Version, ist diese Stabiler und bietet in der Handhabung eine viel bessere übersicht.

Anregungen/Fehler und auch Wünsche können gerne auf ilch.de im entsprechenden Forum geäußert werden.
 
NEU/FIX:
* Angepasste Installation;
* Unnötige funktionen entfernt;
* Script übersichtlicher gestaltet;
* Java&Ajaxscript läuft Fehlerfrei; 
* IP wird nicht mehr gespeichert;
* Schlichter SPAM-Schutz für Gäste;
* Lässt sich im Adminberreich leichter ans Design anpassen;
* Die Eingabe, wenn man auf gewisse unterseiten ist (z.b Forum) ist gesperrt um Komplikationen
  bei eingabe von Smilies und BBcode zu vermeiden. (Wird in spätere Version noch erweitert);

Die Box:
* Unnötige Grafische darstellunegn wurden entfernt (unter anderen die Linien);
* Textarea Feld wurde durch ein input Feld ersetzt und das Absenden erfolg durch drücken der Enter-Taste;
* Abgesendete Daten werden im Hintergrund verabeitet, ein Reload der Seite findet nicht mehr statt;
* Smilies diekt von ilch verwendbar;
* Eingeschränkte BBcode Auswahl über Button wählbar (Wird in spätere Version noch erweitert);

Die Administration:
* Übersichtlicher gestaltet;
* Einträge verden Jeweils mit ENTER und Mausklick getätigt.


LOG V3.2.2 & V3.2.2 FIX V1&2:
-----------------------------
 * angepasst an Ilch 1.1P by Lord|Schirmer
 * Installation & Struktur geändert
 * Notices und Deprecated Fehler entfernt
 * Einträge ohne Texteinträge nicht mehr möglich
 * Fehler im Smilies (mehr... Fenster) behoben
 * Der Fehler, das Einträge in der ShBox gemacht wurden, obwohl man ein gaz anderes Formular abgesendet hat (z.b Profil), wurde behoben
 * Sicherheitslücken geschlossen:
 * Adminberreich Benutzerfreundlicher angepasst
 * Direktzugriffe unterbunden
 * header() angepasst

 
ALLGEMEIN:
-------------
 * Der Entwickler übernimmt keine Haftung für Schäden, die durch dieses Skript entstehen.
 * Benutzung auf eignender Gefahr.
 * Das Copyright im Quelltext darf ohne Zustimmung des Entwicklers nicht entfernt werden.
 * Das Script darf beliebig verändert werden, das Copyright bleibt aber auch in diesen Falle unberührt.
 * Das Script, auch abgeänderte Versionen dürfen ausschließlich nur auf http://www.ilch.de und beim Entwickler zum Download angeboten werden.
   ** Angeänderte Versionen dürfen gerne den Entwickler Vorgeschlagen werden und werden nach entsprechender Prüfung im Update mit eingefügt oder als Extra angeboten.
 * Das Script darf nicht kostenpflichtig verbreitet werden.
 * Die Grundlagen und Copyright von ilch.de bleiben unberührt.
 * Verstöße werden strafrechtlich verfolgt.