# Switch Connector
Das Modul erlaubt es, einen 4 Kanal Schalter mit Variablen/Szenen zu verbinden.
Damit kann mit bis zu 4 Kanälen einebeliebige Variable true/false geschaltet oder eine Szene aufgerufen werden

### Inhaltsverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Statusvariablen und Profile](#5-statusvariablen-und-profile)
6. [Konfiguration](#6-konfiguration)
7. [Visualisierung](#7-visualisierung)
8. [PHP-Befehlsreferenz](#8-php-befehlsreferenz)


### 1. Funktionsumfang

* Schaltvorgänge von bis zu 4 Eingangsvariablen überwachen und Ausgangsvariablen schalten

### 2. Voraussetzungen

- IP-Symcon ab Version 7.1

### 3. Software-Installation

* Über den Module Store das 'Switch-Connector'-Modul installieren.
* Alternativ über das Module Control folgende URL hinzufügen: https://github.com/migodev/SwitchConnector

### 4. Einrichten der Instanzen in IP-Symcon

 Unter 'Instanz hinzufügen' kann das 'Switch Connector'-Modul mithilfe des Schnellfilters gefunden werden.  
	- Weitere Informationen zum Hinzufügen von Instanzen in der [Dokumentation der Instanzen](https://www.symcon.de/service/dokumentation/konzepte/instanzen/#Instanz_hinzufügen)

### 5. Statusvariablen und Profile

Es werden keine Profile angelegt.
Es werden keine Statusvariablen angelegt

### 6. Konfiguration

| Eigenschaft                                           |   Typ   | Standardwert | Funktion                                                  |
|:------------------------------------------------------|:-------:|:-------------|:----------------------------------------------------------|
| Eingangsvariable                                      | integer | 0            | Die TasterVariable auf die reagiert werden soll, z.B. Status AO oder Gedrückt |
| Eingangswert                                      	| integer | 0            | Auf welchen Wert soll reagiert werden, true, false oder beides. Nur wenn dieser Wert durch die Eingangsvariable ausgelöst wird, wird auf der Ausgangsvariable geschaltet. |
| Ausgangsvariable                                      | integer | 0            | Die Variable die geschaltet werden soll, wenn die Eingangsvariable mit dem Eingangswert ausgelöst wird. |
| Ausgangswert                                          | integer | 0            | Schaltet den ausgewählten Wert (true, false, Szene Aufrufen, Wert umschalten) <br /><br /><i>Szene Aufrufen:</i> Aus dem Szenenmodul muss in der Ausgangsvariable eine Szenenvariable gewählt werden.<br /><i>Wert umschalten:</i> wechselt bool mit true/false, integer & float mit 0/100, string mit "true"/"false" |

### 7. Visualisierung

Das Modul bietet keine Funktion in der Visualisierung.

### 8. PHP-Befehlsreferenz

Keine