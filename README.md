# littleagenda
A clearly not perfect , but usable php calendar, it uses a sqlite datase for storing events.


Events are created by goig to http://path.to.script/agenda.php?newevent=PASSWORD
then filling the form and submitting. 

To keep up his data, this strip have to be able to write in his folder. If he isn't allowed to create the sqlite, 
nothing will work.

PASSWORD is a password in php code, you can change it at line 25 : define("PASSWORD",<your own>)

lot of work to do before it's totally reliable.

day in months aren't ajusted , an event just after the new year wont be show...

Graphical interface is really basic and can be better

