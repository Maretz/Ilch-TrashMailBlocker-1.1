<?php
# ilchClan Script (c) by Manuel Staechele
defined('main') or die('no direct access');
if (user_has_admin_right($menu, false) == false) die('F&uuml;r diese Installation ben&ouml;tigt man Administratorenrechte !<br /><a href="index.php">Zur Startseite</a>');
$modulby = 'Maretz.eu';
$script_name = 'Trash-Mail Blocker';
$script_vers = '1.0';
$ilch_vers = '1.1';
$ilch_update = 'P';
$erfolg = '';
$fehler = '';
$title = $allgAr['title'] . ' => ' . $script_name;
$hmenu = $script_name . ' Vers.: ' . $script_vers . ' f&uuml;r ilchClan ' . $ilch_vers . ' Vers.: ' . $ilch_update;
$design = new design($title, $hmenu, 1);
$design->header();
if (!isset($_POST['do'])) {
?>
        <form action="index.php?installation" method="POST">
        <input type="hidden" name="do" value="1">
        <table width="97%" class="border" border="0" cellspacing="1" cellpadding="3" align="center">
        <tr class="Chead" align="center" style="padding:8px">
         <td><h2><?php echo $script_name; ?> <small><a href="http://www.maretz.eu">by Maretz.eu</a></small></h2></td>
        </tr>
        <tr class="Cmite">
         <td align="left">
             <br />
            <div style="padding:10px;text-align:left;">
            <strong><u>Informationen:</u></strong><br /><br />
            <strong>Modulname:</strong> <?php echo $script_name; ?><br />
            <strong>Version:</strong> <?php echo $script_vers; ?><br />
            <strong>Entwickler:</strong> <?php echo $modulby; ?><br />
            Entwickelt f&uuml;r ilchClan Version <strong><?php echo $ilch_vers; ?> <?php echo $ilch_update; ?></strong> .<br><br>
            Mit dieser Erweiterung k&ouml;nnen Trashmail Anbieter bei der Registrierung blockiert werden.<br>Blacklist kann im Adminbereich verwaltet werden.<br><br>
            <b>Achtung! Es wird die include/contents/user/regist.php ersetzt. Ggf. vorher sichern!</b><br>
            </div>
            <br />
            <hr />
            <br />
            <div style="padding:10px;text-align:left;">
            <strong><u>Wichtig:</u></strong><br /><br />
            Machen Sie zuerst ein <a href="admin.php?backup" target="_blank" style="font-weight:bold;">Backup</a> Ihrer Datenbank, falls es doch zu unerwarteten Problemen kommt.<br />
            <br />
            </div>
         </td>
        </tr>
        <tr class="Cdark">
         <td align="center">
            <input type="submit" value="Modul Installieren" />
         </td>
        </tr>
        </table>
        </form>
<?php
}  else {
$error = '';
$sql_file = implode('', file('include/contents/installation.sql'));
$sql_file = preg_replace("/(\015\012|\015|\012)/", "\n", $sql_file);
$sql_statements = explode(";\n", $sql_file);
foreach($sql_statements as $sql_statement) {
if (trim($sql_statement) != '') {
#echo '<pre>'.$sql_statement.'</pre><hr>';
db_query($sql_statement) OR $error.= mysql_errno() . ': ' . mysql_error() . '<br />';
}
}
// Ausgabe

?>
        <table width="97%" class="border" border="0" cellspacing="1" cellpadding="3" align="center">
        <tr class="Chead" align="center" style="padding:8px">
         <td><h2><?php echo $script_name; ?> <small><a href="http://www.maretz.eu">by Maretz.eu</a></small></h2></td>
        </tr>
                <tr class="Cnorm" align="center">
         <td><h2>Installation abgeschlossen</td>
        </tr>
        <tr class="Cmite">
         <td colspan="3" align="center">
            <br />
<?php
if (!empty($error)) {
if (empty($fehler)) {
$fehler = 'Es sind Fehler bei der Installation aufgetreten!<br />Bitte benachrichtigen Sie den Entwickler.';
}
$fehler.= '<br /><br />Oben sollten Sie eine ausf&uuml;hrlichere Fehlermeldung sehen<br />.';
echo $fehler . '<br /><br /><hr /><br /><strong style="text-decoration:underline;">Fehlermeldungen:</strong><br /><br /><span style="color:#FF0000;font-size:bold;">' . $error . '</span>';
} else {
if (empty($erfolg)) {
$erfolg = 'Die Installation wurde erfolgreich abgeschlossen!';
}
if (@unlink('include/contents/installation.php') && @unlink('include/contents/installation.sql')) {
$erfolg.= '<br /><br />Diese Installationsdateien wurden erfolgreich gel&ouml;scht. Es muss nichts mehr getan werden.<br><br>Im Adminbereich > Konfiguration unter <b>Trash-Mail Blocker</b> kann die Blacklist bearbeitet werden.';
} else {
$erfolg.= '<br /><br /><strong>Die Installationsdateien konnten nicht automatisch gel&ouml;scht werden. L&ouml;schen Sie folgende Dateien:</strong><br /><br /><i>include/contents/installation.php</i><br /><i>include/contents/installation.sql</i><br><br>Im Adminbereich > Konfiguration unter <b>Trash-Mail Blocker</b> kann die Blacklist bearbeitet werden.';
}
echo $erfolg;
}
?>
            <br />
            <br />
         </td>
        </tr>
        <tr class="Chead">
         <td colspan="3" align="center">
            <button onclick="javascript:window.location.href = 'index.php';">Auf die Startseite</button>
         </td>
        </tr>
        </table>
      </td>
     </tr>
     </table>
<?php
}
$design->footer();
?>