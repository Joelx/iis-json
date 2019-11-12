LIKE-JSON Plugin fuer Wordpress
=========
Version 1.4.3 (Stand 12.11.2019)

Einbinden von Daten aus dem System des Lehrstuhls fuer Informationstechnik mit dem Schwerpunkt Kommunikationselektronik (LIKE).
Aktuell werden folgende Daten unterstuetzt:

Studentische Arbeiten


Shortcodes
==========

 - Alle Studentischen Arbeiten
   [like task="arbeiten-alle"]		
 - Nur bachelorarbeiten 
   [like task="bachelorarbeiten"]
 - Nur masterarbeiten 
   [like task="masterarbeiten"]
 - Nur Forschungspraktika 
   [like task="forschungspraktika"]
 - Nur Projektarbeiten 
   [like task="projektarbeiten"]  
  - Nur Sonstige Arbeiten 
   [like task="sonstig"]    
   
Moegliche Zusatzoptionen
==========
  - id="1467": nur die Arbeit mit dieser bestimmten ID.
  - format="accordion": Darstellung im Accordion Layout (default: "liste")
  - advisor="fischer": Alle Arbeiten eines bestimmten Betreuers. Angabe durch Nachname (Groß-/Kleinschreibung nicht relevant)
  - status="zu vergeben": nur die Arbeiten, die einen bestimmten Vergabestatus haben ("zu vergeben", "in Bearbeitung")
   
