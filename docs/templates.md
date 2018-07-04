
# Vorlagen

## Javascript Callbacks

Diese Beispiele können in der Konfiguration in das Feld "Benutzerdefinierte Optionen" eingegeben werden.
Weitere Infos zu Javascript-Callbacks [hier](https://cookieconsent.insites.com/documentation/javascript-api/)

### Seite neuladen
Wenn der Cookie-Banner bestätigt wurde, wird die Seite neu geladen. Hierdurch können serverseitig weitere Inhalte (Skripte, Marketing-Tools, etc.) eingebunden werden.

###### Konfigurationscode
```
onStatusChange: function(status, chosenBefore) {
    if(status === "allow") {
        location.reload();
    }
}
```

###### PHP-Code
```
if (cookie_consent::getStatus() === cookie_consent::COOKIE_ALLOW) {
    // Ausgabe von zusätzlichen Skripten, Marketing-Tools
}
```