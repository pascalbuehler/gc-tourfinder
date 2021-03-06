### Matrix Abgleich
#### Idee
Zu den Tagestouren jeweils anzeigen wie viele Caches dabei sind für den:

1. Aktuellen Loop der Matrix
2. Den nächsten Loop der Matrix

Zusätzlich in der Liste der Caches die betreffenden Caches markieren.

#### Zusätzlich benötigt
* API: Abrufen der Statistik des Benutzer
* Eingabefeld für den aktuellen Benutzer für den die Matrix-Statistik abgerufen wird

### Favorit von Benutzer
#### Idee
Anzeigen welche Caches vom abgefragen Benutzer favorisiert wurden. Das blaue Herz in diesem Fall grün anzeigen.

#### Zusätzlich benötigt
* API: Abrufen der Favoriten des Benutzer

### Höhenprofil
#### Idee
Das Höhenprofil als Graph einer Cachetour ausgeben.
#### Zusätzlich benötigt
* Google Maps Elevation API (https://developers.google.com/maps/documentation/elevation/intro?hl=de)
* Irgendein Javascript Graphtool, eventuell auch gleich das von google (siehe letztes Beispiel)
#### Probleme
* Funktioniert nur wenn die Logreihenfolge stimmt
* Berücksichtigt im einfachsten Fall nur die Höhenangaben der Caches. Ansonsten mit Google Maps Routing auch detaillierter möglich.

### PDF versenden
#### Idee
Wöchentlich (mit Cron) ein E-Mail versenden mit einem PDF der Caches die von jemandem letzte Woche gemacht wurden.
#### Probleme
* Nicht geloggte Caches erscheinen natürlich nicht (eventuell voletzte Woche versenden?)
#### Proof of concept
* Print-Mode ist eingebaut
* wkhtmltopdf --print-media-type "http://gc-tourfinder.frigidor.ch/usertours?username=mfbaden&fromDate=20181221&toDate=20181228" abc.pdf

