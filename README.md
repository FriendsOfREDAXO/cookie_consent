# Cookie Consent

Das AddOn stellt das "Cookie Consent"-Script von [Insites](https://cookieconsent.insites.com) zur Verfügung und generiert einen Code um die EU Cookie-Richtlinie zu erfüllen.

![Screenshot](https://github.com/FriendsOfREDAXO/cookie_consent/blob/assets/cookie%20consent.png?raw=true)

## Features

- Individuelle Darstellung des Cookie-Hinweis Banner
 - Auswahl der Textfarbe und des Textinhaltes
 - Auswahl der Hintergrundfarbe
 - Setzen der Datenschutzerklärung (interner oder externer Link)
 - Position des Cookie-Hinweis Banner
- Vorgefertigte Designs als Auswahl
- Konfigurationstest der gesetzten Farben
- Ausgabe-Code zum kopieren oder Funktion zum automatischen einfügen

## Rechtliches
Verwendung auf eigene Gefahr. 
Vor Verwendung des AddOns sollte die aktuelle Rechtslage (gerade in Deutschland) recherchiert werden. Das AddOn liefert nur das Skript. Eine Gewähr auf Rechtssicherheit ist nicht geggeben und wird auch nicht geleistet. 

## Installation

1. Über Installer laden oder ZIP-Datei im AddOn-Ordner entpacken, der Ordner muss „cookie_consent“ heißen.
2. AddOn installieren und aktivieren
3. Die mitgelieferten Javascript `cookie_consent_insites.js` und CSS `cookie_consent_insites.css` Dateien im Front-End vor dem schließenden `</head>`-Tag einbinden oder das Häkchen bei `CSS und JS automatisch einbinden` setzen (funktioniert nur in Verwendung mit Schritt 5)
4. Bevorzugtes Farbschema wählen oder ein eigenes erstellen
5. Den Hinweis mittels `echo cookie_consent::cookie_consent_output();` vor dem schließenden `</head>`- oder `</body>`-Tag aufrufen
6. Ausprobieren! :-)

> Alternativ: Im Reiter 'Konfigurations Test' den ausgegeben Code kopieren und in einem `<script></script>`-Block vor dem schließenden `</head>`- oder `</body>`-Tag einfügen oder in einer externen Datei verwenden.

## Modus

- Information:
  dem Nutzer wird mitgeteilt, dass die Webseite Cookies verwendet und der Nutzer diese aktzeptiert, wenn er weiterhin die Webseite nutzt
- Opt-Out:
  dem Nutzer wird mitgeteilt, dass die Webseite Cookies verwendet. Es wird ihm aber eine Schaltfläche zum Deaktivieren der Cookies bereitgestellt 
- Opt-In:
  dem Nutzer wird mitgeteilt, dass die Webseite Cookies verwenden möchte. Dem Nutzer wird eine Schaltfläche bereitgestellt, wo er die Cookies aktzeptieren oder ablehnen kann
 
**Achtung:** Die Opt-In und Opt-Out Methode stellt **nur** die Callbacks zu dem Ablehnen oder Aktzeptieren der Cookies bereit. [Callbacks](https://cookieconsent.insites.com/documentation/disabling-cookies/)

## Requirements

Cookie Consent bedient sich eines FOR-AddOns und benötigt dieses um zu funktionieren.
* [UI Tools](https://github.com/FriendsOfREDAXO/ui_tools) von [Tim Filler](https://github.com/elricco)

## Bugtracker

Du hast einen Fehler gefunden oder ein nettes Feature was du gerne hättest? [Lege ein Issue an](https://github.com/FriendsOfREDAXO/cookie_consent/issues)

## Lizenz

siehe [LICENSE.md](https://github.com/FriendsOfREDAXO/cookie_consent/blob/master/LICENSE)

"Cookie Consent" von Insites steht unter MIT Lizenz.

## Autor

**Friends Of REDAXO**

* http://www.redaxo.org
* https://github.com/FriendsOfREDAXO

**Projekt-Lead**

[Marcel Kuhmann](https://github.com/bloep)


## Credits:

First Release: [Christian Gehrke](https://github.com/chrison94)

Version 1.1.0 [Marcel Kuhmann](https://github.com/bloep)
