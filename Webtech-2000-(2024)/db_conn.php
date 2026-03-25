<?php
putenv("ORACLE_SID=teaching");
if ($Connection = oci_connect("user", "password"))
{
print "Connection OK<br> \n";
$sql = "select * from ITEM";
// Parse Oracle query
$Statement = oci_parse($Connection, $sql);
// Execute Oracle query
oci_execute($Statement);
print "SQL query executed...<br> \n";
$numcols = oci_num_fields($Statement);
print "<table width=300 border=1><tr>";
for ($i=1; $i<=$numcols; $i++)
{
// Print column headings
 $colname = oci_field_name($Statement, $i);
 print "<td>$colname</td>";
}
 print "</tr>";
// Get a row and print it column by column
while (oci_fetch($Statement))
{
 print "<tr>";
 for ($i=1; $i<=$numcols; $i++)
{
 $col = oci_result($Statement, $i);
 PRINT "<td>$col</td>";
 }
print "</tr>";
}
print "</table>";
$numrows = oci_num_rows($Statement);
print "Table has $numcols columns and $numrows rows<br> \n";
oci_close($Connection);
print "Logged off.";
 }
else
 {
var_dump(oci_error($Connection));
 } // end of if expression
?>